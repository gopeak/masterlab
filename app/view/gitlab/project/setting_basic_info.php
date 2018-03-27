<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script>
    <script src="<?=ROOT_URL?>dev/js/jquery.form.js"></script>
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
                            基本信息
                        </h4>
                        <p>
                        </p>
                    </div>
                    <div class="col-lg-9">
                        <form class="new_project" id="new_project" action="/project/setting/index?project_id=<?=$get_projectid?>&skey=<?=$get_skey?>" accept-charset="UTF-8" method="post">
                            <input name="utf8" type="hidden" value="✓">
                            <input type="hidden" name="authenticity_token" value="">

                            <div class="form-group ">
                                <label class="label-light" for="project_namespace_id">
                                    <span>项目名称</span>
                                </label>
                                <input value="<?= $info['name']?>" placeholder="请输入名称,最多64字符" class="form-control" tabindex="1" autofocus="autofocus"
                                       required="required" type="text" name="params[name]" id="project_name" disabled>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-6">
                                    <label class="label-light" for="project_namespace_id">
                                        <span>Project path</span>
                                    </label>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                http://192.168.3.213/
                                            </div>
                                            <div class="select2-container select2 js-select-namespace" id="s2id_project_namespace_id" style="width: 85px;">
                                                <a href="javascript:void(0)" class="select2-choice" tabindex="-1">
                                                    <span class="select2-chosen" id="select2-chosen-1">sven</span>
                                                    <abbr class="select2-search-choice-close"></abbr>
                                                    <span class="select2-arrow" role="presentation">
                                                                    <b role="presentation"></b>
                                                                </span>
                                                </a>
                                                <label for="s2id_autogen1" class="select2-offscreen">
                                                    Project path
                                                    项目名称
                                                </label>
                                                <input class="select2-focusser select2-offscreen" type="text" aria-haspopup="true"
                                                       role="button" aria-labelledby="select2-chosen-1" id="s2id_autogen1" tabindex="1">
                                            </div>
                                            <select class="select2 js-select-namespace" tabindex="-1" name="project[namespace_id]" id="project_namespace_id"
                                                    title="Project path Project name" style="display: none;">
                                                <optgroup label="Groups"><option data-options-parent="groups" value="9">ismond</option></optgroup>
                                                <optgroup label="Users"><option data-options-parent="users" selected="selected" value="18">sven</option></optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-xs-12 col-sm-6 project-path">
                                    <label class="label-light" for="project_namespace_id">
                                        <span>项目Key</span>
                                    </label>
                                    <input value="<?= $info['key']?>" placeholder="必须英文字符,最大长度20" class="form-control" tabindex="3"
                                           required="required" type="text" name="params[key]" id="project_key" disabled>
                                </div>
                            </div>
                            <div class="project-import js-toggle-container">
                                <div class="form-group clearfix">
                                    <label class="label-light" for="project_visibility_level">
                                        项目类型
                                    </label>
                                    <div class="col-sm-12">

                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="params[type]" id="typeScrum" value="10" <?php if($info['type'] == 10){echo "checked";}?>>
                                                <i class="fa fa-github"></i> Scrum software development
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="params[type]" id="typeKanban" value="20" <?php if($info['type'] == 20){echo "checked";}?>>
                                                <i class="fa fa-bitbucket"></i> Kanban software development
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="params[type]" id="typeBasicDev" value="30" <?php if($info['type'] == 30){echo "checked";}?>>
                                                <i class="fa fa-gitlab"></i> Basic software development
                                            </label>
                                        </div>

                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="params[type]" id="typeProjetManage" value="40" <?php if($info['type'] == 40){echo "checked";}?>>
                                                <i class="fa fa-google"></i> 项目管理
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="params[type]" id="typeFlowManage" value="50" <?php if($info['type'] == 50){echo "checked";}?>>
                                                <i class="fa fa-gitlab"></i> 流程管理
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="params[type]" id="typeTaskManage" value="60" <?php if($info['type'] == 60){echo "checked";}?>>
                                                <i class="fa fa-bug"></i> 任务管理
                                            </label>
                                        </div>
                                        <div class="radio disabled">
                                            <label>
                                                <input type="radio" name="params[type]" id="typeOther" value="0" disabled>
                                                <i class="fa fa-gitlab"></i> 其他
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="js-toggle-content hide">
                                    <div class="form-group import-url-data">
                                        <label class="control-label" for="project_import_url"><span>Git repository URL</span>
                                        </label><div class="col-sm-10">
                                            <input autocomplete="off" class="form-control" placeholder="https://username:password@gitlab.company.com/group/project.git" disabled="disabled" type="text" name="project[import_url]" id="project_import_url">
                                            <div class="well prepend-top-20">
                                                <ul>
                                                    <li>
                                                        The repository must be accessible over <code>http://</code>, <code>https://</code> or <code>git://</code>.
                                                    </li>
                                                    <li>
                                                        If your HTTP repository is not publicly accessible, add authentication information to the URL: <code>https://username:password@gitlab.company.com/group/project.git</code>.
                                                    </li>
                                                    <li>
                                                        The import will time out after 15 minutes. For repositories that take longer, use a clone/push combination.
                                                    </li>
                                                    <li>
                                                        To migrate an SVN repository, check out <a href="/help/workflow/importing/migrating_from_svn">this document</a>.
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label-light" for="project_description">项目描述
                                    <span class="light">(optional)</span>
                                </label>
                                <textarea placeholder="Description format" class="form-control" rows="3" maxlength="250" name="params[description]" id="project_description">
                                    <?= $info['description']?>
                                </textarea>
                            </div>
                            <div class="form-group ">
                                <label class="label-light" for="project_lead">
                                    <span>项目负责人</span>
                                </label>
                                <select class="form-control" name="params[lead]" id="projectLead">
                                    <option>请选择</option>
                                    <?php foreach ($users as $user){ ?>
                                        <option <?php if($info['lead']==$user['uid']){echo "selected";}?>
                                                value="<?= $user['uid']?>">
                                            <?= $user['display_name']?>
                                        </option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group ">
                                <label class="label-light" for="project_url">
                                    <span>URL</span>
                                </label>
                                <input value="<?= $info['url']?>" placeholder="URL" class="form-control"  type="text" name="params[url]" id="project_url">
                            </div>
                            <div class="form-group">
                                <label class="label-light" for="project_avatar">
                                    <span>Avatar</span>
                                </label>
                                <a class="choose-btn btn js-choose-project-avatar-button">
                                    Browse file...
                                </a>
                                <span class="file_name prepend-left-default js-avatar-filename">No file chosen</span>
                                <input class="js-project-avatar-input hidden" type="file" name="params[avatar]" id="project_avatar">
                                <div class="help-block">The maximum file size allowed is 200KB.</div>
                            </div>

                            <input type="submit" name="commit" value="保存" class="btn btn-create project-submit" tabindex="4">
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>

    var options = {
        //target:        '#output2',   // target element(s) to be updated with server response
        beforeSubmit:  function (arr, $form, options) {

        },
        success:       function (data, textStatus, jqXHR, $form) {
            if(data.ret == 200){
                alert("保存成功");
            }else{
                alert("保存失败");
            }
            console.log(data);
        },

        // other available options:
        //url:       url         // override for form's 'action' attribute
        type:      "post",        // 'get' or 'post', override for form's 'method' attribute
        dataType:  "json",        // 'xml', 'script', or 'json' (expected server response type)
        //clearForm: true        // clear all form fields after successful submit
        //resetForm: true        // reset the form after successful submit

        timeout:   3000
    };

    $('form').submit(function() {
        $(this).ajaxSubmit(options);
        return false;
    });

</script>
</body>

</html>