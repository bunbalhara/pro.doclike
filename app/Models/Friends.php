<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
    protected $table       = "friends";
    protected $primaryKey  = 'id';
    protected $guarded     = ['id'];
    
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    
    public function friend()
    {
        return $this->hasOne('App\User', 'id', 'friend_id');
    }
}