<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pictures extends Model
{
    protected $table = 'Pictures';
    protected $fillable = [
        'Title', 'Description', 'Url', 'Id_Album',
    ];

    public function Albums()
	{
		return $this->belongsTo('Albums');
	}

}
