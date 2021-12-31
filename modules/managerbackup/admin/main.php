<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2021 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Mon, 20 Dec 2021 07:42:08 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$page_title = $lang_module['main'];

//lấy dữ liệu tỉnh thành
$array_province = $db->query('SELECT * FROM `nv4_location_province`')->fetchAll();

$ajax['action'] = $nv_Request->get_title('action', 'post');
if (!empty($ajax['action'])){
    $ajax['province_id'] = $nv_Request->get_title('province_id', 'post', '');
    $html = '<option value="0">------</option>';
    //lấy dữ liệu quận huyện
    $array_district = $db->query('SELECT id, title_vi FROM `nv4_location_district` WHERE idprovince = '.$ajax['province_id'])->fetchAll();
    foreach ($array_district as $_district){
        $html .= '<option value="'.$_district['id'].'">'.$_district['title_vi'].'</option>';
    }
    die($html);
   
}

$ajax['action1'] = $nv_Request->get_title('action1', 'post');
if (!empty($ajax['action1'])){
    $ajax['district_id'] = $nv_Request->get_title('district_id', 'post', '');
    $html = '<option value="0">------</option>';
    //Lấy dữ liệu phường
    $array_ward = $db->query('SELECT id, title_vi FROM `nv4_location_ward` WHERE iddistrict = '.$ajax['district_id'])->fetchAll();
    foreach ($array_ward as $_ward){
        $html .= '<option value="'.$_ward['id'].'">'.$_ward['title_vi'].'</option>';
    }
    die($html);
}
//lấy dữ liệu cho vào bảng
$sql = 'SELECT * FROM `user_info`';
$array_data = $db->query($sql)->fetchAll();

//Kiểm tra xem có userid không
$data=[]; 
$userid = $nv_Request->get_int('userid','get','0');
if ($userid > 0) {
	$sql = 'WHERE userid = ' . $userid;
	$data = $db->query($sql)->fetch();
}else {
	$data['gender'] = 0;
	$data['province'] = 0;
	$data['district'] = 0;
	$data['ward'] = 0;
}

$data['submit'] = $nv_Request->get_title('submit','post');


$error = $success ='';

if (!empty($submit)) {

		$data['fname'] = $nv_Request->get_title('fname','post','');
		$data['age'] = $nv_Request->get_int('age','post',0);
		$data['address'] = $nv_Request->get_title('address','post','');
		$data['email'] = $nv_Request->get_title('email','post','');
		$data['gender'] = $nv_Request->get_int('gender','post',0);
		$data['province'] = $nv_Request->get_int('province','post',0);
		$data['district'] = $nv_Request->get_int('district','post',0);
		$data['ward'] = $nv_Request->get_int('ward','post',0);
		$data['userid'] = $nv_Request->get_int('userid','post',0);


//------------------------------

	if (empty($data['fname'])){
		$error = 'Lỗi: chưa có họ tên';
	}elseif (empty($data['age'])) {
		$error = 'Lỗi: chưa có tuổi';
	}elseif (empty($data['address'])) {
		$error = 'Lỗi: chưa có địa chỉ';
	}elseif (empty($data['email'])) {
		$error = 'Lỗi: chưa có email';
	}elseif (empty($data['gender'])) {
		$error = 'Lỗi: chưa có giới tính';
	}

	if ($error ==''){
			if ($data['userid'>0]) {
				//update
				$sql = 'UPDATE `user_info` SET `fname`=:fname,`age`=:age,`address`=:address,`email`=:email,`gender`=:gender,`add_time`='.NV_CURRENTTIME.',`province`=:province,`district`=:district,`ward`=:ward WHERE userid='. $data['userid'];
			}else{
				$sql = 'INSERT INTO `user_info`( `fname`, `age`, `address`, `email`, `gender`, `add_time`, `province`,`district`, `ward`) VALUES (:fname, :age, :address, :email, :gender,'.NV_CURRENTTIME.',:province, :district, :ward)';
			}

		
		$stmt = $db->prepare($sql);

		$stmt->bindParam('fname', $data['fname'], PDO::PARAM_STR);
		$stmt->bindParam('age', $data['age'], PDO::PARAM_INT);
		$stmt->bindParam('address', $data['address'], PDO::PARAM_STR);
		$stmt->bindParam('email', $data['email'], PDO::PARAM_STR);
		$stmt->bindParam('gender', $data['gender'], PDO::PARAM_INT);
		$stmt->bindParam('province', $data['province'], PDO::PARAM_INT);		
		$stmt->bindParam('district', $data['district'], PDO::PARAM_INT);
		$stmt->bindParam('ward', $data['ward'], PDO::PARAM_INT);
		$exe = $stmt->execute();

		if ($exe) {
			if ($data['userid'] > 0){
				$success = 'Cập nhật thành công';
			}else{
				$success = 'Thêm mới Thành Công';
			}
		}
	}
}



//------------------------------

$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('USERID', $userid);

$array_gender=[
	'1' => 'Nam',
	'2' => 'Nữ',
	'3' => 'Khác'
];
//in danh sách giới tính

foreach ($array_gender as $key => $_gender) {
	$_gender = [
	'key' => $key,
	'title' => $_gender,
	'checked' => ($key==$data['gender']) ? ' checked' :''
	];

	$xtpl->assign('gender', $_gender);
	$xtpl->parse('main.gender');
}

//Danh sách tỉnh thành
foreach ($array_province as $key => $_province) {
    $_province = [
        'key' => $_province['id'],
        'title' => $_province['title_vi']
    ];
    $xtpl->assign('province', $_province);
    $xtpl->parse('main.province');
}
$array_province_key = array_column($array_province, 'title_vi', 'id');
$array_district_key = array_column($array_district, 'title_vi', 'id');
$array_ward_key = array_column($array_ward, 'title_vi', 'id');
//In dữ liệu thành viên
if (!empty($array_data)) {
	$stt = 0;
	foreach ($array_data as $key => $_data) {
		$_data['stt'] = ++$stt;
		$_data['gender'] = $array_gender[$_data['gender']];
		$_data['address'] .= ' ' . $array_province_key[$_data['province'].' '.$array_district_key[$data['district']. ' ' .$array_ward_key[$data['ward']];

		$_data['link_edit'] = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op . "&userid=" . $_data['userid'];
		$xtpl->assign('DATA', $_data);
		$xtpl->parse('main.loop');

	}
}
}

$xtpl->assign('DATA', $data);

if ($error != ''){
	$xtpl->assign('ERROR',$error);
	$xtpl->parse('main.error');
}

if ($success != ''){
	die('ok');
	$xtpl->assign('success',$success);
	$xtpl->parse('main.success');
}

//-------------------------------
// Viết code xuất ra site vào đây
//-------------------------------

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
