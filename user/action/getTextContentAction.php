<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2018/12/2
 * Time: 13:10
 */
include_once("../../common/conn.php");
header('Content-type:text/html;charset=utf8');
$aid=$_POST['aid'];
$row=mysqli_fetch_assoc(mysqli_query($conn,"select cid,text from t_article where aid=$aid"));
$data="{cid:'$row[cid]',text:'$row[text]',comment:[";
$result=mysqli_query($conn,"select userid,date,content from t_comment where aid=$aid order by date");
$rownum=mysqli_num_rows($result);
if($rownum>0) {
    while ($row1 = mysqli_fetch_assoc($result)) {
        $row2 = mysqli_fetch_assoc(mysqli_query($conn, "select username from t_user where userid=$row1[userid]"));
        $data = $data . "{username:'$row2[username]',content:'$row1[content]',date:'$row1[date]'},";
    }
    $data = substr($data, 0, strlen($data) - 1);
}
$data=$data.']}';
echo json_encode($data);
?>