<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'isbn', 'publication_date', 'status',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_action_logs')
                    ->withPivot('status');
    }
}
