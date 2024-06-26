<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'rfid',
        'type'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function rfid()
    {
        return $this->belongsTo(User::class);
    }

    const TIME_OUT = 0;
    const TIME_IN = 1;

    use HasFactory;
}
