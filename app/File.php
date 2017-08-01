<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['titulo','descricao','filename','user_id'];

    /**
     * Get the entity
     */
    public function diligencias()
    {
        return $this->belongsToMany('App\Diligencia');
    }

    /**
     * Get the entity
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getFilepathAttribute($value)
    {
        if (!isset($this->attributes['filename']) || empty($this->attributes['filename']))
            return '';

        //return $this->attributes->filename;
        return '/uploads/'  . $this->attributes['filename'];
    }
}
