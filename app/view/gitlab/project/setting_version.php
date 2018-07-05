<!DOCTYPE html>
<html class="" lang="en">
<head>
    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/jquery.form.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/project/version.js" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/laydate/laydate.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js"  type="text/javascript"></script>
</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>
<header class="navbar navbar-gitlab with-horizontal-nav">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>
    </div>
</header>
<script>
    var findFileURL = "/ismond/xphp/find_file/master";
</script>
<div class="page-with-sidebar">
    <? require_once VIEW_PATH.'gitlab/project/common-page-nav-project.php';?>

    <? require_once VIEW_PATH.'gitlab/project/common-setting-nav-links-sub-nav.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid ">

            <div class="content" id="content-body">

                <div class="row prepend-top-default">
                    <div class="col-lg-3 settings-sidebar">
                        <h4 class="prepend-top-0">
                            版本与发布
                        </h4>
                        <p>
                        </p>
                    </div>
                    <div class="col-lg-9">

                        <form id="form_add_action" class="" action="<?=ROOT_URL?>project/version/add?project_id=<?=$project_id?>" accept-charset="UTF-8" method="post">
                            <input name="utf8" type="hidden" value="✓">
                            <input type="hidden" name="authenticity_token" value="">
                            <div class="form-group  col-md-2">
                                <input style="margin-left: -15px;" type="text" name="name" id="version_name" placeholder="版本" required="required" tabindex="1" autofocus="autofocus" class="form-control">

                            </div>
                            <div class="form-group col-md-2">
                                <div class="clearable-input">
                                    <input type="text" name="start_date" id="start_date" class="form-control js-access-expiration-date-groups" tabindex="2" placeholder="开始日期">
                                    <i class="clear-icon js-clear-input"></i>
                                </div>


                            </div>
                            <div class="form-group col-md-2">
                                <div class="clearable-input">
                                    <input type="text" name="release_date" id="release_date" class="form-control js-access-expiration-date-groups" tabindex="3" placeholder="发布日期">
                                    <i class="clear-icon js-clear-input"></i>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" name="description" id="description" placeholder="描述" required="required" tabindex="4" autofocus="autofocus" class="form-control">

                            </div>
                            <div class="form-group col-md-2">
                                <input type="submit"  value="添加版本" class="btn btn-create" >
                            </div>

                        </form>

                    </div>


                </div>

                <div class="row prepend-top-default">
                    <div class="col-lg-3 settings-sidebar">
                        <h4 class="prepend-top-0">
                            List
                        </h4>
                        <p>
                            版本控制和规则要求,建议
                            <strong>1.0.0 1.0.1</strong>
                        </p>
                    </div>
                    <div class="col-lg-9">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                历史
                                <strong>版本</strong>

                                <div class="input-group member-search-form">
                                    <input type="search" name="search" id="search_input" placeholder="搜索版本" class="form-control" value="">
                                </div>

                            </div>
                            <ul class="flex-list content-list" id="list_render_id">


                            </ul>
                        </div>
                        <div class="gl-pagination" id="ampagination-bootstrap">

                        </div>

                    </div>
                </div>


            </div>

        </div>
    </div>
</div>




<script type="text/html"  id="list_tpl">
    {{#versions}}
    <li class="flex-row">
        <div class="row-main-content str-truncated">
            <a href="/ismond/xphp/tags/v1.2">
                <span class="item-title">
                    <i class="fa fa-tag"></i>{{name}}
                </span>
            </a>
            <div class="block-truncated">
                <div class="branch-commit">
                    <div class="icon-container commit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 18" enable-background="new 0 0 36 18">
                            <path d="m34 7h-7.2c-.9-4-4.5-7-8.8-7s-7.9 3-8.8 7h-7.2c-1.1 0-2 .9-2 2 0 1.1.9 2 2 2h7.2c.9 4 4.5 7 8.8 7s7.9-3 8.8-7h7.2c1.1 0 2-.9 2-2 0-1.1-.9-2-2-2m-16 7c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5"></path>
                        </svg>

                    </div>
                    <a class="commit-id monospace" href="javascript:void(0);">{{#if_eq released 1}}  已发布   {{else}}  未发布   {{/if_eq}}</a>
                    ·
                    <span class="str-truncated">
                    Start at
                    </span>
                    ·
                    <time class="js-timeago js-timeago-render" title="" datetime="{{start_date}}" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="{{start_date}}"></time>

                </div>

            </div>
        </div>
        <div class="row-fixed-content controls">
            <div class="project-action-button dropdown inline">
                <button class="btn" data-toggle="dropdown">
                    <i class="fa fa-download"></i>
                    <i class="fa fa-caret-down"></i>
                    <span class="sr-only">
                        Select Archive Format
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-align-right" role="menu">
                    <li class="dropdown-header">操作</li>
                        {{#if_eq released 0}}
                        <li>
                            <a rel="nofollow" onclick="requestRelease({{id}})" href="javascript:void(0);"><i class="fa fa-download"></i>
                                <span>发布</span>
                            </a>
                        </li>
                        {{else}}
                        {{/if_eq}}
                    <li>
                        <a rel="nofollow" onclick="requestRemove({{id}})" href="javascript:void(0);"><i class="fa fa-trash-o"></i>
                            <span>删除</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!--a class="btn has-tooltip" title="Edit release notes" data-container="body" href="/ismond/xphp/tags/v1.2/release/edit"><i class="fa fa-pencil"></i>
            </a>
            <a class="btn btn-remove remove-row has-tooltip " title="Delete tag" data-confirm="Deleting the 'v1.2' tag cannot be undone. Are you sure?" data-container="body" data-remote="true" rel="nofollow" data-method="delete" href="/ismond/xphp/tags/v1.2"><i class="fa fa-trash-o"></i>
            </a-->
        </div>
    </li>
    {{/versions}}
</script>




<script>
    let query_str = '<?=$query_str?>';
    let urls = parseURL(window.location.href);


    $(function() {

        lay('.js-access-expiration-date-groups').each(function(){
            laydate.render({
                elem: this
                ,trigger: 'click'
            });
        });


        let options = {
            query_str: window.query_str,
            query_param_obj: urls.searchObject,
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_url:"<?=ROOT_URL?>project/version/filter_search?project_id=<?=$project_id?>"
        };
        window.$versions = new Version( options );
        window.$versions.fetchAll();

        let add_options = {
            beforeSubmit: function (arr, $form, options) {
                return true;
            },
            success: function (data, textStatus, jqXHR, $form) {
                if(data.ret == 200){
                    alert('保存成功');
                    window.$versions.fetchAll();
                }else{
                    alert('保存失败'+data.msg);
                }
            },
            type:      "post",
            dataType:  "json",
            clearForm: true,
            resetForm: false,
            timeout:   3000
        };

        $('#form_add_action').submit(function() {
            $(this).ajaxSubmit(add_options);
            return false;
        });


        $('#mod_save').click(function () {
            let module_id = $('#mod_form_id').val();
            let name = $('#mod_form_name').val();
            let description = $('#mod_form_description').val();
            if(parseInt(module_id, 10)){
                window.$versions.doedit(module_id, name, description);
            }
        });

        $('#search_input').bind('keyup', function(event) {
            // 回车
            if (event.keyCode == "13") {
                window.$versions.fetchAll(this.value);
            }
        });

    });


    function requestRelease(versionId) {
        $.post("<?=ROOT_URL?>project/version/release?project_id=<?=$project_id?>",{version_id:versionId},function(result){
            if(result.ret == 200){
                location.reload();
            } else {
                alert('failed');
                console.log(result);
            }

        });
    }
    function requestRemove(versionId) {
        $.post("<?=ROOT_URL?>project/version/remove?project_id=<?=$project_id?>",{version_id:versionId},function(result){
            if(result.ret == 200){
                location.reload();
            } else {
                alert('failed');
                console.log(result);
            }
        });
    }
</script>
</body>
</html>
