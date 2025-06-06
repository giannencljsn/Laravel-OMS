<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhonevilleBranch extends Model
{
    //
    protected $table = 'phoneville_branches';
    protected $primaryKey = 'id';
    protected $fillable = [
        'store_name',
        'store_location',
        'contact_number'
    ];
    public $timestamps = true;
}
