<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Employee extends Model
{
    use CrudTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_number',
        'names',
        'last_name',
        'second_last_name',
        'user_id',
        'identification_document_type_id',
        'state',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'identification_document_type_id' => 'integer',
    ];


    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function area()
    {
        return $this->belongsToMany(\App\Models\Area::class,'employees_areas')->withPivot('area_id');
    }

    public function identification_document_type()
    {
        return $this->belongsTo(\App\Models\Identification_document_type::class);
    }
}