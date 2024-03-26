<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Users extends Model
{
  //กำหนดชื่อตารางในฐานข้อมูล
  public $table = 'users';
  //กรณีไม่ต้องการให้จัดเก็บข้อมูลวันที่ของการ create 
  //และ update ข้อมูล ให้กำหนดค่าเป็น false
  public $timestamps = true;
  //กำหนดชื่อฟิวด์ ที่เป็น primary key
  protected $primaryKey = 'u_id';
  //ระบุชื่อฟิวด์ของตาราง users ยกเว้นฟิวด์ u_id 
  //ซึ่งค่าข้อมูลจะเพิ่มขึ้นเองอัตโนมัติ
  protected $fillable = [
 'first_name', 'last_name','email','created_at','updated_at','password'
    ];
}