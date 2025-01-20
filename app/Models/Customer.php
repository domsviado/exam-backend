<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'age',
        'birthdate',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    protected static function booted()
    {
        static::saving(function ($user) {
            $user->age = $user->birthdate ? Carbon::parse($user->birthdate)->age : null;
        });
    }
}
