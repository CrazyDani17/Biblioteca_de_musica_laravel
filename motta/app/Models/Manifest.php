<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Manifest extends Model
{
    use CrudTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'create_date',
        'pick_up_date',
        'file',
        'document_type_id',
        'customer_id',
        'address_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'document_type_id' => 'integer',
        'address_id' => 'integer',
        'customer_id' => 'integer',
        'user_id' => 'integer',
        'file' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function address()
    {
        return $this->belongsTo(\App\Models\Address::class);
    }

    public function document_type()
    {
        return $this->belongsTo(\App\Models\Document_type::class);
    }

    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class);
    }

    public function setFileAttribute($value)
    {
        $attribute_name = "file";
        $disk = "public";
        $destination_path = "/documentos";

        $this->uploadMultipleFilesToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
