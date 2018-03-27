<!DOCTYPE html>
<html class="" lang="en">
<head  >
    <!--link rel="stylesheet" href="<?=ROOT_URL?>dev/lib/js/laydate/theme/laydate.css"-->
    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>gitlab/assets/webpack/filtered_search.bundle.js"></script>
    <script src="<?=ROOT_URL?>dev/js/jquery.form.js"></script>
    <script src="<?=ROOT_URL?>dev/js/laydate/laydate.js"></script>

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
                            Releases 新增
                        </h4>
                        <p>
                        </p>
                    </div>
                    <div class="col-lg-9">

                        <form class="" action="/project/version/add?project_id=<?=$get_projectid?>&skey=<?=$get_skey?>" accept-charset="UTF-8" method="post">
                            <input name="utf8" type="hidden" value="✓"><input type="hidden" name="authenticity_token" value="alAZE77Wv+jsZsepqr5ffMh6XJjLYUkeLjs0bvLB64/6J1vbN6l9FujLjDfRLABcXz9HXgsOk4Ob9gBXooWBaA==">
                            <div class="form-group  col-md-2">
                                <input style="margin-left: -15px;" type="text" name="name" id="version_name" placeholder="Version name" required="required" tabindex="1" autofocus="autofocus" class="form-control">

                            </div>
                            <div class="form-group col-md-2">
                                <div class="clearable-input">
                                    <input type="text" name="start_date" id="start_date" class="form-control js-access-expiration-date-groups" tabindex="2" placeholder="Start date (optional)">
                                    <i class="clear-icon js-clear-input"></i>
                                </div>
                            </div>
                            <div class="form-group col-md-2">
                                <div class="clearable-input">
                                    <input type="text" name="release_date" id="release_date" class="form-control js-access-expiration-date-groups" tabindex="3" placeholder="Release date (optional)">
                                    <i class="clear-icon js-clear-input"></i>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" name="description" id="description" placeholder="Description (optional)" required="required" tabindex="4" autofocus="autofocus" class="form-control">

                            </div>
                            <div class="form-group col-md-2">
                                <input type="submit"  value="Add" class="btn btn-create" >
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
                                Members with access to
                                <strong>xphp</strong>
                                <span class="badge">16</span>
                                <form class="form-inline member-search-form" action="/ismond/xphp/settings/members" accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓">
                                    <div class="form-group">
                                        <input type="search" name="search" id="search" placeholder="Find existing members by name" class="form-control" spellcheck="false" value="">
                                        <button aria-label="Submit search" class="member-search-btn" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <div class="dropdown inline member-sort-dropdown">
                                            <button class="dropdown-menu-toggle " type="button" data-toggle="dropdown"><span class="dropdown-toggle-text ">Name, ascending</span><i class="fa fa-chevron-down"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-align-right dropdown-menu-selectable">
                                                <li class="dropdown-header">
                                                    Sort by
                                                </li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=access_level_asc">Access level, ascending
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=access_level_desc">Access level, descending
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=last_joined">Last joined
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=oldest_joined">Oldest joined
                                                    </a></li>
                                                <li>
                                                    <a class="is-active" href="/ismond/xphp/settings/members?sort=name_asc">Name, ascending
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=name_desc">Name, descending
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=recent_sign_in">Recent sign in
                                                    </a></li>
                                                <li>
                                                    <a href="/ismond/xphp/settings/members?sort=oldest_sign_in">Oldest sign in
                                                    </a></li>
                                            </ul>
                                        </div>

                                    </div>
                                </form></div>
                            <ul class="flex-list content-list">
                                <?php foreach ($list as $item) { ?>
                                <li class="flex-row">
                                    <div class="row-main-content str-truncated">
                                        <a href="/ismond/xphp/tags/v1.2">
                                        <span class="item-title">
                                            <i class="fa fa-tag"></i><?= $item['name'] ?></span></a>
                                        <div class="block-truncated">
                                            <div class="branch-commit">
                                                <div class="icon-container commit-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 18" enable-background="new 0 0 36 18"><path d="m34 7h-7.2c-.9-4-4.5-7-8.8-7s-7.9 3-8.8 7h-7.2c-1.1 0-2 .9-2 2 0 1.1.9 2 2 2h7.2c.9 4 4.5 7 8.8 7s7.9-3 8.8-7h7.2c1.1 0 2-.9 2-2 0-1.1-.9-2-2-2m-16 7c-2.8 0-5-2.2-5-5s2.2-5 5-5 5 2.2 5 5-2.2 5-5 5"></path></svg>

                                                </div>
                                                <a class="commit-id monospace" href="javascript:void(0);"><?= $item['released']?"已发布":"未发布" ?></a>
                                                ·
                                                <span class="str-truncated">
<a class="commit-row-message" href="/ismond/xphp/commit/2f1269457c20e93e6a02b515384753e3ec862d24">Start at</a>
</span>
                                                ·
                                                <time class="js-timeago js-timeago-render" title="" datetime="2017-07-29T07:49:42Z" data-toggle="tooltip" data-placement="top" data-container="body" data-original-title="Jul 29, 2017 3:49pm GMT+0800"><?= date("Y-m-d", $item['start_date']) ?></time>
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
                                                <?php if( !$item['released']) { ?>
                                                <li>
                                                    <a rel="nofollow" onclick="requestRelease(<?= $item['id'] ?>)" href="javascript:void(0);"><i class="fa fa-download"></i>
                                                        <span>发布</span>
                                                    </a>
                                                </li>
                                                <?php } ?>
                                                <li>
                                                    <a rel="nofollow" onclick="requestRemove(<?= $item['id'] ?>)" href="javascript:void(0);"><i class="fa fa-trash-o"></i>
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
                                <?php } ?>

                            </ul>
                        </div>


                    </div>
                </div>


            </div>

        </div>
    </div>
</div>


<script>
    var options = {
        beforeSubmit: function (arr, $form, options) {

        },
        success: function (data, textStatus, jqXHR, $form) {
            if(data.ret == 200){
                alert('保存成功');
                location.reload();
            }else{
                alert('保存失败');
            }
            console.log(data);
        },
        type:      "post",
        dataType:  "json",
        clearForm: true,
        resetForm: true,
        timeout:   3000
    };

    $('form').submit(function() {
        $(this).ajaxSubmit(options);
        return false;
    });

    lay('.js-access-expiration-date-groups').each(function(){
        laydate.render({
            elem: this
            ,trigger: 'click'
        });
    });

    function requestRelease(versionId) {
        $.post("/project/version/release?project_id=<?=$get_projectid?>&skey=<?=$get_skey?>",{version_id:versionId},function(result){
            if(result.ret == 200){
                location.reload();
            } else {
                alert('failed');
                console.log(result);
            }

        });
    }
    function requestRemove(versionId) {
        $.post("/project/version/remove?project_id=<?=$get_projectid?>&skey=<?=$get_skey?>",{version_id:versionId},function(result){
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
