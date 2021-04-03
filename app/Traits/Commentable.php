<?php

namespace App\Traits;

use App\Http\Core\Models\Comment;

/**
 * Trait Commentable
 * @package App\Traits
 */
trait Commentable
{
    /**
     * This static method does magic to
     * delete leftover comments once the commentable
     * model is deleted.
     */
    protected static function bootCommentable()
    {
        static::deleted(function ($commentable) {
            foreach ($commentable->comments as $comment) {
                $comment->delete();
            }
        });
    }

    /**
     * Returns all comments for this model.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Returns only approved comments for this model.
     */
    public function approvedComments()
    {
        return $this->morphMany(Comment::class, 'commentable')->where('approved', false)->latest();
    }
}