<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2018/12/4
 * Time: 11:15
 */

include_once("../../common/conn.php");
session_start();
if(key_exists('userid',$_SESSION)) {
    $aid = $_POST['aid'];
    $userid = $_SESSION['userid'];
    date_default_timezone_set('PRC');
    $date = date("Y-m-d H:i:s");
    $content = $_POST['content'];
    $result = mysqli_query($conn, "insert into t_comment(aid,userid,date,content) values($aid,$userid,'$date','$content')");
    echo json_encode("{status:$result}");
}else{
    echo json_encode("{status:2}");
}
?>