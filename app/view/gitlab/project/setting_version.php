<!DOCTYPE html>
<html class="" lang="en">
<head>
    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/lib/jquery.form.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/project/version.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <link href="<?=ROOT_URL?>dev/lib/laydate/theme/default/laydate.css" rel="stylesheet">
    <script src="<?=ROOT_URL?>dev/lib/laydate/laydate.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/bootstrap-paginator/src/bootstrap-paginator.js?v=<?= $_version ?>"  type="text/javascript"></script>

    <script src="<?= ROOT_URL ?>dev/lib/sweetalert2/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="<?= ROOT_URL ?>dev/lib/sweetalert2/sweetalert-dev.css"/>

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body">
<? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>

<script>
    var findFileURL = "";
</script>
<div class="page-with-sidebar">
    <? require_once VIEW_PATH.'gitlab/project/common-page-nav-project.php';?>

    <? require_once VIEW_PATH.'gitlab/project/common-setting-nav-links-sub-nav.php';?>

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class="container-fluid container-limited">

            <div class="content" id="content-body">

                <div class="row prepend-top-default">
                    <div class="col-lg-3 settings-sidebar">
                        <h4 class="prepend-top-0">
                            版本与发布
                        </h4>
                        <p>
                            使用版本号来管理项目的发布
                        </p>
                        <p>
                            版本控制和规则要求,建议<br>
                            <strong>主版本号.子版本号[.修正版本号[.编译版本号]]</strong>
                        </p>
                    </div>
                    <div class="col-lg-9">
                        <form id="form_add_action" class="setting-form clearfix" action="<?=ROOT_URL?>project/version/add?project_id=<?=$project_id?>" accept-charset="UTF-8" method="post">
                            <input name="utf8" type="hidden" value="✓">
                            <input type="hidden" name="authenticity_token" value="">
                            <div class="form-group  col-md-2">
                                <input style="margin-left: -15px;" type="text" name="name" id="version_name" placeholder="版本" required="required" tabindex="1"  class="form-control">

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
                                <input type="text" name="description" id="description" placeholder="描述" class="form-control">

                            </div>
                            <div class="form-group col-md-2">
                                <input type="submit"  value="添加版本" class="btn btn-create" >
                            </div>

                        </form>


                        <div class="panel panel-form panel-default margin-t-lg">
                            <div class="panel-heading">
                                <strong>版本</strong>
                                <div class="input-group member-search-form">
                                    <input type="search" name="search" id="search_input" placeholder="搜索版本" class="form-control" value="">
                                </div>

                            </div>
                            <ul class="flex-list content-list" id="list_render_id">


                            </ul>
                        </div>
                        <div class="gl-pagination border-0" id="ampagination-bootstrap">

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>


<div class="modal" id="modal-edit-version-href">
    <form class="form-horizontal"
          id="form_edit_action"
          action="<?=ROOT_URL?>project/version/update"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-header-title">编辑版本 </h3>
                </div>
                <div class="modal-body">
                    <input name="utf8" type="hidden" value="✓">
                    <input type="hidden" name="authenticity_token" value="">
                    <input type="hidden" name="id" id="ver_form_id" value="" />

                    <div class="form-group">
                        <label class="control-label" for="issue_type">版本</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ver_form_name" name="name" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="issue_type">开始日期</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control js-access-expiration-date-groups" id="ver_form_start_date" name="start_date" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="issue_type">发布日期</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control js-access-expiration-date-groups" id="ver_form_release_date" name="release_date" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="issue_type">描述</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="ver_form_description" name="description"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-save" id="ver_save">保存</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </form>
</div>

    </div>
</section>
<script type="text/html"  id="list_tpl">
    {{#versions}}
    <li class="flex-row" id="li_data_id_{{id}}">
        <div class="row-main-content str-truncated">
            <span class="item-title">
                <i class="fa fa-tag"></i> {{name}}
            </span>
            <div class="block-truncated">
                <div class="branch-commit">
                    <div class="icon-container commit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 18" enable-background="new 0 0 36 18">
                            <path d="m34 7h-7.2c-.9-4-4.5-7-8.8-7s-7.9 3-8.8 7h-7.2c-1.1 0-2 .9-2 2 0 1.1.9 2 2 2h7.2c.9 4 4.5 7 8.8 7s7.9-3 8.8-7h7.2c1.1 0 2-.9 2-2 0-1.1-.9-2-2-2m-16 7c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5"></path>
                        </svg>

                    </div>
                    <small class="edited-text">
                        {{#if_eq released 1}}  已发布   {{else}}  未发布   {{/if_eq}}
                        ·
                        开始 {{start_date}} | 发布 {{release_date}}
                        .
                        {{#if description}}
                        <span>{{description}}</span>
                        {{else}}
                        <span>无描述</span>
                        {{/if}}

                    </small>



                </div>

            </div>
        </div>
        <div class="row-fixed-content controls">
            <div class="project-action-button dropdown inline">
                <button class="btn" data-toggle="dropdown">
                    操作
                    <i class="fa fa-caret-down"></i>
                    <span class="sr-only">
                        操作
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-align-right" role="menu">
                    {{#if_eq released 0}}
                    <li>
                        <a rel="nofollow" onclick="requestRelease({{id}})" href="javascript:void(0);">
                            <i class="fa fa-download"></i> <span>发布</span>
                        </a>
                    </li>
                    {{else}}
                    {{/if_eq}}

                    <li>
                        <a rel="nofollow" class="project_version_edit_click" title="编辑" data-container="body" href="#modal-edit-version-href" data-toggle="modal" data-version_id="{{id}}">
                        <!--a rel="nofollow" onclick="edit({{id}})" href="javascript:void(0);"-->
                            <i class="fa fa-pencil"></i> <span>编辑</span>
                        </a>
                    </li>
                    <li>
                        <a rel="nofollow" onclick="requestRemove({{id}})" href="javascript:void(0);">
                            <i class="fa fa-trash-o"></i> <span>删除</span>
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
                    notify_success('保存成功');
                    window.$versions.fetchAll();
                }else{
                    notify_error('保存失败: ' + data.msg);
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

        $('#search_input').bind('keyup', function(event) {
            // 回车
            if (event.keyCode == "13") {
                window.$versions.fetchAll(this.value);
            }
        });

        $('#ver_save').click(function () {
            let version_id = $('#ver_form_id').val();
            let name = $('#ver_form_name').val();
            let start_date = $('#ver_form_start_date').val();
            let release_date = $('#ver_form_release_date').val();
            let description = $('#ver_form_description').val();
            if(parseInt(version_id, 10)){
                window.$versions.doedit(version_id, name, description, start_date, release_date);
            }
        });

    });

    function requestRelease(versionId) {
        window.$versions.release(<?=$project_id?>, versionId);
    }

    function requestRemove(versionId) {
        swal({
                title: "确认要删除该版本？",
                text: "注:删除后，版本是无法恢复的！",
                html: true,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确 定",
                cancelButtonText: "取 消！",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    window.$versions.delete(<?=$project_id?>, versionId);
                    swal.close();
                }else{
                    swal.close();
                }
            }
        );
    }
</script>
</body>
</html>
