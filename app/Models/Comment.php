<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Feed;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\relations\BelongsTo;
class Comment extends Model
{
    use HasFactory;
    protected $fillable=[
        'feed_id',
        'user_id',
        'content'
    ];
    public function feed():BelongsTo{
        return $this->belongsTo(Feed::class);
    }
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
}
