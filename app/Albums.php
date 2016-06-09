<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Albums extends Model
{
    protected $table = 'Albums';
    protected $fillable = [
        'Name', 'Activo',
    ];

    public function Pictures()
    {
    	return $this->hasMany('Pictures');
    }

}
