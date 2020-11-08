<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sector;

class Customer extends Model
{
    use CrudTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'ruc',
        'manager',
        'number_phone',
        'sector_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'sector_id' => 'integer',
        'user_id' => 'integer',
    ];


    public function addresses()
    {
        return $this->hasMany(\App\Models\Address::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function sector()
    {
        return $this->belongsTo(\App\Models\Sector::class);
    }
}
