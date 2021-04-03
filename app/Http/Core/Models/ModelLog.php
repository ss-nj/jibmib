<?php

namespace App\Http\Core\Models;

use App\Http\Core\Models\User;
use Illuminate\Database\Eloquent\Model;

class ModelLog extends Model
{

    protected $table = 'audits';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
