<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'jabatan',
        'bidang',
        'angkatan',
        'foto',
        'is_aktif',
        'periode',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_aktif' => 'boolean',
            'bidang'   => 'integer',
        ];
    }

    // ─────────────────────────────────────────── ROLE HELPERS ──

    /**
     * Returns true if the user holds a superior/pimpinan position.
     * Superior roles: pembina, dewan_penasihat, dewan_harian.
     */
    public function isSuperior(): bool
    {
        return in_array($this->role, ['pembina', 'dewan_penasihat', 'dewan_harian']);
    }

    /**
     * Returns true if the user is part of the organisasi (any non-warga role).
     */
    public function isOrganisasi(): bool
    {
        return $this->role !== 'warga';
    }

    /**
     * Accessor: human-readable role label in Indonesian.
     * Usage: $user->role_label  (snake_case accessor)
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'pembina'            => 'Pembina',
            'dewan_penasihat'    => 'Dewan Penasihat',
            'mpr'                => 'MPR',
            'dewan_harian'       => 'Dewan Harian',
            'koordinator_bidang' => 'Koordinator Bidang',
            'warga'              => 'Warga',
            default              => ucwords(str_replace('_', ' ', $this->role)),
        };
    }
}
