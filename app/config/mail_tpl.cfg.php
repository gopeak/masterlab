<?php

$_config['tpl']['reset_password'] = '
<div >
    <p>您好 <a href="mailto:{{email}}" target="_blank">{{email}}</a>!</p>
    <p>
        感谢您注册 {{site_name}}，请点击以下链接重置密码
    </p>
    <p><a href="{{url}}" target="_blank">{{url}}</a></p>

    <p>如果你没有请求重置密码，请忽略这封邮件.</p>
    <p>在你点击上面链接修改密码之前，你的密码将会保持不变</p> 
    <br><br> 
</div>
';

$_config['tpl']['active_email'] = '
<div >
    <p>您好 {{display_name}}!</p>
    <p>
        感谢您注册 {{site_name}}，请点击以下链接激活账号
    </p>
    <p><a href="{{url}}" target="_blank">{{url}}</a></p>

    <p>{{site_name}} 祝您使用愉快!</p> 
    <br><br> 
</div>
';

$_config['tpl']['invite_email'] = '
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="zh_cn">
<head>
<meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta content="IE=edge" http-equiv="X-UA-Compatible" />
<title>{{admin}} 邀请你加入到项目 {{org_path}}/{{project_key}}</title>
<style data-premailer="ignore" type="text/css">
body,table,td,a{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}table,td{mso-table-lspace:0pt;mso-table-rspace:0pt}img{-ms-interpolation-mode:bicubic}.hidden{display:none !important;visibility:hidden !important}a[x-apple-data-detectors]{color:inherit !important;text-decoration:none !important;font-size:inherit !important;font-family:inherit !important;font-weight:inherit !important;line-height:inherit !important}div[style*=\'margin: 16px 0\']{margin:0 !important}@media only screen and (max-width: 639px){body,#body{min-width:320px !important}table.wrapper{width:100% !important;min-width:320px !important}table.wrapper td.wrapper-cell{border-left:0 !important;border-right:0 !important;border-radius:0 !important;padding-left:10px !important;padding-right:10px !important}}

</style>

<style>body {
margin: 0 !important; background-color: #fafafa; padding: 0; text-align: center; min-width: 640px; width: 100%; height: 100%; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
}
</style></head>
<body style="text-align: center; min-width: 640px; width: 100%; height: 100%; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; margin: 0; padding: 0;" bgcolor="#fafafa">
<table border="0" cellpadding="0" cellspacing="0" id="body" style="text-align: center; min-width: 640px; width: 100%; margin: 0; padding: 0;" bgcolor="#fafafa">
<tbody>
<tr class="line">
<td style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; height: 4px; font-size: 4px; line-height: 4px;" bgcolor="#6b4fbb"></td>
</tr>
<tr class="header">
<td style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 13px; line-height: 1.6; color: #5c5c5c; padding: 25px 0;">

<img alt="Masterlab" src="{{logo_url}}" width="55" height="50" />
</td>
</tr>
<tr>
<td style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;">
<table border="0" cellpadding="0" cellspacing="0" class="wrapper" style="width: 640px; border-collapse: separate; border-spacing: 0; margin: 0 auto;">
<tbody>
<tr>
<td class="wrapper-cell" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; border-radius: 3px; overflow: hidden; padding: 18px 25px; border: 1px solid #ededed;" align="left" bgcolor="#ffffff">
<table border="0" cellpadding="0" cellspacing="0" class="content" style="width: 100%; border-collapse: separate; border-spacing: 0;">
<tbody>
<tr>
<td class="text-content" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: #333333; font-size: 15px; font-weight: 400; line-height: 1.4; padding: 15px 5px;" align="center">
<p>
You have been invited
by
<a href="{{root_url}}" style="color: #3777b0; text-decoration: none;">{{admin}}</a>
to join the
<a class="highlight" href="{{project_url}}" style="color: #3777b0; text-decoration: none; font-weight: 500;">{{org_path}}/{{project_key}}</a>
project as <span class="highlight" style="font-weight: 500;">Developer</span>.
</p>
<p>
<a href="{{root_url}}passport/invite/accept/{{token}}" style="color: #3777b0; text-decoration: none;">立即加入</a>
or
<a href="{{root_url}}passport/invite/decline/{{token}}" style="color: #3777b0; text-decoration: none;">拒 绝</a>
</p>
</td>
</tr>

</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>

<tr class="footer">
<td style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 13px; line-height: 1.6; color: #5c5c5c; padding: 25px 0;">
<img alt="Masterlab" src="{{logo_url}}"   style="display: none; margin: 0 auto 1em;" />
<div>
Masterlab--一款基于事项驱动和敏捷开发的项目管理工具 <a class="mng-notif-link" href="http://www.masterlab.vip" style="color: #3777b0; text-decoration: none;">Masterlab官方网站</a> &#183; <a class="help-link" href="http://www.masterlab.vip/help.php" style="color: #3777b0; text-decoration: none;">Help</a>
</div>
</td>
</tr>

<tr>
<td class="footer-message" style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-size: 13px; line-height: 1.6; color: #5c5c5c; padding: 25px 0;">

</td>
</tr>
</tbody>
</table>
</body>
</html>

';


return $_config;