<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2018/12/10
 * Time: 9:24
 */
$aid=$_POST['aid'];
include_once('../../common/conn.php');
$result=mysqli_query($conn,"delete from t_article where aid=$aid");
echo json_encode("{state:$result}");
?>