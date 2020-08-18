<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CancelAppointment extends Model
{
    protected $table = "cancel_appointment";
    protected $primaryKey  = 'id';
    protected $guarded = ['id'];
}