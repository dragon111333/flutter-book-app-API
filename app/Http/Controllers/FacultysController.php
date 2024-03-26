<?php
namespace App\Http\Controllers;
//ระบุชื่อคลาสที่ทำหน้าที่เป็น Data Model ในที่นี้คือคลาส Facultys
use App\Models\Facultys;
use Illuminate\Http\Request;

class FacultysController extends Controller
{
    //ทำหน้าที่แสดงข้อมูลทุกรายการ
    public function readAll()
    {
       //ส่งค่าข้อมูลออกในรูปแบบ json และส่งรหัสเลข 200
        return response()->json(Facultys::all(), 200);
    }

    //แสดงเฉพาะข้อมูลที่มีค่าฟิวด์ f_id เท่ากับค่าของตัวแปร $id
    public function readOne($id)
    {
        $data = Facultys::where('f_id', $id)->get();
        return response()->json($data, 200);
    }

    //เพิ่มข้อมูลใหม่
    public function create(Request $request)
    {
        //เรียกใช้ฟังก์ชัน uploadFile ที่สร้างขึ้นไว้ก่อนหน้านี้
	    $data = $this->uploadFile($request);
        //$facultys = Facultys::create($request->all());
        $faculty = Facultys::create($data);
        return response()->json($faculty, 201);
    }

    //อัพเดทข้อมูล เฉพาะรายการที่มีฟิวด์ f_id เท่ากับค่าของตัวแปร $id
    public function update($id, Request $request)
    {
        //ค้นหาข้อมูลตามฟิวด์ f_id แล้วนำมาเก็บไว้ในตัวแปร $facultys
        $faculty = Facultys::findOrFail($id);
        
        //จัดเก็บข้อมูลที่ส่งมาแก้ไขไว้ตัวแปร data
        $data = $request->all();
        //ตรวจสอบก่อนว่ามีไฟล์ upload มาหรือไม่
        if ($request->hasFile('f_img')) {
            //อัพโหลดไฟล์ โดยเรียกใช้ฟังก์ชัน uploadFile
            $data = $this->uploadFile($request);
            //ลบไฟล์เดิมทิ้ง
            if (file_exists("/home/ubuntu/mbs/public/img/".$faculty->f_img)) {
                unlink("/home/ubuntu/mbs/public/img/".$faculty->f_img);
            }
        }
        //ทำการแก้ไขข้อมูลตามข้อมูลที่ส่งมาในตัวแปร $data
        $faculty->update($data);
        //ทำการแก้ไขข้อมูลตามข้อมูลที่ส่งมาในตัวแปร $request
        //$facultys->update($request->all());
        
        //ส่งค่าข้อมูลที่ได้อัพเดทแล้ว
        return response()->json($faculty, 202);
    }

    //ลบข้อมูล เฉพาะรายการที่มีฟิวด์ f_id เท่ากับค่าของตัวแปร $id
    public function delete($id)
    {
        //ค้นหาข้อมูลตามฟิวด์ f_id แล้วนำมาเก็บไว้ในตัวแปร $facultys
        $faculty = Facultys::findOrFail($id);
        //ตรวจสอบก่อนว่ามีชื่อไฟล์ในฟิวด์ f_img หรือไม่
        if (empty($faculty->f_img) == false) {
            //ลบไฟล์เดิมทิ้ง ซึ่งซื้อไฟล์อยู่ในฟิวด์ f_img
            if (file_exists("/home/ubuntu/mbs/public/img/".$faculty->f_img)) {
                unlink("/home/ubuntu/mbs/public/img/".$faculty->f_img);
            }
        } 
        
        //ลบข้อมูล
        $faculty->delete();
        //ส่งข้อมูลเป็นข้อความ Deleted Successfully
        return response(['message'=>'Deleted Successfully'], 202);
    }   

    //ฟังก์ชันสำหรับอัพโหลดไฟล์
    function uploadFile(Request $request){
        //กำหนดชื่อโฟลเดอร์ที่ต้องการบันทีกไฟล์ ในที่นี้คือ img
        $path = "img";
        //รับค่าชื่อไฟล์ที่อัพโหลดมาเก็บไว้ในตัวแปร file
        $file = $request->file("f_img")->getClientOriginalName();
        //หานามสกุลของไฟล์
        $exFile = explode(".",$file);
        //ตั้งชื่อไฟล์ใหม่ โดยใช้รูปแบบวันที่และเวลา และตามด้วยนามสกุลของไฟล์เดิม
        $fname = date("YmdHms").".".end($exFile);
        //ทำการบันทึกไฟล์ที่อัพโหลดมาไปเก็บไว้ในโฟลเดอร์ที่ตั้งไว้ในตัวแปร path โดยใช้ชื่อไฟล์ใหม่ตามตัวแปร fname
        $request->file("f_img")->move($path, $fname);
    
        //นำค่าที่ส่งมาทั้งหมด ซึ่งหาได้จาก $request->all() มาเก็บไว้ในตัวแปร data
        $data = $request->all();
        //กำหนดให้ฟิวด์ f_img มีค่าเท่ากับค่าของตัวแปร fname คือ ชื่อของไฟล์ใหม่
        $data["f_img"] = $fname;
    
        //ส่งออกค่าตัวแปร data
        return $data;
    }
    //ฟังก์ชันสำหรับแสดงข้อมูลทุกรายการพร้อมรูปภาพ
    public function showAllWithImage()
    {
        //หาหมายเลข ip ของ server 
        $ip_server = $_SERVER['SERVER_NAME'];
        //ดึงข้อมูลจากตาราง producs ทั้งหมด
        $facultys = Facultys::all();
        $i = 0;
        //วนลูปเพื่อใส่ url รูปภาพในฟิวด์ f_img
        foreach ($facultys as $value) {
          // ตรวจสอบก่อนว่าฟิวด์ f_img มีค่าว่างหรือไม่
          if($value->f_img != null) {
            $facultys[$i]['f_img'] = urlencode("http://".$ip_server."/mbs/img/".$value->f_img);
        }
          $i++;
        }
        //ส่งออกค่าข้อมูลทั้งหมด ซึ่งถูกแปลงเป็นแบบ json แล้ว พร้อม response code = 200
        return response()->json($faculty, 200);
    }

    //ฟังก์ชันสำหรับแสดงเฉพาะข้อมูลที่มีค่าฟิวด์ id เท่ากับค่าของตัวแปร $id พร้อมรูปภาพ
    public function showOneWithImage($id)
    {
        //หาหมายเลข ip ของ server 
        $ip_server = $_SERVER['SERVER_NAME'];
        //ส่งค่าข้อมูลที่ฟิวด์ id มีค่าเท่ากับตัวแปร id
        $faculty = Facultys::find($id);
        // ตรวจสอบก่อนว่าฟิวด์ f_img มีค่าว่างหรือไม่
        if($faculty->f_img != null) {
        $faculty->f_img  = urlencode("http://".$ip_server."/mbs/public/img/".$faculty->f_img);
        }
        //ส่งออกค่าข้อมูลออก ในรูปแบบ ่json
        return response()->json($faculty);
    }   
}