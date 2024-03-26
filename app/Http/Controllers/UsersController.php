<?php

namespace App\Http\Controllers;
//ระบุชื่อคลาสที่ทำหน้าที่เป็น Data Model ในที่นี้คือคลาส Products
use App\Models\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //ทำหน้าที่แสดงข้อมูลทุกรายการ
    public function readAll()
    {
       //ส่งค่าข้อมูลออกในรูปแบบ json และส่งรหัสเลข 200
        return response()->json(Users::all(), 200);
    }

    //แสดงเฉพาะข้อมูลที่มีค่าฟิวด์ u_id เท่ากับค่าของตัวแปร $id
    public function readOne($id)
    {
        $data = Users::where('u_id', $id)->get();
        return response()->json($data, 200);
    }

    //เพิ่มข้อมูลใหม่
    public function create(Request $request)
    {
        //เรียกใช้ฟังก์ชัน uploadFile ที่สร้างขึ้นไว้ก่อนหน้านี้
	   // $data = $this->uploadFile($request);
        $users = Users::create($request->all());
        //$product = Users::create($data);
        return response()->json($users, 201);
    }
 //Login
 public function login (Request $request)
 {
    $data=$request->all();
     $users = Users::where([
        ['email','=',$data['email']],
        ['password','=',$data['password']]
     ])->first();

     return response()->json($users, 200);
 }
    //อัพเดทข้อมูล เฉพาะรายการที่มีฟิวด์ p_id เท่ากับค่าของตัวแปร $id
    public function update($id, Request $request)
    {
        //ค้นหาข้อมูลตามฟิวด์ p_id แล้วนำมาเก็บไว้ในตัวแปร $product
        $users = Users::findOrFail($id);
        
        //จัดเก็บข้อมูลที่ส่งมาแก้ไขไว้ตัวแปร data
        $data = $request->all();
        //ตรวจสอบก่อนว่ามีไฟล์ upload มาหรือไม่
        // if ($request->hasFile('p_img')) {
        //     //อัพโหลดไฟล์ โดยเรียกใช้ฟังก์ชัน uploadFile
        //     $data = $this->uploadFile($request);
        //     //ลบไฟล์เดิมทิ้ง
        //     if (file_exists("/home/ubuntu/foodapp/public/img/".$product->p_img)) {
        //         unlink("/home/ubuntu/foodapp/public/img/".$product->p_img);
        //     }
        // }
        //ทำการแก้ไขข้อมูลตามข้อมูลที่ส่งมาในตัวแปร $data
        $users->update($data);
        //ทำการแก้ไขข้อมูลตามข้อมูลที่ส่งมาในตัวแปร $request
        //$product->update($request->all());
        
        //ส่งค่าข้อมูลที่ได้อัพเดทแล้ว
        return response()->json($users, 202);
    }

    //ลบข้อมูล เฉพาะรายการที่มีฟิวด์ p_id เท่ากับค่าของตัวแปร $id
    public function delete($id)
    {
        //ค้นหาข้อมูลตามฟิวด์ p_id แล้วนำมาเก็บไว้ในตัวแปร $product
        $users = Products::findOrFail($id);
        //ตรวจสอบก่อนว่ามีชื่อไฟล์ในฟิวด์ p_img หรือไม่
        // if (empty($product->p_img) == false) {
        //     //ลบไฟล์เดิมทิ้ง ซึ่งซื้อไฟล์อยู่ในฟิวด์ p_img
        //     if (file_exists("/home/ubuntu/foodapp/public/img/".$users->p_img)) {
        //         unlink("/home/ubuntu/foodapp/public/img/".$product->p_img);
        //     }
        // } 
        
        //ลบข้อมูล
        $users->delete();
        //ส่งข้อมูลเป็นข้อความ Deleted Successfully
        return response(['message'=>'Deleted Successfully'], 202);
    }   

    //ฟังก์ชันสำหรับอัพโหลดไฟล์
    function uploadFile(Request $request){
        //กำหนดชื่อโฟลเดอร์ที่ต้องการบันทีกไฟล์ ในที่นี้คือ img
        $path = "img";
        //รับค่าชื่อไฟล์ที่อัพโหลดมาเก็บไว้ในตัวแปร file
        $file = $request->file("p_img")->getClientOriginalName();
        //หานามสกุลของไฟล์
        $exFile = explode(".",$file);
        //ตั้งชื่อไฟล์ใหม่ โดยใช้รูปแบบวันที่และเวลา และตามด้วยนามสกุลของไฟล์เดิม
        $fname = date("YmdHms").".".end($exFile);
        //ทำการบันทึกไฟล์ที่อัพโหลดมาไปเก็บไว้ในโฟลเดอร์ที่ตั้งไว้ในตัวแปร path โดยใช้ชื่อไฟล์ใหม่ตามตัวแปร fname
        $request->file("p_img")->move($path, $fname);
    
        //นำค่าที่ส่งมาทั้งหมด ซึ่งหาได้จาก $request->all() มาเก็บไว้ในตัวแปร data
        $data = $request->all();
        //กำหนดให้ฟิวด์ p_img มีค่าเท่ากับค่าของตัวแปร fname คือ ชื่อของไฟล์ใหม่
        $data["p_img"] = $fname;
    
        //ส่งออกค่าตัวแปร data
        return $data;
    }
    //ฟังก์ชันสำหรับแสดงข้อมูลทุกรายการพร้อมรูปภาพ
    public function showAllWithImage()
    {
        //หาหมายเลข ip ของ server 
        $ip_server = $_SERVER['SERVER_NAME'];
        //ดึงข้อมูลจากตาราง producs ทั้งหมด
        $products = Products::all();
        $i = 0;
        //วนลูปเพื่อใส่ url รูปภาพในฟิวด์ p_img
        foreach ($products as $value) {
          // ตรวจสอบก่อนว่าฟิวด์ p_img มีค่าว่างหรือไม่
          if($value->p_img != null) {
            $products[$i]['p_img'] = urlencode("http://".$ip_server."/mbs/img/".$value->p_img);
        }
          $i++;
        }
        //ส่งออกค่าข้อมูลทั้งหมด ซึ่งถูกแปลงเป็นแบบ json แล้ว พร้อม response code = 200
        return response()->json($products, 200);
    }

    //ฟังก์ชันสำหรับแสดงเฉพาะข้อมูลที่มีค่าฟิวด์ id เท่ากับค่าของตัวแปร $id พร้อมรูปภาพ
    public function showOneWithImage($id)
    {
        //หาหมายเลข ip ของ server 
        $ip_server = $_SERVER['SERVER_NAME'];
        //ส่งค่าข้อมูลที่ฟิวด์ id มีค่าเท่ากับตัวแปร id
        $product = Products::find($id);
        // ตรวจสอบก่อนว่าฟิวด์ p_img มีค่าว่างหรือไม่
        if($product->p_img != null) {
        $product->p_img  = urlencode("http://".$ip_server."/mbs/img/".$product->p_img);
        }
        //ส่งออกค่าข้อมูลออก ในรูปแบบ ่json
        return response()->json($product);
    }

    
  
}