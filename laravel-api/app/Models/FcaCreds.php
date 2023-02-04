<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 */
class FcaCreds extends Model
{
    use HasFactory;

    // Allow filling of FCA API Email and Key
    protected $fillable = [
        'email',
        'key'
    ];
}
