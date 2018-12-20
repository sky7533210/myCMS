<html>
<head>
    <script src="../js/jquery-1.10.2.js"></script>
    <link rel="stylesheet" href="css/manager.css">
</head>
<body>
<ul>
    <li>文章管理</li>
    <li>用户管理</li>
</ul>
<div id="articlebox">
    <table border="1px">
        <tr><td><input type="text"><a href="javascript:void(0)">搜索</a></td><td>文章管理</td></tr>
        <tr><td><input type="checkbox">全选</td><td>文章标题</td><td>作者</td><td>类别</td><td>发布时间</td><td>操作</td></tr>
    </table>
</div>
<div id="userbox">用户管理</div>
</body>
<script>
    $(function () {
        $("ul li").click(function () {
            switch($(this).index()){
                case 0:
                    $("#userbox").hide();
                    $("#articlebox").show();
                    $.ajax({
                        url:"action/getArticle.php",
                        type:'post',
                        dataType:'json',
                        data:{
                            action:"all"
                        },
                        success:function (response) {
                            var data=eval("("+response+")");
                            var table=$("#articlebox table");
                            for(var i in data){
                                table.append("<tr id='"+data[i]['aid']+"'><td><input type='checkbox'></td><td>"+data[i]['title']+
                                    "</td><td>"+data[i]["username"]+"</td><td>"+data[i]["classname"]+"</td><td>"+data[i]["date"]+"</td></tr>");
                            }
                        }
                    });
                    break;
                case 1:
                    $("#articlebox").hide();
                    $("#userbox").show();
                    break;
            }
        });
    })
</script>
</html>