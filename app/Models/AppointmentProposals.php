<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use DB;

class AppointmentProposals extends Model
{
    protected $table = "appointment_proposals";
    protected $primaryKey  = 'id';
    protected $guarded = ['id'];
    
    public function doctor()
    {
        return $this->hasOne('App\User', 'id', 'doctor_id');
    }
    
    public function appointment()
    {
        return $this->hasOne('App\Models\Appointment', 'id', 'appointment_id');
    }

    public function getNextId() 
    {
        $statement = DB::select("show table status like 'appointment_proposals'");
        return $statement[0]->Auto_increment;
    }
}