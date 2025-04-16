<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'Report_Link';

    protected $fillable = ['Customer_No', 'Link'];
    public $timestamps = false;  // Add this line

}
