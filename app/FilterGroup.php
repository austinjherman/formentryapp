<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilterGroup extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'filter_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'group_key'
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
    public function filters() {
        return $this->hasMany('App\Filter');
    }

}