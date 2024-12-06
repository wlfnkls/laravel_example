<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $casts = [
        'properties' => 'array'
    ];

    protected $fillable = [
        'company_id',
        'properties'
    ];
}
