<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'code',
        'class',
    ];

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}