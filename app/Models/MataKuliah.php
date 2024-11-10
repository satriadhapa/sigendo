<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;
    protected $table ='mata_kuliahs';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'kode','sks', 'program_studi_id'];
    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }
}
