<?php
include_once('include/access.php');
$query = "Insert into `attachments` (id,attname,attpath,pendingid,documentid) VALUES ";
$queryins = "";
//var_dump($_FILES);
for($i=0; $i<count($_FILES['file']['name']); $i++){
    if(basename( $_FILES['file']['name'][$i]) == "")
        break;
    $target_path = "attachment/";
    $name = str_replace(" ", "_", basename( $_FILES['file']['name'][$i]));
    $ext = explode('.', $name);
    $target_path = $target_path.$ext[0]. time() . "." . $ext[count($ext)-1]; 
    $queryins .= "(NULL, '".$name."','$target_path',0,0),";
    //echo $queryins;
    if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
        //echo "The file has been uploaded successfully <br />";
    } else{
        //echo "There was an error uploading the file, please try again! <br />";
    }
}
if($queryins != ""){
	$queryins = substr($queryins, 0, -1);
	mysqli_query($cxn, $query.$queryins);
	$id = mysqli_insert_id($cxn);
	$str = "";
	for($i=0; $i<count($_FILES['file']['name']); $i++){
		$str .= ($id+$i).",";
	}	
	echo substr($str, 0, -1);
	exit;
}
echo "";
exit;
?>