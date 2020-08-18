<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = "chat";
    protected $primaryKey  = 'id';
    protected $guarded = ['id'];
    
    public function appointment()
    {
        return $this->hasOne('App\Models\Appointment', 'id', 'job_id');
    }
    
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    
    public function doctor()
    {
        return $this->hasOne('App\User', 'id', 'doctor_id');
    }
}