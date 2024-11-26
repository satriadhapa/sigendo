<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;
    protected $table ='ruangan';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'is_booked', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class); // Menambahkan relasi belongsTo
    }
}
