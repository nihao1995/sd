<?php
defined('IN_PHPCMS') or exit('No permission resources.');
pc_base::load_app_func('global');

use zysd\classes\SdControl as sd;
use zysd\classes\OrderControl as oc;
class api{
	public $sd;
	function __construct()
	{
		$this->sd = new sd();
		$this->oc = new oc();
		$this->member_db=pc_base::load_model("member_model");
	}

	//====================================	头像上传=================================================================== 开始
	/**
	 * 多图片上传-1
	 * @param  string $file_url [文件夹]
	 */
	function uploadfile_img(){
		if($_FILES["file"]["error"]!=0){
			$result = array('status'=>0,'msg'=>$_FILES["file"]["error"]);
			echo json_encode($result);exit();
		}

		if( !in_array($_FILES["file"]["type"], array('image/gif','image/jpeg','image/bmp','image/jpg','image/png')) ){
			$result = array('status'=>-1,'msg'=>$_FILES["file"]["type"]);
			echo json_encode($result);exit();
		}

		if($_FILES["file"]["size"] > 10000000){//判断是否大于10M
			$result = array('status'=>-2,'msg'=>'图片大小超过限制');
			echo json_encode($result);exit();
		}
		$filename = substr(md5(time()),0,10).mt_rand(1,10000);
		$ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
		//
		$time = date('Ymd',time());
		mkdir('uploadfile/headimg/');
		mkdir('uploadfile/headimg/'.$time.'/');

		$localName = "uploadfile/headimg/".$time."/".$filename.'.'.$ext;

		if ( move_uploaded_file($_FILES["file"]["tmp_name"], $localName) == true) {
			$this->image_png_size_add($localName,$localName);
			$lurl = APP_PATH.$localName;
			$result  = array('status'=>1,'msg'=>$lurl);
		}else{
			$result  = array('status'=>-200,'msg'=>'error');
		}
		echo json_encode($result);
		//return $lurl;
	}

	/**
	 * 多图片上传-2
	 * @param  string $file_url [文件夹]
	 */
	function upload_headimg(){
		$msg = [0=>"上传成功", 1=>"上传图片过大",4=>"文件没有被上传"];
		$parm=checkArg(["userid"=>[true,6,"请先登录"]],$_GET);
		if($_FILES["file"]["error"]!=0){
			$result = array('status'=>0,'msg'=>$msg[$_FILES["file"]["error"]]);
			echo json_encode($result);exit();
		}

		if( !in_array($_FILES["file"]["type"], array('image/gif','image/jpeg','image/bmp','image/jpg','image/png')) ){
			$result = array('status'=>-1,'msg'=>"上传类型错误！".$_FILES["file"]["type"]);
			echo json_encode($result);exit();
		}

		if($_FILES["file"]["size"] > 10000000){//判断是否大于10M
			$result = array('status'=>-2,'msg'=>'图片大小超过限制');
			echo json_encode($result);exit();
		}
		$filename = substr(md5(time()),0,10).mt_rand(1,10000);
		$ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
		//
		$time = date('Ymd',time());
		mkdir('uploadfile/headimg/');
		mkdir('uploadfile/headimg/'.$time.'/');

		$localName = "uploadfile/headimg/".$time."/".$filename.'.'.$ext;

		if ( move_uploaded_file($_FILES["file"]["tmp_name"], $localName) == true) {
			$this->image_png_size_add($localName,$localName);
			$lurl = APP_PATH.$localName;
			$result  = array('status'=>1,'msg'=>$lurl);
			$data=[
				'headimgurl'=>$lurl,
			];
			if(!$parm['userid']) returnAjaxData('0','登录超时');
			$info=$this->member_db->update($data,array('userid'=>$parm['userid']));
		}else{
			$result  = array('status'=>-200,'msg'=>'error');
		}
		echo json_encode($result);
		//return $lurl;
	}

	/**
	 * desription 压缩图片
	 * @param sting $imgsrc 图片路径
	 * @param string $imgdst 压缩后保存路径
	 */
	function image_png_size_add($imgsrc,$imgdst){
		list($width,$height,$type)=getimagesize($imgsrc);
		$percent=$height/$width;
		$new_width = ($width>600?600:$width)*1;
		$new_height = $new_width*$percent;
		switch($type){
			case 1:
				$giftype=check_gifcartoon($imgsrc);
				if($giftype){
					header('Content-Type:image/gif');
					$image_wp=imagecreatetruecolor($new_width, $new_height);
					$image = imagecreatefromgif($imgsrc);
					imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					imagejpeg($image_wp, $imgdst,75);
					imagedestroy($image_wp);
				}
				break;
			case 2:
				header('Content-Type:image/jpeg');
				$image_wp=imagecreatetruecolor($new_width, $new_height);
				$image = imagecreatefromjpeg($imgsrc);
				imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				imagejpeg($image_wp, $imgdst,75);
				imagedestroy($image_wp);
				break;
			case 3:
				header('Content-Type:image/png');
				$image_wp=imagecreatetruecolor($new_width, $new_height);
				$image = imagecreatefrompng($imgsrc);
				imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				imagejpeg($image_wp, $imgdst,75);
				imagedestroy($image_wp);
				break;
		}
	}

	/**
	 * desription 判断是否gif动画
	 * @param sting $image_file 图片路径
	 * @return boolean t 是 f 否
	 */
	function check_gifcartoon($image_file){

		$fp = fopen($image_file,'rb');

		$image_head = fread($fp,1024);

		fclose($fp);

		return preg_match("/".chr(0x21).chr(0xff).chr(0x0b).'NETSCAPE2.0'."/",$image_head)?false:true;
	}
	//====================================	头像上传=================================================================== 开始

	public function test(){
		returnAjaxData(1);
	}
	public function set(){
		$cookie = param::set_app_cookie("_userid", 1);
		echo($cookie);
	}
	public function get(){
		$cookie = param::get_app_cookie("_userid", $_GET["type"]);
		echo($cookie);
	}
	//******************************************************************************************************************
	//公告类型
	function notice_type_list(){
		$where="status=1";
		$info=$this->sd->notice_type_all($where);
		if($info){
			returnAjaxData(200,"操作成功",$info);
		}else{
			returnAjaxData(-200,"暂无数据");
		}
	}
	//公告列表
	function notice_list(){
		$data=checkArg(["siteid"=>[true,1,"请输入类型"],"page"=>[true,0,"请输入page"],"pagesize"=>[false,0,"请输入pagesize"]],$_POST);
		$where=["passed"=>1,'siteid'=>$data['siteid']];
		list($info,$pagenums, $pageStart, $pageCount)=$this->sd->notice_list($where,$data['page']);
		if($info){
			returnAjaxData(200,"操作成功",['data'=>$info,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount]);
		}else{
			returnAjaxData(-200,"暂无数据",['data'=>$info,'pagenums'=>$pagenums, 'pageStart'=>$pageStart, 'pageCount'=>$pageCount]);
		}
	}
	//公告详请
	function notice_detail(){
		$data=checkArg(["aid"=>[true,1,"请输入ID"]],$_POST);
		$data['passed']=1;
		list($info,$pagenums, $pageStart, $pageCount)=$this->sd->notice_list($data);
		if($info){
			returnAjaxData(200,"操作成功",$info);
		}else{
			returnAjaxData(-200,"暂无数据");
		}
	}
	//扫描二维码
	function qrcode_msg(){
		$data=checkArg(["msg"=>[true,0,"请输入二维码信息"]],$_POST);
		$msg=substr($data['msg'],strripos($data['msg'],"token=")+6);
		$info=$this->member_db->get_one(["username"=>$msg]);
		if($info){
			returnAjaxData(200,"操作成功",["nickname"=>$info['nickname'], "qrcode"=>$info["username"]]);
		}else{
			returnAjaxData(-200,"暂无此人数据");
		}
	}

	//自动抢单
	function auto_grab_order(){
		$parm=checkArg(["userid"=>[true,6,"请先登录"]],$_POST);
		$res=$this->oc->auto_grab_order($parm['userid']);
		if($res){
			returnAjaxData(200,"操作成功",$res);
		}else{
			returnAjaxData(-200,"操作失败");
		}
	}

	//接取任务
	function get_task(){
		$parm=checkArg(["userid"=>[true,6,"请先登录"],"SID"=>[true,1,"请先选择任务"]],$_POST);
		$res=$this->oc->get_task($parm['userid'],$parm['SID']);
		if($res){
			returnAjaxData(200,"操作成功",$res);
		}else{
			returnAjaxData(-200,"操作失败");
		}
	}

	//任务详情
	function task_detail(){
		$parm=checkArg(["SID"=>[true,1,"请先选择任务"]],$_POST);
		$res=$this->oc->task_detail(['SID',$parm['SID']]);
		if($res){
			returnAjaxData(200,"操作成功",$res);
		}else{
			returnAjaxData(-200,"操作失败");
		}
	}
}
?>
