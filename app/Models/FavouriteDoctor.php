<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FavouriteDoctor extends Model
{
    protected $table = "favorite_doctor";
    protected $primaryKey  = 'id';
    protected $guarded = ['id'];

    public function user() {
       return $this->belongsTo('App\User', 'user_id');
    }
}