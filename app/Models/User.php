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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
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

    // Verificar si el usuario es administrador
    public function isAdmin()
    {
        return  $this->role === 'admin';
    }

    // Verificar si el usuario es empleado
    public function isEmpleado(){
        return $this->role === 'empleado';
    }

}
