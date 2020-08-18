<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = "notification";
    protected $primaryKey  = 'id';
    protected $guarded = ['id'];
        
    public function reciever()
    {
        return $this->hasOne('App\User', 'id', 'recieverId');
    }
    
    public function sender()
    {
        return $this->hasOne('App\User', 'id', 'senderId');
    }
}