<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\relations\HasMany;

use App\Models\Like;
use App\Models\Comment;
class Feed extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "content"];
    protected $appends = ['liked','likes','comments'];
    public function user(): BelongsTo
    {
      return $this->belongsTo(User::class);
    }
    public function likes():HasMany{
      return $this->hasMany(Like::class);
    }
    public function comments():HasMany{
      return $this->hasMany(Comment::class);
    }
    public function getLikedAttribute():bool{
      return (bool)$this->likes()->exists();
    }
    public function getLikesAttribute(){
      return $this->likes()->count();
    }
    public function getCommentsAttribute(){
      return $this->comments()->count();
    }

}
