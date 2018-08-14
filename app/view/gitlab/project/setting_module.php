<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <!--script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script-->
    <script src="<?=ROOT_URL?>dev/lib/jquery.form.js"></script>
    <script src="<?=ROOT_URL?>dev/lib/url_param.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/handlebars.helper.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/js/project/module.js" type="text/javascript" charset="utf-8"></script>
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
        <div class="container-fluid container-limited">
            <div class="content" id="content-body">


                <div class="row prepend-top-default">
                    <div class="col-lg-3 settings-sidebar">
                        <h4 class="prepend-top-0">
                            模块
                        </h4>
                        <p>
                            模块说明
                            <strong>1.0.0 1.0.1</strong>
                        </p>
                    </div>
                    <div class="col-lg-9">

                        <div class="top-area adjust">
                            <div class="nav-text row-main-content" style="width: 80%;">
                                <form id="form_add_action" action="<?=ROOT_URL?>project/module/add?project_id=<?=$project_id?>" accept-charset="UTF-8" method="post">

                                    <div class="form-group  col-md-2">
                                        <input style="margin-left: -15px;" type="text" name="module_name"  placeholder="模块" required="required"
                                               tabindex="1" autofocus="autofocus" class="form-control">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <select class="form-control" name="lead">
                                            <option value="">主管</option>
                                            <?php foreach ($users as $user) { ?>
                                            <option value="<?= $user['uid'] ?>"><?=$user['display_name']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <select class="form-control" name="default_assignee">
                                            <option value="0">经办人</option>
                                            <?php foreach ($users as $user) { ?>
                                                <option value="<?=$user['uid']?>"><?=$user['display_name']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <input type="text" name="description" id="description"  placeholder="说明" required="required"
                                               tabindex="4" autofocus="autofocus" class="form-control">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <input type="submit" name="commit" value="添加模块" class="btn btn-create">
                                    </div>
                                    <input name="utf8" type="hidden" value="✓">
                                    <input type="hidden" name="authenticity_token" value="">
                                </form>
                            </div>

                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <strong>模块</strong>
                                <div class="input-group member-search-form">
                                    <input type="search" name="search" id="search_input" placeholder="搜索模块" class="form-control" value="">
                                </div>
                            </div>
                            <ul class="flex-list content-list" id="list_render_id">

                            </ul>
                        </div>
                        <input name="page" id="filter_page" type="hidden" value="1">
                        <div class="gl-pagination" id="ampagination-bootstrap">

                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<div class="modal" id="modal-edit-module-href">
    <form class="form-horizontal"
          id="form_edit_action"
          action="<?=ROOT_URL?>project/module/update"
          accept-charset="UTF-8"
          method="post">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="modal-edit-issue_title" class="modal-header-title">编辑模块 </h3>
                </div>

                <div class="modal-body">
                    <input name="utf8" type="hidden" value="✓">
                    <input type="hidden" name="authenticity_token" value="">
                    <input type="hidden" name="id" id="mod_form_id" value="" />

                    <div class="form-group">
                        <label class="control-label" for="issue_type">模块</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="mod_form_name" name="name" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="issue_type">描述</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="mod_form_description" name="description"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-save" id="mod_save">保存</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/html" id="list_tpl">
    {{#modules}}
    <li class="flex-row" id="li_data_id_{{id}}">
        <div class="row-main-content str-truncated">
            <a href="/ismond/xphp/tags/v1.2">
                <span class="item-title">
                    <i class="fa fa-tag"></i>{{name}}
                </span>
            </a>
            <div class="block-truncated">
                <div class="branch-commit">
                    <div class="icon-container commit-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 18" enable-background="new 0 0 36 18"><path d="m34 7h-7.2c-.9-4-4.5-7-8.8-7s-7.9 3-8.8 7h-7.2c-1.1 0-2 .9-2 2 0 1.1.9 2 2 2h7.2c.9 4 4.5 7 8.8 7s7.9-3 8.8-7h7.2c1.1 0 2-.9 2-2 0-1.1-.9-2-2-2m-16 7c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5"></path></svg>

                    </div>
                    <a class="commit-id monospace" href="">{{description}}</a>
                    ·
                    <span class="str-truncated">
                        <a class="commit-row-message" href="">{{display_name}}</a>
                    </span>
                    ·
                    <time class="js-timeago js-timeago-render" title="" datetime="{{ctime}}" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="{{ctime}}"></time>
                </div>

            </div>
        </div>
        <div class="row-fixed-content controls">
            <a class="btn project_module_edit_click" title="编辑模块" data-container="body" href="#modal-edit-module-href" data-toggle="modal" data-module_id="{{id}}">
                <i class="fa fa-pencil"></i>
            </a>
            <a class="btn btn-remove remove-row has-tooltip " title="删除模块" id="mod_remove" onclick="remove({{id}})" data-confirm="确定删除模块 {{name}}?" data-container="body"  rel="nofollow" href="javascript:void(0)">
                <i class="fa fa-trash-o"></i>
            </a>
        </div>
    </li>
    {{/modules}}
</script>
<script>

    let query_str = '<?=$query_str?>';
    let urls = parseURL(window.location.href);


    $(function() {

        let options = {
            query_str: window.query_str,
            query_param_obj: urls.searchObject,
            list_render_id:"list_render_id",
            list_tpl_id:"list_tpl",
            filter_url:"<?=ROOT_URL?>project/module/filter_search?project_id=<?=$project_id?>"
        };
        window.$modules = new Module( options );
        window.$modules.fetchAll();

        let add_options = {
            beforeSubmit: function (arr, $form, options) {
                let moduleName;
                for(j = 0,len=arr.length; j < len; j++) {
                    if(arr[j].name == 'module_name'){
                        moduleName = arr[j].value;
                    }
                }
                return true;
            },
            success: function (data, textStatus, jqXHR, $form) {
                if(data.ret == 200){
                    alert('保存成功');
                    //location.reload();

                    window.$modules.fetchAll();
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
                window.$modules.doedit(module_id, name, description);
            }
        });

        $('#search_input').bind('keyup', function(event) {
            // 回车
            if (event.keyCode == "13") {
                window.$modules.fetchAll(this.value);
            }
        });

    });

    function remove(module_id) {
        window.$modules.delete(<?=$project_id?>, module_id);
    }

</script>





</body>
</html>
