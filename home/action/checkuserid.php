<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2018/11/4
 * Time: 20:35
 */
include_once('../../common/conn.php');
$userid=$_POST['userid'];
$reselt=$conn->query('select * from t_user where userid='.$userid);
$num=mysqli_num_rows($reselt);
if($num>0)
    $data = '{statu:1}';
else
    $data= '{statu:0}';
    echo json_encode($data);

?>