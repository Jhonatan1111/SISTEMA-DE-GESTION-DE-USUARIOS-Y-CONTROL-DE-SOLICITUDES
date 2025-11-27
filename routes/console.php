<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('backup:project', function () {
    $basePath = base_path();
    $timestamp = now()->format('Ymd_His');
    $backupDir = storage_path('app/private/backups');
    if (!File::exists($backupDir)) {
        File::makeDirectory($backupDir, 0755, true);
    }
    $zipPath = $backupDir . DIRECTORY_SEPARATOR . 'backup_' . $timestamp . '.zip';

    $include = [
        'app',
        'bootstrap',
        'config',
        'database',
        'storage',
        'public',
        'resources',
        'routes',
        '.env',
        'composer.json',
        'composer.lock',
        'package.json',
        'package-lock.json',
        'phpunit.xml',
        'artisan',
        'Dockerfile',
        'docker-compose.yml',
        'README.md',
    ];

    $exclude = [
        'vendor',
        'node_modules',
        '.git',
        'storage' . DIRECTORY_SEPARATOR . 'framework',
        'storage' . DIRECTORY_SEPARATOR . 'logs',
        'storage' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'backups',
    ];

    $addPathToZip = function ($zip, $path, $base) use ($exclude) {
        $realPath = realpath($path);
        if ($realPath === false) {
            return;
        }
        foreach ($exclude as $ex) {
            if (str_contains($realPath, DIRECTORY_SEPARATOR . $ex)) {
                return;
            }
        }
        if (is_dir($realPath)) {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($realPath, FilesystemIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($iterator as $file) {
                $filePath = (string) $file;
                foreach ($exclude as $ex) {
                    if (str_contains($filePath, DIRECTORY_SEPARATOR . $ex)) {
                        continue 2;
                    }
                }
                if ($file->isDir()) {
                    $localName = ltrim(str_replace($base, '', $filePath), DIRECTORY_SEPARATOR);
                    if ($localName !== '') {
                        $zip->addEmptyDir(str_replace(DIRECTORY_SEPARATOR, '/', $localName));
                    }
                } else {
                    $localName = ltrim(str_replace($base, '', $filePath), DIRECTORY_SEPARATOR);
                    $zip->addFile($filePath, str_replace(DIRECTORY_SEPARATOR, '/', $localName));
                }
            }
        } else {
            $localName = ltrim(str_replace($base, '', $realPath), DIRECTORY_SEPARATOR);
            $zip->addFile($realPath, str_replace(DIRECTORY_SEPARATOR, '/', $localName));
        }
    };

    $sqlitePath = null;
    $defaultConn = config('database.default');
    if ($defaultConn === 'sqlite') {
        $sqlitePath = config('database.connections.sqlite.database');
        if ($sqlitePath && File::exists($sqlitePath)) {
            $include[] = str_replace($basePath . DIRECTORY_SEPARATOR, '', $sqlitePath);
        }
    }

    if (class_exists(ZipArchive::class)) {
        $zip = new ZipArchive();
        $opened = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        if ($opened !== true) {
            $this->error('No se pudo crear el archivo ZIP');
            return 1;
        }
        foreach ($include as $item) {
            $path = $basePath . DIRECTORY_SEPARATOR . $item;
            $addPathToZip($zip, $path, $basePath);
        }
        $zip->close();
        $this->info('Respaldo creado: ' . $zipPath);
        return 0;
    }

    $fallbackDir = $backupDir . DIRECTORY_SEPARATOR . 'backup_' . $timestamp;
    File::makeDirectory($fallbackDir, 0755, true);
    foreach ($include as $item) {
        $src = $basePath . DIRECTORY_SEPARATOR . $item;
        if (File::isDirectory($src)) {
            File::copyDirectory($src, $fallbackDir . DIRECTORY_SEPARATOR . $item);
        } elseif (File::exists($src)) {
            File::copy($src, $fallbackDir . DIRECTORY_SEPARATOR . basename($src));
        }
    }
    $this->info('Respaldo creado: ' . $fallbackDir);
    return 0;
})->purpose('Crear un respaldo del proyecto');
