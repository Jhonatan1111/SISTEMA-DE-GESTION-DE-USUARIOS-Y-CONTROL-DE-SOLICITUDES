<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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

   
    // Casts de atributos
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

    // Métodos en español (aliases)
    public function esAdmin()
    {
        return $this->isAdmin();
    }

    public function esEmpleado()
    {
        return $this->isEmpleado();
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

    // Scope para usuarios activos
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
