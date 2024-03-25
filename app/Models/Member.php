<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Member extends Model
{
  public $table = 'members';
  public $timestamps = true;
  protected $primaryKey = 'id';

  protected $fillable = [
        'name', 'last_name',"email","password",'created_at','updated_at'
    ];

    protected $hidden = [
     //   'password',
    ];
}
