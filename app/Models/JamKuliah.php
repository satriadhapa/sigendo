<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamKuliah extends Model
{
    use HasFactory;
    protected $table = 'jam_kuliahs';
    protected $primaryKey = 'id';
    protected $fillable = ['start_time', 'end_time'];
}
