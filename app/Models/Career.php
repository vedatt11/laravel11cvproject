<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;
    protected $fillable = [
        'status',
        'description',
        'end_date',
        'start_date',
        'image',
        'company',
        'title',
    ];
}
