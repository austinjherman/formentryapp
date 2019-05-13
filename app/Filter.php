<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'filters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    
    ];

    /**
     * Get the comments for the blog post.
     */
    public function filterGroup() {
        return $this->hasOne('App\FilterGroup');
    }

}