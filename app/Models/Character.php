<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', // Permitir asignación masiva para el ID
        'name',
        'status',
        'species',
        'type',
        'gender',
        'origin_name',
        'origin_url',
        'image',
    ];
}