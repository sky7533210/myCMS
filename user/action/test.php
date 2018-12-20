<html>
<head>
    <meta charset="utf-8">
    <style>
        form {
            margin: 0;
        }
        textarea {
            display: block;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="../../kindeditor/themes/default/default.css">
    <script charset="UTF-8" src="../../kindeditor/kindeditor-all-min.js"></script>
    <script charset="UTF-8" src="../../kindeditor/lang/zh-CN.js"></script>
    <script src="../../js/jquery-1.10.2.js"></script>
    <script>
        $(function () {
            var temp='<?php session_start(); echo $_SESSION['username'];?>';
            var date="<?php date_default_timezone_set('PRC');echo date('Y-m-d H:i:s');?>";
            $("p").text(date);
        });
    </script>
</head>
<body>
<p></p>
</body>
</html>