<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2018/12/20
 * Time: 14:36
 */
include_once ("../../common/conn.php");
$resultclass=mysqli_query($conn,"select cid,classname from t_class order by cid");
$arrayclass=array();
while($row=mysqli_fetch_assoc($resultclass))
$arrayclass[$row['cid']]=$row['classname'];
$data='[';
$resultdata=mysqli_query($conn,"select aid,userid,cid,title,date from t_article order by cid");
if(mysqli_num_rows($resultdata)>0) {
    while ($row = mysqli_fetch_assoc($resultdata)) {
        $resultusername = mysqli_query($conn, "select username from t_user where userid='$row[userid]'");
        $rowusername=mysqli_fetch_assoc($resultusername);
        $class=$arrayclass[$row['cid']];
        $data=$data."{aid:'$row[aid]',title:'$row[title]',username:'$rowusername[username]',classname:'$class',date:'$row[date]'},";
}
$data=substr($data,0,strlen($data)-1);
    $data=$data.']';
}else {
    $data = $data . ']';
}

echo json_encode($data);
?>