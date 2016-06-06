<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pictures extends Model
{
    protected $table = 'Pictures';
    protected $fillable = [
        'Title', 'Description', 'Url',
    ];

}
