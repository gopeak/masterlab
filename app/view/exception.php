<HTML>
    
    <HEAD>
        <TITLE>
            Exception
        </TITLE>
            <META http-equiv=Content-Type content="text/html; charset=utf-8">
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
错误代码： <span style="color:red"><?=$code?></span><br/>

错误描述：<span style="color:red"> <?=$message?></span><br/>

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
                                                                            
                                                                            
                                                                             
                                                                            
                                                                            
                                                                            
                                                                            