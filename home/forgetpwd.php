<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>忘记密码</title>
    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/md5.js"></script>
    <link rel="stylesheet" href="css/forgetpwd.css">
</head>
<body>
<div id="top">
    <img src="../images/logo.png" height="80px">
</div>
<div id="banner">
<table border="0px">
    <tr><td class="center"><a href="login.html">返回登录</a></td><td></td></tr>
    <tr><td class="aa">请输入账号：</td><td><input type="text" id="userid"></td><td><a id="btnok" href="javascript:void(0)">获取问题</a></td></tr>
    <tr><td class='aa'>密保问题：</td><td id="question"></td></tr>
    <tr><td class='aa'>密保答案：</td><td><input id='answer' type='text'></td></tr>
    <tr><td class='aa'>新密码：</td><td><input id='newpwd' type='text'></td></tr>
    <tr><td class='aa'>再次输入新密码：</td><td><input id='trynewpwd' type='text'></td></tr>
    <tr><td></td><td class='center'><a href='javascript:void(0)' id='submit' >提交</a></td><td></td></tr>
</table>
</div>
</body>
<script>
    $(function () {
        $("#btnok").click(function () {
            var userid=$("#userid").val();
            $.ajax({
                url:"action/forgetpwaaction.php",
                type:"post",
                dataType:"json",
                data:{
                    action:"getquestion",
                    userid:userid
                },
                success:function (response) {
                    var data=eval("("+response+")");
                    if(data.status==1){
                        $("#userid").attr("disabled",true);
                        $("#question").text(data.question);
                        $("#submit").click(function () {
                            var newpwd=$("#newpwd").val();
                            if(newpwd!=$("#trynewpwd").val()){
                                alert("两次输入的密码不同");
                                return false;
                            }
                            newpwd=$.md5(newpwd);
                            var answer=$("#answer").val();
                            var userid=$("#userid").val();
                            $.ajax({
                                url:'action/forgetpwaaction.php',
                                type:"post",
                                dataType:"json",
                                data:{
                                    action:"updatepwd",
                                    userid:userid,
                                    answer:answer,
                                    newpwd:newpwd
                                },
                                success:function (response) {
                                    var data=eval("("+response+")");
                                    if(data.status==1){
                                        alert("密码修改成功");
                                        window.location.href='forgetpwd.php';
                                    }else{
                                        alert(data.message);
                                    }
                                }
                            });
                        });

                    }else
                        alert("您输入的账号还没有注册！！");
                }
            });
        });
    });
</script>
</html>