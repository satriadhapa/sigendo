<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    protected $table = 'program_studi';
    protected $primaryKey = 'id';
    protected $fillable = ['kode', 'name'];

    public function admins()
    {
        return $this->hasMany(Admin::class, 'program_studi_id');
    }
    public function mataKuliahs()
    {
        return $this->hasMany(MataKuliah::class);
    }
}
