<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCalculation extends Model
{
    use HasFactory;

    protected $fillable = ['expression', 'result'];
}
