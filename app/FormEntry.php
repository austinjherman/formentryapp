<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormEntry extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'form_entries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
    
    ];

}