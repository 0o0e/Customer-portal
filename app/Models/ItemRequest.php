<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemRequest extends Model
{
    protected $table = 'item_request';

    protected $fillable = [
        'name',
        'description',
        'requested_by',
        'status', // pending, approved, denied
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}
