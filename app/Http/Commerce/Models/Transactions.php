<?php

namespace App\Http\Commerce\Models;

use App\Http\Core\Models\User;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = [
        'amount',
        'meta',
        'authority',
        'status',
        'ref_id',
        'ip',
        'pay_way'
     ];

    protected $casts = [
        'meta' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }}
