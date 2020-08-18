<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    protected $table = "skills";
    protected $primaryKey  = 'id';
    protected $guarded = ['id'];
}