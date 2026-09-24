<?php

namespace App\Models;

use App\Http\Controllers\ReplyController;
use App\Notifications\MarkedAsBestReply;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Discussion extends Model
{
    /** @use HasFactory<\Database\Factories\DiscussionFactory> */
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function channel() {
        return $this->belongsTo(Channel::class);
    }

    public function replies() {
        return $this->hasMany(Reply::class);
    }

    public function markAsBestReply(Reply $reply) {
        $this->update([
            'reply_id' => $reply->id,
        ]);
        if($reply->user_id === $this->user_id) {
            return;
        }
        $reply->user->notify(new MarkedAsBestReply($reply->discussion));
    }

    public function scopeFilterByChannel($query)
    {
        if ($channelSlug = request()->query('channel')) {
            $channel = Channel::where('slug', $channelSlug)->first();
            if ($channel) {
                return $query->where('channel_id', $channel->id);
            }
        }
        return $query;
    }
}