<html>
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <script src="js/jquery-1.10.2.js"></script>
</head>
<body>
<div id="top">
    <div id="statubox">
        <img src="images/logo.png" height="80px"/>
        <div id="statu">
            <div id="exit"> <a href="exit.php">退出</a></div>
            <div id="username">
               <?php
               session_start();
               if(array_key_exists("username",$_SESSION))
               echo $_SESSION['username'];
               else
                   echo '<a href="home/login.html">去登录</a>'
               ?>
            </div>
            <img id="userimg" src="images/user.png" width="25px"/>
    </div>
    </div>
</div>
<?php
include_once("common/conn.php");
$result= mysqli_query($conn,"select * from t_class");
$type=array();
while($row=mysqli_fetch_assoc($result)){
    $type[$row['cid']]=$row['classname'];

}
$_SESSION['type']=$type;
?>
<div id="navbar">
    <div id="navbarbox">
        <ul>
            <li><a href="user/ArticleHall.php" target="content" class="selected">文章大厅</a></li>
            <li><a href="user/AddArticle.php" target="content">添加文章</a></li>
            <li><a href="user/MyArticle.php" target="content">我的文章</a></li>
            <li><a href="user/PersonalCenter.php" target="content">个人中心</a></li>
            <li><a href="admin/manager.php" target="content">后台管理</a></li>
        </ul>
    </div>
</div>
<div id="contentbox">
<iframe src="user/ArticleHall.php" name="content" id="content" scrolling="no" frameborder="no" width="100%" height="200%"></iframe>
</div>
</body>
<script>
    $(function () {
        $("#navbarbox ul li a").click(function () {
            $("#navbarbox ul li a").removeClass();
            this.className="selected";
        });
    });
</script>
</html>
