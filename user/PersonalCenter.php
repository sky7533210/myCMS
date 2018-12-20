<html>
<head>
    <script src="../js/jquery-1.10.2.js"></script>
    <link rel="stylesheet" type="text/css" href="css/PersonalCenter.css">
</head>
<body>
<ul>
<?php
    session_start();
    if(key_exists('userid',$_SESSION)) {
        include_once ('../common/conn.php');
        $result = mysqli_query($conn, "select username,password,question ,answer from t_user where userid=$_SESSION[userid]");
        $row=mysqli_fetch_assoc($result);
        echo "<li><p class='aa'>姓名：</p><p><input type='text' value='$row[username]' disabled='true'></p><p><a id='updatename' href='javascript:void(0)'>修改</a></p></li>";
        echo "<li><p class='aa'>新密码：</p><p><input type='password' disabled='true' ></p><p><a id='updatepassword' href='javascript:void(0)'>修改</a></p></li>";
        echo "<li><p class='aa'>密保问题：</p><p><input type='text' value='$row[question]' disabled='true'></p><p><a id='updatequestion' href='javascript:void(0)'>修改</a></p></li>";
        echo "<li><p class='aa'>答案：</p><p><input type='text' value='$row[answer]' disabled='true'></p><p><a id='updateanswer' href='javascript:void(0)'>修改</a></p></li>";
    }else
        echo "<script>
                if(confirm(\"您还没有登录，是否去登录？？？\"))
                window.parent.location.href=\"../home/login.html\";
               </script>";
?>
</ul>
</body>
<script>
    $(function () {
        $("ul li a").click(function () {
            var message;
            var action = $(this).attr("id")
            switch (action) {
                case "updatename":
                    message = "请输入新的姓名";
                    break;
                case "updatepassword":
                    message = "请输入新的密码";
                    break;
                case "updatequestion":
                    message = "请输入新的密保问题";
                    break;
                case "updateanswer":
                    message = "请输入新的回答";
                    break;
            }

            var value = prompt(message, '');
            if (value !=null){
                $.ajax({
                    url: "action/updatepersonalinfo.php",
                    type: "post",
                    dataType: "json",
                    data: {
                        action: action,
                        value: value
                    },
                    success: function (response) {
                        var data=eval("("+response+")");
                        if(data.status){
                            alert("修改成功，点击确定刷新");
                            window.parent.location.href="../index.php";
                        }else{
                            alert("修改失败");
                        }
                    }
                });
        }
        });
    });
</script>
</html>