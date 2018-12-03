<!DOCTYPE html>
<html class="" lang="en">
<head  >
    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>

</head>
<body class="" data-group="" data-page="projects:issues:index" data-project="xphp">
<? require_once VIEW_PATH.'gitlab/common/body/script.php';?>

<section class="has-sidebar page-layout max-sidebar">
    <? require_once VIEW_PATH . 'gitlab/common/body/page-left.php'; ?>

    <div class="page-layout page-content-body background-white">

<header class="navbar navbar-gitlab">
    <a class="sr-only gl-accessibility" href="#content-body" tabindex="1">Skip to content</a>
    <div class="container-fluid">
        <? require_once VIEW_PATH.'gitlab/common/body/header-content.php';?>
    </div>
</header>

<div class="page-with-sidebar">

    <div class="content-wrapper page-with-layout-nav page-with-sub-nav">
        <div class="alert-wrapper">

            <div class="flash-container flash-container-page">
            </div>

        </div>
        <div class=" ">
            <div class="content padding-0" id="content-body">
                <div class="user-profile">
                    <div class="cover-block user-cover-block">
                        <div class="cover-controls">
                            <a class="btn btn-gray has-tooltip" title="Edit profile" aria-label="Edit profile" href="<?=ROOT_URL?>user/profile_edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <!--<a class="btn btn-gray has-tooltip" title="Subscribe" aria-label="Subscribe" href="/sven.atom?private_token=vyxEf937XeWRN9gDqyXk">
                                <i class="fa fa-rss"></i>
                            </a>-->
                        </div>
                        <?php
                        if(empty($other_user)){
                            $other_user = $user;
                        }
                        ?>
                        <div class="profile-header">
                            <div class="avatar-holder">
                                <a target="_blank" rel="noopener noreferrer" href="<?=$other_user['avatar']?>">
                                    <img class="avatar s90" alt="" src="<?=$other_user['avatar']?>" /></a>
                            </div>
                            <div class="user-info">
                                <div class="cover-title"><?=$other_user['display_name']?></div>
                                <div class="cover-desc member-date">
                                    <span class="middle-dot-divider"><?=$other_user['username']?></span>
                                    <span class="middle-dot-divider"><?=$other_user['create_time_text']?></span></div>
                                <div class="cover-desc"></div>
                            </div>
                        </div>
                        <div class="scrolling-tabs-container">
                            <div class="fade-left">
                                <i class="fa fa-angle-left"></i>
                            </div>
                            <div class="fade-right">
                                <i class="fa fa-angle-right"></i>
                            </div>
                            <?php
                            $profile_nav='have_join_projects';
                            include_once VIEW_PATH.'gitlab/user/common-profile-nav.php';
                            ?>
                        </div>
                    </div>
                    <div class="container-fluid container-limited">
                        <div class="tab-content">
                            <div class="tab-pane" id="activity">

                                <div class="loading hide">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </div>
                            </div>
                            <div class="tab-pane" id="groups"></div>
                            <div class="tab-pane active" id="projects">
                                <div class="js-projects-list-holder">
                                    <ul id="projects_list" class="projects-list">

                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane" id="snippets"></div>
                        </div>
                        <div class="loading-status">
                            <div class="loading hide">
                                <i class="fa fa-spinner fa-spin"></i>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

    </div>
</section>

<script id="projects_tpl" type="text/html" >
{{#projects}}
    <li class="project-row">
        <div class="avatar-container s40">

            {{#if avatar_exist}}
            <a href="#" class="avatar-image-container">
                <img src="{{avatar}}"  class="avatar has-tooltip s40">
            </a>
            {{^}}
            <div class="avatar-container s40" style="display: block">
                <a class="project" href="<?=ROOT_URL?>{{path}}/{{key}}">
                    <div class="avatar project-avatar s40 identicon"
                         style="background-color: #E0F2F1; color: #555">{{first_word}}</div>
                </a>
            </div>
            {{/if}}
        </div>
        <div class="project-details">
            <h3 class="prepend-top-0 append-bottom-0">
                <a class="text-plain" href="/{{path}}/{{key}}">
                    <span class="project-full-name">
                        <span class="project-name">{{name}}</span> /{{path}}/{{key}}
                    </span>
                </a>
            </h3>
            <div class="description prepend-top-5">
                <p dir="auto">{{description}}.</p></div>
        </div>
        <div class="controls">
            <div class="prepend-top-0">
                <span class="prepend-left-10"></span>
                </span>
            </div>
            <div class="prepend-top-0">updated
                <time class="js-timeago js-timeago-render-my" title=""
                      datetime="{{create_time_origin}}"
                      data-toggle="tooltip"
                      data-placement="top"
                      data-container="body"
                      data-original-title="{{create_time_origin}}" data-tid="51">{{create_time_text}}</time></div>
        </div>
    </li>
    {{/projects}}

</script>


<script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

    var $activity = null;
    var _user_id = '<?=$user_id?>';
    $(function() {
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/user/fetchUserHaveJoinProjects',
            data: {limit:200,user_id:_user_id},
            success: function (resp) {
                auth_check(resp);
                if(resp.data.projects.length){
                    var source = $('#projects_tpl').html();
                    var template = Handlebars.compile(source);
                    var result = template(resp.data);
                    $('#projects_list').html(result);
                }else{
                    var emptyHtml = defineStatusHtml({
                        wrap: '#projects_list',
                        message : '暂无数据',
                        handleHtml: ''
                    })
                }
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    });
</script>

</body>
</html>

