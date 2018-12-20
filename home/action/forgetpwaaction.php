<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2018/12/19
 * Time: 14:43
 */
include_once ('../../common/conn.php');
$userid=$_POST['userid'];
$antion=$_POST['action'];
session_start();
if($antion=='getquestion') {
    $result = mysqli_query($conn, "select question,answer from t_user where userid=$userid");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['answer'] = $row['answer'];
        echo json_encode("{status:'1',question:'$row[question]'}");
    } else {
        echo json_encode("{status:'0'}");
    }
}else if($antion=='updatepwd'){
    $answer1=$_POST['answer'];
    $answer2=$_SESSION['answer'];
    $newpwd=$_POST['newpwd'];
    if($answer1==$answer2){
        $result=mysqli_query($conn,"update t_user set password='$newpwd' where userid=$userid");
        if($result)
            echo json_encode("{status:'1'}");
        else echo json_encode("{status:'0',message:'修改失败'}");
    }else{
        echo json_encode("{status:'0',message:'密保问题回答错误'}");
    }
}
?>