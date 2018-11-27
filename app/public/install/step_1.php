<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $html_title;?></title>
<link href="css/install.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.js"></script>
<script>
$(document).ready(function(){
    $('#next').on('click',function(){
        if (typeof($('.no').html()) == 'undefined'){
            $(this).attr('href','index.php?step=2');
        }else{
            alert($('.no').eq(0).parent().parent().find('td:first').html()+' 未通过检测!');
            $(this).attr('href','###');
        }
    });
});
</script>
</head>
<body>
<?php echo $html_header;?>
<div class="main">
  <div class="step-box" id="step1">
    <div class="text-nav">
      <h1>Step.1</h1>
      <h2>开始安装</h2>
      <h5>检测服务器环境及文件目录权限</h5>
    </div>
    <div class="procedure-nav">
      <div class="schedule-ico"><span class="a"></span><span class="b"></span><span class="c"></span><span class="d"></span></div>
      <div class="schedule-point-now"><span class="a"></span><span class="b"></span><span class="c"></span><span class="d"></span></div>
      <div class="schedule-point-bg"><span class="a"></span><span class="b"></span><span class="c"></span><span class="d"></span></div>
      <div class="schedule-line-now"><em></em></div>
      <div class="schedule-line-bg"></div>
      <div class="schedule-text"><span class="a">检查安装环境</span><span class="b">选择安装方式</span><span class="c">创建数据库</span><span class="d">安装</span></div>
    </div>
  </div>
  <div class="content-box">
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <caption>
      环境检查
      </caption>
      <tr>
        <th scope="col">项目</th>
        <th width="25%" scope="col">程序所需</th>
        <th width="25%" scope="col">最佳配置推荐</th>
        <th width="25%" scope="col">当前服务器</th>
      </tr>
      <?php foreach($env_items as $v){?>
      <tr>
        <td scope="row"><?php echo $v['name'];?></td>
        <td><?php echo $v['min'];?></td>
        <td><?php echo $v['good'];?></td>
        <td><span class="<?php echo $v['status'] ? 'yes' : 'no';?>"><i></i><?php echo $v['cur'];?></span></td>
      </tr>
      <?php }?>
    </table>
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <caption>
      目录、文件权限检查
      </caption>
      <tr>
        <th scope="col">目录文件</th>
        <th width="25%" scope="col">所需状态</th>
        <th width="25%" scope="col">当前状态</th>
      </tr>
      <?php foreach($dirfile_items as $k => $v){?>
      <tr>
        <td><?php echo $v['path'];?> </td>
        <td><span>可写</span></td>
        <td><span class="<?php echo $v['status'] == 1 ? 'yes' : 'no';?>"><i></i><?php echo $v['status'] == 1 ? '可写' : '不可写';?></span></td>
      </tr>
      <?php }?>
    </table>
    <table width="100%" border="0" cellspacing="2" cellpadding="0">
      <caption>
      函数检查
      </caption>
      <tr>
        <th scope="col">目录文件</th>
        <th width="25%" scope="col">所需状态</th>
        <th width="25%" scope="col">当前状态</th>
      </tr>
      <?php foreach($func_items as $k =>$v){?>
      <tr>
        <td><?php echo $v['name'];?>()</td>
        <td><span>支持</span></td>
        <td><span class="<?php echo $v['status'] == 1 ? 'yes' : 'no';?>"><i></i><?php echo $v['status'] == 1 ? '支持' : '不支持';?></span></td>
      </tr>
      <?php }?>
    </table>
  </div>
  <div class="btn-box"><a href="index.php" class="btn btn-primary">上一步</a><a href='###' id="next" class="btn btn-primary">下一步</a></div>
</div>
<?php ECHO $html_footer;?>
</body>
</html>
