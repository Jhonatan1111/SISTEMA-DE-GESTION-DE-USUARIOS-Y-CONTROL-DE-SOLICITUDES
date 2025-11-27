<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class UtilController extends Controller
{
    //
    public function credits()
    {
        return view('utils.credits');
    }

    private function descargarManual(string $filename, string $downloadName)
    {
        $path = public_path('manuales/' . $filename);
        if (file_exists($path)) {
            return response()->file($path, ['Content-Type' => 'application/pdf']);
        }
        $html = "<h1 style='font-family: DejaVu Sans; font-size: 22px;'>Manual no disponible</h1><p>El archivo <strong>{$filename}</strong> no se encontró en <code>public/manuales</code>. Este PDF es un reemplazo temporal.</p>";
        $pdf = Pdf::loadHTML($html);
        return $pdf->stream($downloadName);
    }

    // CENTRO DE APOYO
    public function help()
    {
        return view('utils.help');
    }

    public function descargarUsuario()
    {
        return $this->descargarManual('usuario.pdf', 'manual-usuario.pdf');
    }

    public function descargarAdministrador()
    {
        return $this->descargarManual('administrador.pdf', 'manual-administrador.pdf');
    }

    public function descargarCapacitacion()
    {
        return $this->descargarManual('capacitacion.pdf', 'manual-capacitacion.pdf');
    }

    public function descargarImplementacion()
    {
        return $this->descargarManual('implementacion.pdf', 'manual-implementacion.pdf');
    }

    // ADMIN: Backups UI
    public function backupsIndex()
    {
        $dir = storage_path('app/private/backups');
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        $files = collect(File::files($dir))
            ->sortByDesc(fn($f) => $f->getCTime())
            ->map(function ($f) {
                return [
                    'name' => $f->getFilename(),
                    'path' => $f->getPathname(),
                    'size' => $f->getSize(),
                    'time' => $f->getCTime(),
                ];
            });
        $uploadMax = ini_get('upload_max_filesize');
        $postMax = ini_get('post_max_size');
        return view('admin.backups.index', compact('files', 'uploadMax', 'postMax'));
    }

    public function backupsStore()
    {
        Artisan::call('backup:project');
        return redirect()->route('admin.backups.index')
            ->with('success', 'Respaldo creado correctamente');
    }

    public function backupsStoreDatos()
    {
        $basePath = base_path();
        $timestamp = now()->format('Ymd_His');
        $backupDir = storage_path('app/private/backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }
        $zipPath = $backupDir.DIRECTORY_SEPARATOR.'datos_'.$timestamp.'.zip';

        $zip = new \ZipArchive();
        $opened = $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        if ($opened !== true) {
            return redirect()->route('admin.backups.index')->with('error', 'No se pudo crear el archivo ZIP de datos');
        }

        // Incluir almacenamiento de archivos de usuarios (excluyendo logs/framework/backups)
        $storageSrc = storage_path('app');
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($storageSrc, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($iterator as $file) {
            $filePath = (string) $file;
            if (str_contains($filePath, DIRECTORY_SEPARATOR.'framework') || str_contains($filePath, DIRECTORY_SEPARATOR.'logs') || str_contains($filePath, DIRECTORY_SEPARATOR.'private'.DIRECTORY_SEPARATOR.'backups')) {
                continue;
            }
            $localName = ltrim(str_replace($basePath, '', $filePath), DIRECTORY_SEPARATOR);
            $localName = str_replace(DIRECTORY_SEPARATOR, '/', $localName);
            if ($file->isDir()) {
                $zip->addEmptyDir($localName);
            } else {
                $zip->addFile($filePath, $localName);
            }
        }

        // Respaldar base de datos
        $defaultConn = config('database.default');
        if ($defaultConn === 'sqlite') {
            $sqlitePath = config('database.connections.sqlite.database');
            if ($sqlitePath && File::exists($sqlitePath)) {
                $zip->addFile($sqlitePath, 'database/database.sqlite');
            }
        } else {
            $dbName = config('database.connections.'.$defaultConn.'.database');
            $tables = DB::select('SELECT table_name FROM information_schema.tables WHERE table_schema = ?', [$dbName]);
            $exclude = ['migrations', 'jobs', 'failed_jobs', 'cache'];
            $dump = [];
            foreach ($tables as $t) {
                $table = is_object($t) ? (array) $t : $t;
                $name = $table[array_key_first($table)];
                if (in_array($name, $exclude, true)) {
                    continue;
                }
                $rows = DB::table($name)->get();
                $dump[$name] = $rows->map(fn($r) => (array) $r)->toArray();
            }
            $zip->addFromString('database/database_dump.json', json_encode($dump));
        }

        $zip->close();
        return redirect()->route('admin.backups.index')->with('success', 'Respaldo de datos creado: '.basename($zipPath));
    }

    public function backupsDownload(string $filename)
    {
        $path = storage_path('app/private/backups/'.$filename);
        if (!File::exists($path)) {
            return redirect()->route('admin.backups.index')
                ->with('error', 'Archivo no encontrado');
        }
        return response()->download($path, $filename);
    }

    public function backupsDestroy(string $filename)
    {
        $path = storage_path('app/private/backups/'.$filename);
        if (File::exists($path)) {
            File::delete($path);
            return redirect()->route('admin.backups.index')
                ->with('success', 'Respaldo eliminado');
        }
        return redirect()->route('admin.backups.index')
            ->with('error', 'Archivo no encontrado');
    }

    public function backupsRestore()
    {
        request()->validate([
            'file' => ['required', 'file', 'mimes:zip']
        ]);
        $uploaded = request()->file('file');
        $tmpDir = storage_path('app/private/tmp_restore_'.uniqid());
        File::makeDirectory($tmpDir, 0755, true);

        $zip = new \ZipArchive();
        if ($zip->open($uploaded->getPathname()) !== true) {
            return redirect()->route('admin.backups.index')->with('error', 'No se pudo abrir el ZIP');
        }
        $zip->extractTo($tmpDir);
        $zip->close();

        // Restaurar storage
        $extractedStorage = $tmpDir.DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.'app';
        if (File::isDirectory($extractedStorage)) {
            $targetStorage = storage_path('app');
            File::copyDirectory($extractedStorage, $targetStorage);
        }

        // Restaurar base de datos
        $defaultConn = config('database.default');
        if ($defaultConn === 'sqlite') {
            $sqliteFile = $tmpDir.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'database.sqlite';
            $targetSqlite = config('database.connections.sqlite.database');
            if ($targetSqlite && File::exists($sqliteFile)) {
                File::copy($sqliteFile, $targetSqlite);
            }
        } else {
            $dumpFile = $tmpDir.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'database_dump.json';
            if (File::exists($dumpFile)) {
                $json = json_decode(File::get($dumpFile), true);
                if (is_array($json)) {
                    DB::statement('SET FOREIGN_KEY_CHECKS=0');
                    foreach ($json as $table => $rows) {
                        DB::table($table)->delete();
                        DB::statement('ALTER TABLE `'.$table.'` AUTO_INCREMENT = 1');
                        foreach (array_chunk($rows, 1000) as $chunk) {
                            DB::table($table)->insert($chunk);
                        }
                    }
                    DB::statement('SET FOREIGN_KEY_CHECKS=1');
                }
            }
        }

        File::deleteDirectory($tmpDir);
        return redirect()->route('admin.backups.index')->with('success', 'Restauración completada');
    }
}
