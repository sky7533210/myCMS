<html>
<head>
    <script src="../js/jquery-1.10.2.js"></script>
    <link rel="stylesheet" type="text/css" href="css/MyArticle.css">
    <link rel="stylesheet" type="text/css" href="../kindeditor/themes/default/default.css">
    <script charset="UTF-8" src="../kindeditor/kindeditor-all-min.js"></script>
    <script charset="UTF-8" src="../kindeditor/lang/zh-CN.js"></script>
</head>
<body>
<table border="1px" cellspacing="0" cellpadding="0">
<?php
    session_start();
    if(key_exists('userid',$_SESSION)) {
        include_once('../common/conn.php');
        $userid = $_SESSION['userid'];
        $result = mysqli_query($conn, "select aid, title,date from t_article where userid=$userid");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr id='$row[aid]'><td>".$row['aid'].'</td><td class="title">'.$row['title'] .'</td><td>'.$row['date'].'</td><td class="update">修改</td><td class="delete">删除</td></tr>';
        }
    }else{
        echo "<script>
                if(confirm(\"您还没有登录，不能添加文章，是否去登录？？？\"))
                window.parent.location.href=\"../home/login.html\";
               </script>";
    }
?>
</table>
<div id="updatebox">
    <div id="back"><a href="javascript:void(0)">返回</a></div>
    <ul>
        <li><p class="bb">文章标题：</p><input type="text" id="title" class="aa"><p></li>
        <li style="margin-top: -30px"><p class="bb">文章类别：
            </p>
            <select id="type" class="aa">
                <?php
                $type=$_SESSION['type'];
                foreach ($type as $key=>$value){
                    echo "<option class='$key'>$value</option>";
                }
                ?>
            </select>
            <p>
        </li>
        <li style="margin-top: -30px"><p class="bb">正文：</p>
            <p class="aa">
                <textarea name="content" style="width:870px;height:300px;visibility:hidden;"></textarea>
            </p>
        </li>
        <li id="bu"><a href="javascript:void(0)" id="updateok">确认修改</li>
    </ul>
</div>
</body>
<script>
    var aid;
    $(function () {
        $("table .delete").click(function () {
          var aid=$(this).parent().attr("id");
          var thisrow=$(this).parent();
            $.ajax({
                url:'action/ationDeleteAritle.php',
                type:'post',
                dataType:'json',
                data:{
                    aid:aid
                },
                success:function (response) {
                    var data=eval("("+response+")");
                    if(data['state']){
                        thisrow.remove();
                        alert("删除成功");
                    }else{
                        alert("删除失败");
                    }
                }
            });
        });
        $("#back").click(function () {
            $("#updatebox").hide();
            $("table").show();
        });
        $(".update").click(function () {
            var _this=$(this);
            aid=_this.parent().attr("id");
            $.ajax({
                url:"action/getTextContentAction.php",
                type:"post",
                dataType:"json",
                data:{
                    aid:aid
                },
                success:function (response) {
                    var tempdata=response.replace(/</g,"&lt");
                    tempdata=tempdata.replace(/>/g,"&gt");
                    tempdata=tempdata.replace(/\"/g,"&quot");
                    tempdata=tempdata.replace(/\n/g,"");
                    tempdata=tempdata.replace(/\t/g,"");
                    var data=eval("("+tempdata+")");
                    var text=data['text'];
                    tempdata=text.replace(/&lt/g,"<");
                    tempdata=tempdata.replace(/&gt/g,">");
                    tempdata=tempdata.replace(/&quot/g,"\"");
                    $("#title").val( _this.siblings(".title").text());
                    var type=data['cid'];
                    $("#type ."+type).attr("selected",true);
                    editor.html(tempdata);
                    $("table").hide();
                    $("#updatebox").show();
                }
            });
        })
    });
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="content"]', {
            resizeType: 1,
            allowPreviewEmoticons: false,
            allowImageUpload: false,
            items: [
                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'image', 'link'],
            autoHeightMode: true,
            afterCreate: function () {
                this.loadPlugin('autoheight');
            }
        });
        K('#updateok').click(function (e) {
            var title = $("#title").val().trim();
            var typeid = $("#type option:selected").attr('class');
            var text = editor.html();
            if (title == "" || text == "") {
                alert("请把内容填写完整");
                return false;
            }
            $.ajax({
                url: "action/updateArticle.php",
                type: "post",
                dataType: "json",
                data: {
                    aid:aid,
                    title: title,
                    cid: typeid,
                    text: text
                },
                success: function (response) {
                    var data = eval('(' + response + ')');
                    if (data.status == 1) {
                        alert("修改成功");
                        return true;
                    } else {
                        alert("修改失败");
                        return false;
                    }
                }
            });
        });
    });
</script>
</html>
