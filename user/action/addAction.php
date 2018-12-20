<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2018/11/29
 * Time: 15:03
 */
    include_once("../../common/conn.php");
    session_start();
    if(array_key_exists('userid',$_SESSION)) {
        $userid = $_SESSION['userid'];
        $cid = $_POST['cid'];
        date_default_timezone_set('PRC');
        $date = date("Y-m-d H:i:s");
        $title = $_POST['title'];
        $text = $_POST['text'];
        $result = mysqli_query($conn, "insert into t_article(userid,cid,date,title,text) values('$userid','$cid','$date','$title','$text')");
        echo json_encode("{status:'$result'}");
    }else{
        echo json_encode("{status:'0'}");
    }

?>