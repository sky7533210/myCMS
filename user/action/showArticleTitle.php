<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2018/12/2
 * Time: 1:35
 */
include_once("../../common/conn.php");
$type= $_POST['class_id'];
$data='[';
if($type=='good'){
  $result= mysqli_query($conn,'select aid,title,date,userid from t_article');
    while ($row=mysqli_fetch_assoc($result)){
        $data=$data."{aid:'$row[aid]',title:'$row[title]',";
        $result2=mysqli_query($conn,"select username from t_user where userid='$row[userid]'");
        $row2=mysqli_fetch_assoc($result2);
        $data=$data."username:'$row2[username]',date:'$row[date]'},";

    }
}else{
    $result= mysqli_query($conn,"select aid,title,date,userid from t_article where cid='$type'");
    while ($row=mysqli_fetch_assoc($result)){
        $data=$data."{aid:'$row[aid]',title:'$row[title]',";
        $result2=mysqli_query($conn,"select username from t_user where userid='$row[userid]'");
        $row2=mysqli_fetch_assoc($result2);
        $data=$data."username:'$row2[username]',date:'$row[date]'},";

    }
}
$data= substr($data,0,strlen($data)-1);
$data=$data.']';
echo json_encode($data);
?>