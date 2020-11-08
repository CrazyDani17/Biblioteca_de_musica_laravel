<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class Web extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'URL'
    ];
}