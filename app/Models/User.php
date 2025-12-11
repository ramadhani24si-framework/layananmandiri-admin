<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // TAMBAHKAN INI
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Scope untuk search
    public function scopeSearch($query, $keyword)
    {
        return $query->where('name', 'like', '%' . $keyword . '%')
                     ->orWhere('email', 'like', '%' . $keyword . '%');
    }

    // TAMBAHKAN METHOD UNTUK ROLE (BARU)
    // Method untuk cek role
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    // Method untuk cek apakah admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Method untuk cek apakah super admin
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    // Method untuk cek role dalam array
    public function hasAnyRole(array $roles)
    {
        return in_array($this->role, $roles);
    }
}
