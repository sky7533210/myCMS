<?php
    include_once('../../common/conn.php');
    $userid=$_POST['userid'];
    $password=$_POST['password'];
    $username=$_POST['username'];
    $question=$_POST['question'];
    $answer=$_POST['answer'];
    if(preg_match("/^\d*$/",$userid)) {
        $result = $conn->query("insert into t_user values($userid,'" . $password . "','" . $username . "','" . $question . "','" . $answer . "')");
        if ($result)
            $data = '{statu:1}';
        else
            $data = '{statu:0}';
    }else
        $data = '{statu:0}';
    echo  json_encode($data);
?>