<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Todo extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_completed' => 'boolean',
    ];

    /**
     * Get the user that owns the TODO.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
