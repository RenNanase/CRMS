<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use HasFactory;

    // Specify the table associated with the model if it's not the plural of the model name
    protected $table = 'places';

    // Define the fillable attributes
    protected $fillable = [
        'name',
    ];
}