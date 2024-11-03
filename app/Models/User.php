<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $fillable = ['email', 'password', 'name'];
}
