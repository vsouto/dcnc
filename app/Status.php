<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Status extends Model
{
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'status'
            ]
        ];
    }

    //

    /**
     * Get the entity
     */
    public function diligencias()
    {
        return $this->hasMany('App\Diligencia');
    }

    public static function getList()
    {
        return Status::pluck('status','id')->toArray();
    }
}
