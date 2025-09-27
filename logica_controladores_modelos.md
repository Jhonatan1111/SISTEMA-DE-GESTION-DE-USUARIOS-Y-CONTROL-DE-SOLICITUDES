# Lógica de Controladores y Modelos - Sistema de Gestión de Biopsias

## CONTROLADORES

### 1. DoctorController.php
```php
<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    // Listar doctores - Tanto admin como empleado pueden ver
    public function index()
    {
        $doctores = Doctor::orderBy('nombre')->paginate(10);
        return view('doctores.index', compact('doctores'));
    }

    // Crear doctor - Solo admin
    public function create()
    {
        return view('doctores.create');
    }

    // Guardar doctor en la base de datos - Solo admin
    public function store(Request $request)
    {
        $request->validate([
            'jvpm' => 'required|string|max:10|unique:doctores',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:500',
            'celular' => 'required|digits:8|unique:doctores',
            'fax' => 'nullable|digits:11|unique:doctores',
            'correo' => 'nullable|string|email|max:255|unique:doctores',
        ]);

        Doctor::create([
            'jvpm' => $request->jvpm,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'direccion' => $request->direccion,
            'celular' => $request->celular,
            'fax' => $request->fax,
            'correo' => $request->correo,
            'estado_servicio' => true,
        ]);

        return redirect()->route('doctores.index')->with('success', 'Doctor creado exitosamente.');
    }

    // Editar doctor - Solo admin
    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('doctores.edit', compact('doctor'));
    }

    // Actualizar doctor - Solo admin
    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $request->validate([
            'jvpm' => 'required|string|max:10|unique:doctores,jvpm,' . $doctor->id,
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:500',
            'celular' => 'required|digits:8|unique:doctores,celular,' . $doctor->id,
            'fax' => 'nullable|digits:11|unique:doctores,fax,' . $doctor->id,
            'correo' => 'nullable|string|email|max:255|unique:doctores,correo,' . $doctor->id,
        ]);

        $doctor->update([
            'jvpm' => $request->jvpm,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'direccion' => $request->direccion,
            'celular' => $request->celular,
            'fax' => $request->fax,
            'correo' => $request->correo,
            'estado_servicio' => $request->input('estado_servicio') == '1',
        ]);

        return redirect()->route('doctores.index')->with('success', 'Doctor actualizado exitosamente.');
    }

    // Eliminar doctor - Solo admin
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        try {
            $doctor->delete();
            return redirect()->route('doctores.index')
                ->with('success', 'Doctor eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('doctores.index')
                ->with('error', 'No se puede eliminar el doctor porque tiene registros asociados');
        }
    }
}
```

### 2. PacienteController.php
```php
<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    // Mostrar pacientes
    public function index()
    {
        $pacientes = Paciente::orderBy('nombre')->paginate(10);
        return view('pacientes.index', compact('pacientes'));
    }

    // Crear paciente
    public function create()
    {
        return view('pacientes.create');
    }

    // Guardar paciente
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dui' => 'string|unique:pacientes',
            'edad' => 'required|integer',
            'sexo' => 'required|string|in:masculino,femenino',
            'fecha_nacimiento' => 'date',
            'estado_civil' => 'string',
            'ocupacion' => 'string',
            'correo' => 'string|email|unique:pacientes',
            'direccion' => 'nullable|string|max:500',
            'celular' => 'required|digits:8|unique:pacientes',
        ]);

        Paciente::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dui' => $request->dui,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'estado_civil' => $request->estado_civil,
            'ocupacion' => $request->ocupacion,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'celular' => $request->celular,
        ]);

        return redirect()->route('pacientes.index')->with('success', 'Paciente creado exitosamente.');
    }

    // Editar paciente
    public function edit($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('pacientes.edit', compact('paciente'));
    }

    // Actualizar paciente
    public function update(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);

        $paciente->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'dui' => $request->dui,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'estado_civil' => $request->estado_civil,
            'ocupacion' => $request->ocupacion,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'celular' => $request->celular,
        ]);

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado exitosamente.');
    }
}
```

### 3. MascotaController.php
```php
<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    // Mostrar mascotas
    public function index()
    {
        $mascotas = Mascota::orderBy('nombre')->paginate(10);
        return view('mascotas.index', compact('mascotas'));
    }

    // Crear mascota
    public function create()
    {
        return view('mascotas.create');
    }

    // Guardar mascota
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'edad' => 'required|integer',
            'sexo' => 'required|string|in:macho,hembra',
            'especie' => 'string|max:255',
            'raza' => 'string|max:255',
            'propietario' => 'string|max:255',
            'correo' => 'string|email|unique:mascotas,correo',
            'celular' => 'required|digits:8|unique:mascotas,celular',
        ]);

        Mascota::create([
            'nombre' => $request->nombre,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'especie' => $request->especie,
            'raza' => $request->raza,
            'propietario' => $request->propietario,
            'correo' => $request->correo,
            'celular' => $request->celular,
        ]);

        return redirect()->route('mascotas.index')->with('success', 'Mascota creada exitosamente.');
    }

    // Editar mascota
    public function edit($id)
    {
        $mascota = Mascota::findOrFail($id);
        return view('mascotas.edit', compact('mascota'));
    }

    // Actualizar mascota
    public function update(Request $request, $id)
    {
        $mascota = Mascota::findOrFail($id);

        $mascota->update([
            'nombre' => $request->nombre,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'especie' => $request->especie,
            'raza' => $request->raza,
            'propietario' => $request->propietario,
            'correo' => $request->correo,
            'celular' => $request->celular,
        ]);

        return redirect()->route('mascotas.index')->with('success', 'Mascota actualizada exitosamente.');
    }

    // Eliminar mascota
    public function destroy($id)
    {
        $mascota = Mascota::findOrFail($id);
        try {
            $mascota->delete();
            return redirect()->route('mascotas.index')
                ->with('success', 'Mascota eliminada exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('mascotas.index')
                ->with('error', 'No se puede eliminar la mascota porque tiene registros asociados');
        }
    }
}
```

### 4. UserAdminController.php
```php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserAdminController extends Controller
{
    // Mostrar lista de usuarios
    public function index()
    {
        $usuarios = User::orderBy('created_at', 'desc')->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('admin.usuarios.create');
    }

    // Guardar nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'celular' => 'nullable|digits:8|unique:usuarios,celular',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:4|confirmed',
            'role' => 'required|in:admin,empleado'
        ]);

        User::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'celular' => $request->celular,
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado exitosamente');
    }

    // Mostrar formulario de edición
    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    // Actualizar usuario
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'celular' => 'nullable|digits:8',
            'email' => ['required', 'email', Rule::unique('usuarios')->ignore($usuario->id)],
            'password' => 'nullable|min:4|confirmed',
            'role' => 'required|in:admin,empleado'
        ]);

        $data = [
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'role' => $request->role,
            'celular' => $request->celular,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente');
    }

    // Eliminar usuario
    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }
}
```

### 5. BiopsiaController.php (Vista General)
```php
<?php

namespace App\Http\Controllers;

use App\Models\Biopsia;
use Illuminate\Http\Request;

class BiopsiaController extends Controller
{
    // Vista general de todas las biopsias (personas y mascotas)
    public function index(Request $request)
    {
        $query = Biopsia::with(['paciente', 'mascota', 'doctor'])
            ->activas()
            ->orderBy('fecha_recibida', 'desc');

        // Filtro por tipo
        if ($request->has('tipo') && $request->tipo !== '') {
            if ($request->tipo === 'personas') {
                $query->personas();
            } elseif ($request->tipo === 'mascotas') {
                $query->mascotas();
            }
        }

        // Filtro por búsqueda
        if ($request->has('buscar') && $request->buscar !== '') {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nbiopsia', 'like', "%{$buscar}%")
                    ->orWhere('diagnostico_clinico', 'like', "%{$buscar}%")
                    ->orWhereHas('paciente', function ($subq) use ($buscar) {
                        $subq->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('mascota', function ($subq) use ($buscar) {
                        $subq->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('propietario', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('doctor', function ($subq) use ($buscar) {
                        $subq->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%");
                    });
            });
        }

        $biopsias = $query->paginate(15);
        return view('biopsias.index', compact('biopsias'));
    }

    // Eliminar biopsia (solo admin)
    public function destroy($nbiopsia)
    {
        $biopsia = Biopsia::findOrFail($nbiopsia);
        $biopsia->delete();
        
        return redirect()->route('biopsias.index')
            ->with('success', 'Biopsia eliminada exitosamente');
    }
}
```

### 6. BiopsiaArchivarController.php
```php
<?php

namespace App\Http\Controllers;

use App\Models\Biopsia;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BiopsiaArchivarController extends Controller
{
    // Mostrar biopsias archivadas
    public function index(Request $request)
    {
        $query = Biopsia::with(['paciente', 'mascota', 'doctor'])
            ->where('estado', false)
            ->orderBy('fecha_recibida', 'desc');

        // Filtros similares al controlador principal
        if ($request->has('tipo') && $request->tipo !== '') {
            if ($request->tipo === 'personas') {
                $query->personas();
            } elseif ($request->tipo === 'mascotas') {
                $query->mascotas();
            }
        }

        if ($request->has('buscar') && $request->buscar !== '') {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('nbiopsia', 'like', "%{$buscar}%")
                    ->orWhere('diagnostico_clinico', 'like', "%{$buscar}%")
                    ->orWhereHas('paciente', function ($subq) use ($buscar) {
                        $subq->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('mascota', function ($subq) use ($buscar) {
                        $subq->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('propietario', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('doctor', function ($subq) use ($buscar) {
                        $subq->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%");
                    });
            });
        }

        $biopsias = $query->paginate(15);
        return view('biopsias.archivadas.index', compact('biopsias'));
    }

    // Archivar biopsia
    public function archivar($nbiopsia)
    {
        $biopsia = Biopsia::findOrFail($nbiopsia);
        $biopsia->archivar();
        
        return redirect()->back()
            ->with('success', 'Biopsia archivada exitosamente');
    }

    // Restaurar biopsia
    public function restaurar($nbiopsia)
    {
        $biopsia = Biopsia::findOrFail($nbiopsia);
        $biopsia->restaurar();
        
        return redirect()->back()
            ->with('success', 'Biopsia restaurada exitosamente');
    }

    // Eliminar permanentemente
    public function eliminarPermanente($nbiopsia)
    {
        $biopsia = Biopsia::findOrFail($nbiopsia);
        $biopsia->delete();
        
        return redirect()->route('biopsias.archivadas.index')
            ->with('success', 'Biopsia eliminada permanentemente');
    }
}
```

### 7. BiopsiaPacienteController.php (Funciones principales)
```php
<?php

namespace App\Http\Controllers;

use App\Models\Biopsia;
use App\Models\Paciente;
use App\Models\Doctor;
use Illuminate\Http\Request;

class BiopsiaPacienteController extends Controller
{
    // Mostrar biopsias de personas
    public function index()
    {
        $biopsias = Biopsia::with(['paciente', 'doctor'])
            ->personas()
            ->activas()
            ->orderBy('fecha_recibida', 'desc')
            ->paginate(10);

        return view('biopsias.personas.index', compact('biopsias'));
    }

    // Crear biopsia de paciente
    public function create()
    {
        $pacientes = Paciente::orderBy('nombre')->get();
        $doctores = Doctor::where('estado_servicio', true)->get();
        return view('biopsias.personas.create', compact('doctores', 'pacientes'));
    }

    // Guardar biopsia de paciente
    public function store(Request $request)
    {
        $request->validate([
            'nbiopsia' => 'required|string|max:15|unique:biopsias,nbiopsia',
            'diagnostico_clinico' => 'required|string',
            'fecha_recibida' => 'required|date|before_or_equal:today',
            'doctor_id' => 'required|exists:doctores,id',
            'paciente_id' => 'required|exists:pacientes,id'
        ]);

        Biopsia::create([
            'nbiopsia' => $request->nbiopsia,
            'diagnostico_clinico' => $request->diagnostico_clinico,
            'fecha_recibida' => $request->fecha_recibida,
            'doctor_id' => $request->doctor_id,
            'paciente_id' => $request->paciente_id,
            'estado' => true,
            'mascota_id' => null,
        ]);

        return redirect()->route('biopsias.personas.index')
            ->with('success', 'Biopsia creada exitosamente');
    }

    // API: Buscar pacientes para AJAX
    public function buscarPacientes(Request $request)
    {
        $term = $request->get('q') ?? $request->get('term');

        $pacientes = Paciente::where('nombre', 'like', "%{$term}%")
            ->orWhere('apellido', 'like', "%{$term}%")
            ->orWhere('DUI', 'like', "%{$term}%")
            ->select('id', 'nombre', 'apellido', 'DUI', 'edad', 'sexo')
            ->limit(10)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'text' => $p->nombre . ' ' . $p->apellido . ' - ' . $p->DUI . ' (' . $p->edad . ' años)',
                    'nombre_completo' => $p->nombre . ' ' . $p->apellido,
                    'dui' => $p->DUI,
                    'edad' => $p->edad,
                    'sexo' => $p->sexo === 'M' ? 'Masculino' : 'Femenino'
                ];
            });

        return response()->json(['results' => $pacientes]);
    }
}
```

## MODELOS

### 1. User.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'password',
        'role',
        'celular',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'celular' => 'integer',
            'email' => 'string',
            'role' => 'string',
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Accessor para obtener el nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    // Verificar si es administrador
    public function isAdmin()
    {
        return $this->rol === 'admin';
    }

    // Verificar si es empleado
    public function isEmpleado()
    {
        return $this->rol === 'empleado';
    }

    // Scope para filtrar por rol
    public function scopeAdmins($query)
    {
        return $query->where('rol', 'admin');
    }

    public function scopeEmpleados($query)
    {
        return $query->where('rol', 'empleado');
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
```

### 2. Doctor.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctores';

    protected $fillable = [
        'jvpm',
        'nombre',
        'apellido',
        'direccion',
        'celular',
        'fax',
        'correo',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'celular' => 'integer',
            'fax' => 'integer',
            'estado_servicio' => 'boolean',
        ];
    }

    public function scopeActivos($query)
    {
        return $query->where('estado_servicio', true);
    }

    public function scopeInactivos($query)
    {
        return $query->where('estado_servicio', false);
    }

    // Relación uno a muchos con biopsias
    public function biopsias()
    {
        return $this->hasMany(Biopsia::class, 'doctor_id');
    }
}
```

### 3. Paciente.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = "pacientes";
    
    protected $fillable = [
        "nombre",
        "apellido",
        "dui",
        "edad",
        "sexo",
        "fecha_nacimiento",
        "estado_civil",
        "ocupacion",
        "correo",
        "direccion",
        "celular"
    ];

    protected $casts = [
        "edad" => "integer",
        "sexo" => "string",
        "fecha_nacimiento" => "date",
        "celular" => "integer",
    ];

    // Relación uno a muchos con biopsias
    public function biopsias()
    {
        return $this->hasMany(Biopsia::class, 'paciente_id');
    }
}
```

### 4. Mascota.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    protected $table = 'mascotas';
    
    protected $fillable = [
        'nombre',
        'edad',
        'sexo',
        'especie',
        'raza',
        'propietario',
        'correo',
        'celular',
    ];

    protected $casts = [
        'edad' => 'integer',
        'celular' => 'integer',
        'sexo' => 'string',
    ];

    // Relación uno a muchos con biopsias
    public function biopsias()
    {
        return $this->hasMany(Biopsia::class, 'mascota_id');
    }
}
```

### 5. Biopsia.php
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Biopsia extends Model
{
    use HasFactory;
    
    protected $table = 'biopsias';
    
    // Configurar nbiopsia como clave primaria
    protected $primaryKey = 'nbiopsia';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nbiopsia',
        'diagnostico_clinico',
        'fecha_recibida',
        'estado',
        'paciente_id',
        'mascota_id',
        'doctor_id'
    ];

    protected $casts = [
        'estado' => 'boolean',
        'fecha_recibida' => 'date'
    ];

    // Relaciones
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function mascota(): BelongsTo
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    // Método para generar número de biopsia automático
    public static function generarNumeroBiopsia()
    {
        $año = date('Y');
        $mes = date('m');

        $ultimo = static::where('nbiopsia', 'like', "B{$año}{$mes}%")
            ->orderBy('nbiopsia', 'desc')
            ->first();

        if ($ultimo) {
            $ultimoNumero = (int)substr($ultimo->nbiopsia, -4);
            $nuevoNumero = $ultimoNumero + 1;
        } else {
            $nuevoNumero = 1;
        }

        return sprintf("B%s%s%04d", $año, $mes, $nuevoNumero);
    }

    // Scopes
    public function scopeActivas($query)
    {
        return $query->where('estado', true);
    }

    public function scopeArchivadas($query)
    {
        return $query->where('estado', false);
    }

    public function scopePersonas($query)
    {
        return $query->whereNotNull('paciente_id');
    }

    public function scopeMascotas($query)
    {
        return $query->whereNotNull('mascota_id');
    }

    // Métodos de estado
    public function archivar()
    {
        return $this->update(['estado' => false]);
    }

    public function restaurar()
    {
        return $this->update(['estado' => true]);
    }

    public function estaArchivada()
    {
        return !$this->estado;
    }

    public function estaActiva()
    {
        return $this->estado;
    }
}
```

## MIDDLEWARE

### CheckRole.php
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        if ($user->role !== 'administrador') {
            abort(403, 'No tienes permisos para acceder a esta sección. Solo administradores pueden ingresar.');
        }

        return $next($request);
    }
}
```

## CARACTERÍSTICAS PRINCIPALES

### Funcionalidades Implementadas:
1. **CRUD completo** para Doctores, Pacientes, Mascotas y Usuarios
2. **Sistema de Biopsias** con diferenciación entre personas y mascotas
3. **Sistema de archivado** de biopsias con restauración
4. **Búsquedas y filtros** avanzados
5. **Validaciones** robustas en todos los formularios
6. **Relaciones** entre modelos correctamente establecidas
7. **Scopes** para consultas específicas
8. **Middleware** de autorización por roles
9. **API endpoints** para búsquedas AJAX
10. **Generación automática** de números de biopsia

### Validaciones Principales:
- Campos únicos (JVPM, DUI, correos, celulares)
- Formatos específicos (8 dígitos para celular, 11 para fax)
- Fechas no futuras para biopsias
- Roles válidos para usuarios
- Existencia de registros relacionados

### Seguridad:
- Protección contra eliminación en cascada
- Middleware de roles
- Validación de permisos por acción
- Hash de contraseñas
- Prevención de auto-eliminación de usuarios