<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage; // Tambahkan ini

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_picture', // TAMBAHKAN INI
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
                     ->orWhere('email', 'like', '%' . $keyword . '%')
                     ->orWhere('role', 'like', '%' . $keyword . '%');
    }

    // ACCESSOR untuk foto profil (sederhana)
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return Storage::url($this->profile_picture);
        }

        // Default avatar jika tidak ada foto
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    // TAMBAHKAN METHOD UNTUK ROLE
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function hasAnyRole(array $roles)
    {
        return in_array($this->role, $roles);
    }

    // Method untuk mendapatkan role dalam format yang lebih baik
    public function getFormattedRoleAttribute()
    {
        $roles = [
            'admin' => 'Admin',
            'super_admin' => 'Super Admin',
            'user' => 'User',
        ];

        return $roles[$this->role] ?? 'User';
    }
}
