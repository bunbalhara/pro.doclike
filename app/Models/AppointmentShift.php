<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AppointmentShift extends Model
{
    protected $table = "appointment_shift";
    protected $primaryKey  = 'id';
    protected $guarded = ['id'];
    
    public function appointment()
    {
        return $this->hasOne('App\Models\Appointment', 'id', 'appointment_id');
    }
}