<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    // Define the table name (optional, Laravel will auto-detect it)
    protected $table = 'vehicles';

    // Allow mass assignment for the fields you want to be fillable
    protected $fillable = ['model', 'brand', 'year'];

    // Optionally, you can define relationships, accessors, mutators, etc.
}
