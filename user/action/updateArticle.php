<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2018/12/13
 * Time: 15:03
 */
include_once ('../../common/conn.php');
$aid=$_POST['aid'];
$title=$_POST['title'];
$cid=$_POST['cid'];
$text=$_POST['text'];
date_default_timezone_set('PRC');
$date = date("Y-m-d H:i:s");
$result=mysqli_query($conn,"update t_article set title='$title',cid='$cid',text='$text',date='$date' where aid='$aid'");
echo json_encode("{status:'$result'}");
?>