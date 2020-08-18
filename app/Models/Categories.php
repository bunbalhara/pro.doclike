<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\User;

class Categories extends Model
{
    protected $table = "categories";
    protected $primaryKey  = 'id';
    protected $guarded = ['id'];

    public function doctor() {
        return $this->hasMany('App\User', 'category');
    }
}
