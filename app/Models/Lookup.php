<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lookup extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'name', 'code'];
}
