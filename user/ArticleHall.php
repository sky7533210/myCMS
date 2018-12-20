<html>
<head>
    <link type="text/css" rel="stylesheet" href="css/ArticleHall.css">
    <script src="../js/jquery-1.10.2.js"></script>
    <link rel="stylesheet" type="text/css" href="../kindeditor/themes/default/default.css">
    <script charset="UTF-8" src="../kindeditor/kindeditor-all-min.js"></script>
    <script charset="UTF-8" src="../kindeditor/lang/zh-CN.js"></script>
    <meta charset="utf-8">
</head>
<body>
<ul id="typelist">
    <li id="good" class="selected">好评</li>
    <?php
    session_start();
    $type=$_SESSION['type'];
    foreach ($type as $key=>$value){
        echo "<li id='$key'>$value</li>";
    }
    ?>
</ul>
<div id="content">
    <div id="titlelist">
        <table id="table1"><tr class="tablehead"><td class="aa">文章标题</td><td class="bb">作者</td><td>发布时间</td></tr> </table>
        <table id="table2"><tr class="tablehead"><td class="aa">文章标题</td><td class="bb">作者</td><td>发布时间</td></tr> </table>
    </div>
    <div id="textbody">
        <div id="back"><a href="javascript:void(0)">返回</a></div>
        <div id="text"><form> <textarea name="content" style="width:800px;height:300px;visibility:hidden;"></textarea></form></div>
        <div id="writecomment">
            <p id="aaa">写评论：</p><p><form> <textarea name="comment" style="width:730px;height:120px;visibility:hidden;"></textarea></form></p>
            <p><a href="javascript:void(0)" id="publish">发表</a></p>
        </div>
        <div id="listcomment">
            <ul>
            </ul>
        </div>
    </div>
</div>
</body>
<script>
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="content"]', {
            resizeType: 0,
            readonlyMode:true,
            allowPreviewEmoticons: false,
            allowImageUpload: false,
            items: [],
            autoHeightMode: true,
            afterCreate: function () {
                this.loadPlugin('autoheight');
            }
        });
    });
    var editorcomment;
    KindEditor.ready(function(K) {
        editorcomment = K.create('textarea[name="comment"]', {
            resizeType: 0,
            allowPreviewEmoticons: false,
            allowImageUpload: false,
            items: [ 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
                'insertunorderedlist', '|', 'emoticons', 'image', 'link'],
        });
        K("#publish").click(function () {
            var aid=$("#text").attr("class");
            var commentcontent=editorcomment.text();
            if(commentcontent==''){
                alert("你还没有写评论内容");
                return false;
            }
            $.ajax({
                url:"action/addcomment.php",
                type:"post",
                dataType:"json",
                data:{
                    aid:aid,
                    content:commentcontent
                },
                success:function (response) {
                    var data=eval("("+response+")");
                    if(data['status']==0){
                        alert("评论失败");
                    }else if(data['status']==1){
                        var username="<?php if(key_exists('username',$_SESSION))  echo $_SESSION['username']; else echo ''?>";
                        var date="<?php date_default_timezone_set('PRC');echo date('Y-m-d H:i:s');?>";
                        $("#listcomment ul").append("<li>"+username+'：'+commentcontent+'--------'+date+"</li>");
                        alert("评论成功");
                        editorcomment.html('');

                    }else{
                        if(confirm("您还没有登录，不能添加文章，是否去登录？？？"))
                            window.parent.location.href="../home/login.html";
                    }
                }
            });
        });
    });
    $(function () {
        showTitle('good');
                $("#typelist li").click(function () {
                    $("#typelist li").removeClass();
                    showTitle(this.id);
                    this.className='selected';
                });
                $("#back").click(function () {
                    $("#textbody").hide();
                    $("#titlelist").show();
                });
                $("#publish").click(function () {
                    var aid= $("#title").attr("class");
                    $.ajax({
                        url:'action/publishComment.php',
                        type:'post',
                        dataType:'json'
                    });
                });
    });
    function showTitle(class_id) {
        $("#titlelist table tr").remove(":not(.tablehead)");
        $.ajax({
            url:'action/showArticleTitle.php',
            type:'post',
            dataType:'json',
            data:{
                class_id:class_id
            },
            success:function (response) {
                var data=eval("("+response+")");
                 var table1=$("#table1");
                 var table2=$("#table2");
                 for(i in data){
                 if(i%2==0)
                 table1.append("<tr id="+data[i]['aid']+"><td class='aa'>"+data[i]['title']+"</td><td class='bb'>"+data[i]['username']+"</td><td class='cc'>"+data[i]['date']+"</td></tr>");
                 else
                 table2.append("<tr id="+data[i]['aid']+"><td class='aa'>"+data[i]['title']+"</td><td class='bb'>"+data[i]['username']+"</td><td class='cc'>"+data[i]['date']+"</td></tr>");
                 }
                addTitleClick();
                $("#textbody").hide();
                $("#titlelist").show();
            }
        });
    }
    function  addTitleClick() {
        $("#content table tr:not(.tablehead)").click(function () {
            var aid=this.id;
            $.ajax({
                url:'action/getTextContentAction.php',
                type:'post',
                dataType:'json',
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
                    tempdata="<h1 style='text-align: center'>"+$("#"+aid+" .aa").text()+"</h1>"+ "<p style='text-align: end ;'>"+"作者："
                        +$("#"+aid+" .bb").text()+"</p>"+tempdata+"<p style='text-align: end;'>"+"发布时间："+$("#"+aid+" .cc").text()+"</p>"
                    editor.html(tempdata);
                    $("#text").attr("class",aid);
                    var commentcontent=data['comment'];
                    var listcomment=$("#listcomment ul");
                    listcomment.html("");
                    for(var i in commentcontent){
                        var content=commentcontent[i]['content'];
                        content=content.replace(/&lt/g,"<");
                        content=content.replace(/&gt/g,">");
                        content=content.replace(/&quot/g,"\"");
                       listcomment.append('<li>'+commentcontent[i]['username']+'：'+content+'--------'+commentcontent[i]['date']+'</li>');
                    }
                    $("#titlelist").hide();
                    $("#textbody").show();
                }
            });
        });
    }
</script>
</html>