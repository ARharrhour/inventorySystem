<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name', 'email', 'address','phone','nid', 'joining_date','photo','salary'
    ];

}
