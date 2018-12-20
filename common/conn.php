<?php
/**
 * Created by PhpStorm.
 * User: sky
 * Date: 2018/11/4
 * Time: 20:57
 */
$conn=mysqli_connect('localhost','root','root','cmsdb') or die('连接数据库服务器失败！'.mysqli_error());
mysqli_query($conn,'set names utf8');
?>