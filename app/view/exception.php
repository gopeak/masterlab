<HTML>
    <HEAD>
        <title>Masterlab - <?=$code?></title>
        <META http-equiv=Content-Type content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="<?=ROOT_URL?>dev/css/not_found.css">
        <link rel="stylesheet" media="all" href="<?= ROOT_URL ?>gitlab/assets/application.css"/>
        <script type="text/javascript" src="<?= ROOT_URL ?>dev/js/logo.js"></script>
    </HEAD>
<body>

<style type="text/css">
    #debug {max-width: 800px;margin:0 auto; color:#CCC; text-align: left;}
    #debug_in{display: block;}
    #debug_btn{cursor: pointer;  ;}
    #debug_btn:hover{text-decoration: underline;}
    #debug fieldset {margin-top: 2em; display: block; padding:10px;border:1px solid #EEAA00;}
    #debug fieldset legend{margin: 0 10px; padding: 2px 4px; color: #008800;}
    #debug pre{padding: 10px;}
    #debug table{border:1px solid #CCC; border-collapse: collapse; width: 98%; margin: 0 auto; table-layout:fixed}
    #debug table td, #debug table th{word-wrap:break-word;word-break:break-all; border:1px solid #CCC; padding: 5px;}
</style>
<div class="not-found vertical">
    <div class="inner">
        <div class="img" style="padding:100px 0 0;">
        <img src="<?=ROOT_URL?>gitlab/images/logo.png" />
        </div>
        <div class="text">
            <div class="type"><?=$code?></div>
            <div class="info">您所访问的页面被外星人劫持了</div>
            <div class="detail"><?=$message?></div>
            <div class="you-can">
                您可以：
                <a class="btn btn-success" href="#" onclick="history.back()">返回上一页</a>
                <a class="btn btn-default" href="#">返回首页</a>
            </div>
        </div>
    </div>
</div>
<div id="debug">
    <div id="debug_btn" onClick="toggle()">debug</div>
    <div id="debug_in" >


        <fieldset>
            <legend><b>Sql:</b></legend>
            <?php echo '<pre>' . print_r(\main\lib\MyPdo::$sqlLogs, true) . '</pre>'; ?>
        </fieldset>
        <fieldset>
            <legend><b>TRACE:</b></legend>
            <?php echo '<pre>' . print_r($traces, true) . '</pre>'; ?>
        </fieldset>
        <fieldset>
            <legend><b>GET:</b></legend>
            <?php echo '<pre>' . print_r($_GET, true) . '</pre>'; ?>
        </fieldset>
        <fieldset>
            <legend><b>POST:</b></legend>
            <?php echo '<pre>' . print_r($_POST, true) . '</pre>'; ?>
        </fieldset>
        <fieldset>
            <legend><b>FILES:</b></legend>
            <?php echo '<pre>' . print_r($_FILES, true) . '</pre>'; ?>
        </fieldset>
        <fieldset>
            <legend><b>Include:</b> <?php echo count(get_included_files()); ?></legend>
            <?php echo '<pre>' . print_r(get_included_files(), true) . '</pre>'; ?>
        </fieldset>

    </div>
</div>
<script type="text/javascript">


    function toggle(){
        var debug_in=document.getElementById("debug_in");
        var _display = debug_in.style.display;
        if( _display=='none' ) {
            debug_in.style.display = 'block';
        }else{
            debug_in.style.display = 'none';
        }
    }


</script>

</body>
</HTML>
                                                                            
                                                                            
                                                                             
                                                                            
                                                                            
                                                                            
                                                                            