<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $fillable = ['email', 'password', 'name', 'role', 'nomor_induk_pegawai', 'jabatan_akademik', 'avatar'];
}
