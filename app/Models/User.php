<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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
        return $this->belongsToMany(Ruangan::class, 'ruangan_id');
    }
}
