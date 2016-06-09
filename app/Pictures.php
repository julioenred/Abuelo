<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pictures extends Model
{
    protected $table = 'Pictures';
    protected $fillable = [
        'Title', 'Description', 'Url',
    ];

    public function Albums()
	{
		return $this->belongsTo('Albums');
	}

}
