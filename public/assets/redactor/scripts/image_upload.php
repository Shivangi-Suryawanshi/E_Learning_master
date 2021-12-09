<?php
 
// This is a simplified example, which doesn't cover security of uploaded images. 
// This example just demonstrate the logic behind the process. 
 
 
// files storage folder

$dir = $_SERVER['DOCUMENT_ROOT'].'/assets/redactor/redactor_files/';

$len = count($_FILES['file']['name']);
$res_array = array();
for($i = 0; $i < $len; $i++) {
    $file_type = strtolower($_FILES['file']['type'][$i]);
    if ($file_type == 'image/png'
        || $file_type == 'image/jpg'
        || $file_type == 'image/gif'
        || $file_type == 'image/jpeg'
        || $file_type == 'image/pjpeg')
    {
        // setting file's mysterious name
        $filename = md5(date('YmdHis')).'.jpg';
        $file = $dir.$filename;

        // copying
        copy($_FILES['file']['tmp_name'][$i], $file);

        $res_array['file-'.$i] = ['url' => '/assets/redactor/redactor_files/'.$filename,
            'id'=>time()];




    }
}
echo stripslashes(json_encode($res_array));
 //print_r($_FILES['file']['tmp_name'][0]);
//$file_type = strtolower($_FILES['file']['type'][0]);
//
//if ($file_type == 'image/png'
//|| $file_type == 'image/jpg'
//|| $file_type == 'image/gif'
//|| $file_type == 'image/jpeg'
//|| $file_type == 'image/pjpeg')
//{
//    // setting file's mysterious name
//    $filename = md5(date('YmdHis')).'.jpg';
//   $file = $dir.$filename;
////echo $_FILES['file']['tmp_name'];
//    // copying
//    copy($_FILES['file']['tmp_name'][0], $file);
//
//    // displaying file
//	$array = array('file-0'=>[
//		'url' => '/redactor/redactor_files/'.$filename,
//        'id'=>'345454354']
//	);
//
//	echo stripslashes(json_encode($array));
//
//}
 
?>