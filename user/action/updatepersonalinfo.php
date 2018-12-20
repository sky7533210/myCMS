<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2018/12/17
 * Time: 8:23
 */
include_once ("../../common/conn.php");
session_start();
$value=$_POST['value'];
$action=$_POST['action'];
$userid=$_SESSION['userid'];
$result;
switch ($action){
    case 'updatename':
        $result=mysqli_query($conn,"update t_user set username='$value' where userid=$userid");
        $_SESSION['username']=$value;
        break;
    case 'updatepassword':
        $value=md5($value);
        $result=mysqli_query($conn,"update t_user set password='$value' where userid=$userid");
        break;
    case 'updatequestion':
        $result=mysqli_query($conn,"update t_user set question='$value' where userid=$userid");
        break;
    case 'updateanswer':
        $result=mysqli_query($conn,"update t_user set answer='$value' where userid=$userid");
        break;
}
echo json_encode("{status:$result}");
?>