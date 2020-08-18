<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Appointment extends Model
{
    use Notifiable;

    protected $table = "appointment";
    protected $primaryKey  = 'id';
    protected $guarded = ['id'];

    public function category()
    {
        return $this->hasOne('App\Models\Categories', 'id', 'category_id');
    }

    public function sub_category()
    {
        return $this->hasOne('App\Models\Categories', 'id', 'sub_category_id');
    }

    public function shift()
    {
        return $this->hasMany('App\Models\AppointmentShift', 'appointment_id', 'id');
    }

    public function appointmentShift()
    {
        return $this->hasOne('App\Models\AppointmentShift', 'appointment_id', 'id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function purposal()
    {
        return $this->hasMany('App\Models\AppointmentProposals', 'appointment_id', 'id');
    }

    public function checkPurposal()
    {
        return $this->hasOne('App\Models\AppointmentProposals', 'appointment_id', 'id')->where('doctor_id',auth()->user()->id);
    }

    public function acceptPurposal()
    {
        return $this->hasOne('App\Models\AppointmentProposals', 'appointment_id', 'id')->where('status','1');
    }

    public function cancelAppointment()
    {
        return $this->hasOne('App\Models\CancelAppointment', 'appointment_id', 'id')->where('doctor_id',auth()->user()->id);
    }
}
