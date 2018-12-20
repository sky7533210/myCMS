<?php
header('Content-type:text/html;charset=utf8');
include_once('../../common/conn.php');
$userid= $_POST['userid'];
$password=$_POST['password'];
if(preg_match("/^\d+$/",$userid)) {
    $result = $conn->query('select * from t_user where userid=' . $userid);
    $num = mysqli_num_rows($result);
    if ($num > 0) {
        $result2 = $conn->query("select password from t_user where userid=" . $userid);
        $array = mysqli_fetch_object($result2);
        if ($password == $array->password) {
            $data = '{statu:1,message:"登入成功"}';
            session_start();
            $result3= $conn->query("select username from t_user where userid=" . $userid);
            $array = mysqli_fetch_object($result3);
            $_SESSION['username']=$array->username;
            $_SESSION['userid']=$userid;
        }
        else
            $data = '{statu:0,message:"账号或密码错误"}';
    } else
        $data = '{statu:0,message:"账号或密码错误"}';
}else{
    $data = '{statu:0,message:"账号应全为数字"}';
}
echo json_encode($data);
?>