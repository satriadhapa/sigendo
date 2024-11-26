<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{

    use HasApiTokens, Notifiable, HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['email', 'password', 'name', 'nomor_induk_pegawai', 'jabatan_akademik', 'program_studi_id', 'image'];

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    public function mataKuliahs()
    {
        return $this->belongsToMany(MataKuliah::class, 'mata_kuliah_id');
    }

    // Relationship to Jam Kuliah (many-to-many)
    public function jamKuliahs()
    {
        return $this->belongsToMany(JamKuliah::class, 'jam_kuliah_id');
    }

    // Relationship to Ruangan (many-to-many)
    public function ruangans()
    {
        return $this->hasMany(Ruangan::class); // Mengubah menjadi relasi One-to-Many
    }

    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
