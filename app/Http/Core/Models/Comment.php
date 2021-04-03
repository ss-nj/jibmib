<?php

namespace App\Http\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'commenter_id',
        'commenter_type',
        'commentable_type',
        'commentable_id',
        'approved',
        'child_id',
        'comment',
        'answer',
        'operator_id',
        'approved',
        'answer_time',
        'operator_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'approved' => 'boolean'
    ];

    /*
   |--------------------------------------------------------------------------
   | EVENTS
   |--------------------------------------------------------------------------
   */


    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    /**
     * The user who posted the comment.
     */
    public function commenter()
    {
        return $this->morphTo();
    }

    /**
     * The model that was commented upon.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Returns all comments that this comment is the parent of.
     */
    public function children()
    {
        return $this->hasMany(Comment::class, 'child_id');
    }

    /**
     * Returns the comment to which this comment belongs to.
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'child_id');
    }

    public function getDateAttribute()
    {
        return verta($this->updated_at)->timezone('Asia/Tehran')->format('%d، %B %Y');
    }

}
