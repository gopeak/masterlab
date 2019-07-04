<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/setting.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>

    <script src="<?=ROOT_URL?>dev/lib/bootstrap-select/js/bootstrap-select.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/bootstrap-select/css/bootstrap-select.css" rel="stylesheet">

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body system-page">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
</script>

<div class="page-with-sidebar">
    <? require_once VIEW_PATH.'gitlab/admin/common-page-nav-admin.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid ">

            <div class="content" id="content-body">

                <?php include VIEW_PATH.'gitlab/admin/common_system_left_nav.php';?>
                <div class="row has-side-margin-left">
                    <div class="col-lg-12">
                        <div class="top-area">
                            <ul class="nav-links">
                                <li class="active">
                                    <a href="#">发送邮件</a>
                                </li>
                                <li>
                                    <span class="hint">注意: 一个用户只会收到一封邮件，哪怕他属于不同的用户组或项目角色。</span>
                                </li>
                            </ul>
                            <div class="nav-controls">
                                <div class="btn-group" role="group">
                                </div>
                            </div>
                        </div>
                        <div class="content-list prepend-top-default">
                            <form class="form-horizontal issue-form common-note-form js-quick-submit js-requires-input gfm-form"
                                  id="send_mail_form" action="/admin/system/send_mail_post" accept-charset="UTF-8" method="post">
                                <input name="utf8" type="hidden" value="✓">
                                <input type="hidden" name="authenticity_token" value="">

                                <div class="form-group">
                                    <label class="control-label" for="issue_title">发送至:</label>

                                    <div class="col-sm-10">

                                            <input type="radio" value="project" name="params[send_to]"  >
                                            <strong>项目及角色&nbsp;</strong>
                                            <select id="to_project" name="params[to_project][]" class="selectpicker"  data-live-search="true"  multiple title="选择项目"   >

                                            </select>
                                 <!--           <select   id="to_role" name="params[to_role][]" class="selectpicker  " showTick="true"   multiple title="选择角色"   >

                                            </select>-->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="issue_title"></label>
                                    <div class="col-sm-10">

                                            <input type="radio" value="group" name="params[send_to]"  >
                                            <strong>用户组&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                                        <select id="to_group" name="params[to_group][]" class="selectpicker show-tick " dropdownAlignRight="true" showTick="true"  multiple title="选择用户组"   >

                                        </select>

                                    </div>
                                </div>

                                <div class="form-group" style="display: none">
                                    <label class="control-label" for="issue_title">抄送:</label>

                                    <div class="col-sm-10">
                                        <input  maxlength="255" autofocus="autofocus" autocomplete="off" class="form-control pad" size="255" type="text" name="params[reply]" id=send_reply">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="issue_title">主题:</label>

                                    <div class="col-sm-10">
                                        <input required="required" maxlength="255" autofocus="autofocus" autocomplete="off" class="form-control pad" size="255" type="text" name="params[title]" id="send_title">

                                    </div>
                                </div>
                                <div class="form-group detail-page-description">
                                    <label class="control-label" for="issue_description">正文:</label>
                                    <div class="col-sm-10">
                                        <textarea placeholder="请输入邮件正文" class="form-control" rows="8" maxlength="250" name="params[content]" id="send_content"></textarea>
                                    </div>
                                </div>
                                <div class="form-group detail-page-description">
                                    <label class="control-label" for="issue_description">消息类型:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="send_content_type" name="params[content_type]">
                                            <option value="html" selected="">
                                                HTML
                                            </option>
                                            <option value="text" >
                                                Text
                                            </option>
                                        </select>
                                    </div>
                                </div>

                               <!-- <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label for="issue_confidential">
                                                <input name="issue[confidential]" type="hidden" value="0">
                                                <input type="checkbox" value="1" name="params[blind]" id="send_blind">
                                                暗送
                                            </label></div>
                                    </div>
                                </div>-->

                                <div class="row-content-block">
                                    <div class="pull-right">
                                        <!--<a class="btn btn-cancel" href="#">Cancel</a>-->
                                    </div>
                                    <span class="append-right-10">
                                        <input id="btn-submit" type="button" name="commit" value="发送" class="btn btn-create js-key-enter"  >
                                    </span>
                                </div>
                                <input type="hidden" name="issue[lock_version]" id="issue_lock_version">

                            </form>
                        </div>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>


</div>

<script type="text/javascript">

    $(document).ready(function () {

        send_mail_fetch(  );
    });

    function send_mail_fetch(  ) {
        var params = { format:'json'  };
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/admin/system/send_mail_fetch',
            data: params ,
            success: function (resp) {

                auth_check(resp);
                var obj=document.getElementById('to_project');
                for(var i = 0; i < resp.data.projects.length; i++){
                    obj.options.add(new Option( resp.data.projects[i].name, resp.data.projects[i].id ));
                }
/*                var obj2=document.getElementById('to_role');
                for(var i = 0; i < resp.data.roles.length; i++){
                    obj2.options.add(new Option( resp.data.roles[i].name, resp.data.roles[i].id ));
                }*/
                var obj3=document.getElementById('to_group');
                for(var i = 0; i < resp.data.groups.length; i++){
                    obj3.options.add(new Option( resp.data.groups[i].name, resp.data.groups[i].id ));
                }
                $('.selectpicker').selectpicker('refresh');
                $('#to_group').selectpicker('refresh');

            },
            error: function (res) {
                notify_error("请求数据错误" + res);
            }
        });
    }

    $("#btn-submit").click(function(){
        var method = 'post';
        var url = '/admin/system/send_mail_post';
        var params = {}
        $.ajax({
            type: method,
            dataType: "json",
            async: true,
            url: url,
            data: $('#send_mail_form').serialize() ,
            success: function (resp) {
                auth_check(resp);
                notify_success( "提交数据成功,后台服务发送中" );
            },
            error: function (resp) {
                notify_error("请求数据错误" + resp);
            }
        });
    });


</script>



</body>
</html>


</div>