<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2021 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Mon, 20 Dec 2021 07:42:08 GMT
 */

if (!defined('NV_IS_MOD_MANAGERBACKUP')) {
    die('Stop!!!');
}

$page_title = 'nhap thong tin ca nhan';

//------------------
/*if(isset($_POST['Submit'])){

$name=trim($_POST["name"]);
$address=trim($_POST["address"]);
$email=trim($_POST["email"]);

if($name =="") {
  $errorMsg=  "Lỗi : Xin vui lòng nhập tên của bạn.";
  $code= "1" ;
}
//check if email field is empty
elseif($email == ""){
  $errorMsg=  "Lỗi : Xin vui lòng nhập Email.";
  $code= "2";
} //check for valid email 
  elseif(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)){
  $errorMsg= 'Lỗi : Email của bạn không đúng.';
  $code= "2";
}

elseif($address == "") {
  $errorMsg=  "Lỗi : Xin vui lòng nhập địa chỉ.";
  $code= "3";
}
else{
  echo "Success";
  //final code will execute here.
}

}*/
$email = $nv_Request->get_title('email', 'post', '');
$name = $nv_Request->get_title('name', 'post', '');
$address= $nv_Request->get_title('address', 'post', '');
$submit= $nv_Request->get_title('submit', 'post', '');
if (!empty($submit)){
	if($name =="") {
  $errorMsg1=  "Lỗi : Xin vui lòng nhập tên của bạn.";
	}
	elseif($email == ""){
  $errorMsg2=  "Lỗi : Xin vui lòng nhập Email.";
	}
	elseif($address == "") {
  $errorMsg3=  "Lỗi : Xin vui lòng nhập địa chỉ.";
}

}

//------------------



$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('HLang', $errorMsg1);
$xtpl->assign('JLang', $errorMsg2);
$xtpl->assign('KLang', $errorMsg3);


$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
