<html>
<head>
    <link type="text/css" rel="stylesheet" href="css/AddArticle.css">
    <script src="../js/jquery-1.10.2.js"></script>
    <link rel="stylesheet" type="text/css" href="../kindeditor/themes/default/default.css">
    <script charset="UTF-8" src="../kindeditor/kindeditor-all-min.js"></script>
    <script charset="UTF-8" src="../kindeditor/lang/zh-CN.js"></script>
</head>
<body>
<?php
session_start();
if(!array_key_exists('userid',$_SESSION)){
    echo '<script>
if(confirm("您还没有登录，不能添加文章，是否去登录？？？"))
    window.parent.location.href="../home/login.html";
</script>';
}
?>
<form method="post" action="">
  <ul>
    <li><p class="bb">文章标题：</p><input type="text" id="title" class="aa"><p></li>
    <li style="margin-top: -30px"><p class="bb">文章类别：
        </p>
        <select id="type" class="aa">
            <?php
            session_start();
            $type=$_SESSION['type'];
            foreach ($type as $key=>$value){
                echo "<option id='$key'>$value</option>";
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
    <li id="bu"><a href="javascript:void(0)" id="publish">发布</li>
</ul>
</form>
</body>
<script>
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="content"]', {
            resizeType : 1,
            allowPreviewEmoticons : false,
            allowImageUpload : false,
            items : [
                'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'image', 'link'],
            autoHeightMode : true,
            afterCreate : function() {
                this.loadPlugin('autoheight');
            }
        });
        K('#publish').click(function(e) {
            var title=$("#title").val().trim();
            var typeid=$("#type option:selected").attr('id');
            var text=editor.html();
            if(title==""||text==""){
                alert("请把内容填写完整");
                return false;
            }
            $.ajax({
                url:"action/addAction.php",
                type:"post",
                dataType:"json",
                data:
                    {
                        title:title,
                        cid:typeid,
                        text:text
                    },
                success:function (response) {
                    var data=eval('('+response+')');
                    if(data.status==1){
                        alert("发布成功");
                        $("#title").val("");
                        editor.html("");
                        return true;
                    }else{
                        alert("发布失败");
                        return false;
                    }
                }
            });
        });
    });
</script>
</html>
