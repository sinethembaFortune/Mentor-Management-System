<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_session() {
		$_POST['mentorId'] = $this->settings->userdata('id');
		
     if ($_FILES["pdf"]["name"]) {
        $pdfTmpName = $_FILES["pdf"]["tmp_name"];
        $pdfContent = 'dfg';
    } else {
        $pdfContent = ''; // Set default value if no PDF was uploaded
    }
	extract($_POST);
    if (empty($id)) {
        $sql = "INSERT INTO `session`(id,mentorId,subject,type,numMentee,register) values(null,'{$mentorId}','{$subject}','{$type}','{$numMentee}','{$pdfContent}')";
    } else {
        $sql = "UPDATE `session` SET {$data} WHERE id = '{$id}'";
    }

    $save = $this->conn->query($sql);

    if ($save) {
        $resp['status'] = 'success';
        if (empty($id)) {
            $this->settings->set_flashdata('success', "New Session successfully saved.");
        } else {
            $this->settings->set_flashdata('success', "Session successfully updated.");
        }
    } else {
        $resp['status'] = 'failed';
        $resp['err'] = $this->conn->error . " [" . $sql . "]";
    }

    return json_encode($resp);
}

	function delete_session(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `session` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Session successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_mentor(){
		
		//$_POST['mentorId'] = $this->settings->userdata('id');
		$offer = implode(",",$_POST["offer"]);
		$_POST['offer'] = $offer;
		if(!empty($_POST['password']))
			$_POST['password'] = md5($_POST['password']);
		else
			unset($_POST['password']);
		
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','oldpassword'))){
				$v = $this->conn->real_escape_string($v);
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($cab_reg_no)){
			$check = $this->conn->query("SELECT * FROM `mentor` where `email` = '{$email}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
			if($this->capture_err())
				return $this->capture_err();
			if($check > 0){
				$resp['status'] = 'failed';
				$resp['msg'] = " Mentor already exist.";
				return json_encode($resp);
				exit;
			}
		}
		if(isset($body_no)){
			$check = $this->conn->query("SELECT * FROM `mentor`` where `studentno` = '{$studentno}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
			if($this->capture_err())
				return $this->capture_err();
			if($check > 0){
				$resp['status'] = 'failed';
				$resp['msg'] = " Student Number # already exist.";
				return json_encode($resp);
				exit;
			}
		}
		if(isset($oldpassword)){
			$cur_pass = $this->conn->query("SELECT `password` from `mentor` where id = '{$this->settings->userdata('id')}'")->fetch_array()[0];
			if(md5($oldpassword) != $cur_pass){
				$resp['status'] = 'failed';
				$resp['msg'] = " Current Password is Incorrect.";
				return json_encode($resp);
				exit;
			}
		}
		
		
		if(empty($id)){
			$sql = "INSERT INTO `mentor` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `mentor` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			$cid = empty($id) ? $this->conn->insert_id : $id;
			$resp['id'] = $cid ;
			if(empty($id))
				$resp['msg'] = " New Mentor successfully saved.";
			else
				$resp['msg'] = " Mentor successfully updated.";
				if($this->settings->userdata('id')  == $cid && $this->settings->userdata('login_type') == 3){
					foreach($_POST as $k => $v){
						if(!in_array($k,['password']))
						$this->settings->set_userdata($k,$v);
					}
					$resp['msg'] = " Account successfully updated.";
				}
				if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
					if(!is_dir(base_app."uploads/dirvers/"))
						mkdir(base_app."uploads/dirvers/");
					$fname = 'uploads/dirvers/'.$cid.'.png';
					$dir_path =base_app. $fname;
					$upload = $_FILES['img']['tmp_name'];
					$type = mime_content_type($upload);
					$allowed = array('image/png','image/jpeg');
					if(!in_array($type,$allowed)){
						$resp['msg'].=" But Image failed to upload due to invalid file type.";
					}else{
						$new_height = 200; 
						$new_width = 200; 
				
						list($width, $height) = getimagesize($upload);
						$t_image = imagecreatetruecolor($new_width, $new_height);
						imagealphablending( $t_image, false );
						imagesavealpha( $t_image, true );
						$gdImg = ($type == 'image/png')? imagecreatefrompng($upload) : imagecreatefromjpeg($upload);
						imagecopyresampled($t_image, $gdImg, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
						if($gdImg){
								if(is_file($dir_path))
								unlink($dir_path);
								$uploaded_img = imagepng($t_image,$dir_path);
								imagedestroy($gdImg);
								imagedestroy($t_image);
						}else{
						$resp['msg'].=" But Image failed to upload due to unkown reason.";
						}
					}
					if(isset($uploaded_img)){
						$this->conn->query("UPDATE mentor` set `image_path` = CONCAT('{$fname}','?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$cid}' ");
						if($id == $this->settings->userdata('id')){
								$this->settings->set_userdata('avatar',$fname);
						}
					}
				}
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if(isset($resp['msg']) && $resp['status'] == 'success'){
			$this->settings->set_flashdata('success',$resp['msg']);
		}
		return json_encode($resp);
	}
	function delete_mentor(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `mentor` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Mentor successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_booking(){
		/*if(empty($_POST['id'])){
			
			$_POST['id'] = $this->settings->userdata('id');
			$_POST['ref_code'] = $prefix.$code;
		}*/
		$_POST['menteeId'] = $this->settings->userdata('id');
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `booking` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `booking` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success'," Session has been booked successfully.");
			else
				$this->settings->set_flashdata('success'," Session Booking successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_booking(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `booking` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Session Booking successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function update_booking_status(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `booking` set `status` = '{$status}' where id = '{$id}' ");
		if($update){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Booking status successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function update_availability_status(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `mentor` set `availability` = '{$availability}' where id = '{$id}' ");
		if($update){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Mentor availability status successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_session':
		echo $Master->save_session();
	break;
	case 'delete_session':
		echo $Master->delete_session();
	break;
	case 'save_mentor':
		echo $Master->save_mentor();
	break;
	case 'delete_mentor':
		echo $Master->delete_mentor();
	break;
	case 'save_booking':
		echo $Master->save_booking();
	break;
	case 'delete_booking':
		echo $Master->delete_booking();
	break;
	case 'update_booking_status':
		echo $Master->update_booking_status();
	break;
	case 'update_availability_status':
		echo $Master->update_availability_status();
	break;
	default:
		// echo $sysset->index();
		break;
}