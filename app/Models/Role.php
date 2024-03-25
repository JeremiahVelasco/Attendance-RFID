<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
    ];


    const ADMIN = 0;
    const FACULTY = 1;
    const STAFF = 2;
    const STUDENT = 3;
}
