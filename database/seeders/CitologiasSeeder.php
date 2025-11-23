<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Citolgia;
use App\Models\Doctor;
use App\Models\Paciente;
use Illuminate\Support\Str;

class CitologiasSeeder extends Seeder
{
    public function run(): void
    {
        $doctores = Doctor::where('estado_servicio', true)->pluck('id')->all();
        if (count($doctores) === 0) {
            for ($i = 1; $i <= 3; $i++) {
                $doctor = Doctor::create([
                    'nombre' => 'Doctor'.$i,
                    'apellido' => 'Demo',
                    'jvpm' => 'JVP'.str_pad((string)$i, 6, '0', STR_PAD_LEFT),
                    'estado_servicio' => true,
                ]);
                $doctores[] = $doctor->id;
            }
        }

        $pacientes = Paciente::pluck('id')->all();
        if (count($pacientes) === 0) {
            for ($i = 1; $i <= 10; $i++) {
                $paciente = Paciente::create([
                    'nombre' => 'Paciente'.$i,
                    'apellido' => 'Demo',
                    'edad' => rand(18, 80),
                    'sexo' => rand(0,1) ? 'M' : 'F',
                    'dui' => str_pad((string)rand(0, 99999999), 8, '0', STR_PAD_LEFT),
                ]);
                $pacientes[] = $paciente->id;
            }
        }

        $tipos = ['normal', 'liquida', 'especial'];
        foreach ($tipos as $tipo) {
            for ($i = 0; $i < 10; $i++) {
                $nc = Citolgia::generarNumeroCitologia($tipo);
                $fecha = now()->subDays(rand(0, 60))->format('Y-m-d');
                $pacienteId = $pacientes[array_rand($pacientes)];
                $datos = [
                    'ncitologia' => $nc,
                    'diagnostico_clinico' => 'Dx '.Str::title(Str::random(8)).' '.Str::title(Str::random(6)),
                    'fecha_recibida' => $fecha,
                    'tipo' => $tipo,
                    'estado' => (bool)rand(0, 1),
                    'paciente_id' => $pacienteId,
                    'mascota_id' => null,
                    'lista_id' => null,
                ];

                if ($tipo === 'especial') {
                    $datos['doctor_id'] = null;
                    $datos['remitente_especial'] = 'Clínica '.Str::title(Str::random(5));
                    $datos['celular_remitente_especial'] = (string)rand(60000000, 79999999);
                } else {
                    $datos['doctor_id'] = $doctores[array_rand($doctores)];
                    $datos['remitente_especial'] = null;
                    $datos['celular_remitente_especial'] = null;
                }

                Citolgia::create($datos);
            }
        }
    }
}