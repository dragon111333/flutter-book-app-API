<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class facultys extends Model
{
  //กำหนดชื่อตารางในฐานข้อมูล
  public $table = 'facultys';
  //กรณีไม่ต้องการให้จัดเก็บข้อมูลวันที่ของการ create 
  //และ update ข้อมูล ให้กำหนดค่าเป็น false
  public  $timestamps = true;
  //กำหนดชื่อฟิวด์ ที่เป็น primary key
  protected $primaryKey = 'f_id';
  //ระบุชื่อฟิวด์ของตาราง products ยกเว้นฟิวด์ p_id 
  //ซึ่งค่าข้อมูลจะเพิ่มขึ้นเองอัตโนมัติ
  protected $fillable = [
        'f_name', 'details','created_at','updated_at','f_img'
    ];
}