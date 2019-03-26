<!DOCTYPE html>
<html class="" lang="en">
<head  >

    <? require_once VIEW_PATH.'gitlab/common/header/include.php';?>
    <script src="<?=ROOT_URL?>dev/js/admin/user.js?v=<?=$_version?>" type="text/javascript" charset="utf-8"></script>
    <script src="<?=ROOT_URL?>dev/lib/handlebars-v4.0.10.js" type="text/javascript" charset="utf-8"></script>


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
        <div class=" ">
            <div class="content" id="content-body">
                <?php include VIEW_PATH.'gitlab/admin/common_user_left_nav.php';?>
                <div class="container-fluid"  style="margin-left: 160px">

                    <form  action="<?=ROOT_URL?>admin/user/update_user_project_role" accept-charset="UTF-8" method="post">
                        <input type="hidden" name="uid" value="<?=$uid?>" id="uid">
                        <div class="top-area">
                            <ul class="nav-links user-state-filters" style="float:left">
                                <li class="active" data-value="">
                                    <a id="state-opened"  title="用户拥有的项目角色" href="#" ><span> 用户拥有的项目角色 </span>
                                    </a>
                                </li>

                            </ul>
                            <div class="nav-controls row-fixed-content" style="float: left;margin-left: 80px">

                            </div>
                            <div class="nav-controls" style="right: ">
                                <a class="btn has-tooltip" title="" href="<?=ROOT_URL?>admin/user" data-original-title="邀请用户">
                                    <i class="fa fa-reply-all"></i>&nbsp;返回用户列表
                                </a>
                                <div class="project-item-select-holder">

                                    <a class="btn btn-save  "  href="#">
                                        <i class="fa fa-save"></i>
                                        &nbsp;保存
                                    </a>
                                </div>

                            </div>

                        </div>
                    <div class="content-list pipelines">

                        <div class="table-holder">
                                <table class="table ci-table">
                                    <thead>
                                        <tr id="thead_id">

                                        </tr>
                                    </thead>
                                    <tbody id="render_id">


                                    </tbody>
                                </table>
                            </div>
                    </div>

                    <a  name="submit"  class="btn btn-save " id="submit-all" style="float: left;" data-dismiss="modal"  href="#">
                        <i class="fa fa-save"></i>
                        &nbsp;保存
                    </a>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
</section>



<script type="text/html"  id="thead_tpl">

    <td class="commit-id monospace">Project</td>
    {{#roles}}
    <td  >

            <input class="project_role_head" type="checkbox" id="role_all_{{id}}"  data-role_id="{{id}}">{{name}}

    </td>
    {{/roles}}

</script>

<script type="text/html"  id="list_tpl">
    {{#projects}}
        <tr class="commit">
            {{make_tbody this}}
        </tr>
    {{/projects}}

</script>


<script type="text/javascript">

    $(function() {

        Handlebars.registerHelper('make_tbody', function(item ) {

            var html = '';
            var p_id = item.id;
            for(var key in item ){

                if( key=='id'){
                    continue;
                }
                if( key=='name'){
                    html += "<td class=\"commit-id monospace\">"+item[key]+"</td>";
                }else{
                    var checked = '';
                    if( item[key] ){
                        checked = 'checked="checked"';
                    }
                    var arr = key.split('@');
                    var id = p_id+'_'+key
                    var checkbox = ' <input class="class_'+arr[1]+'" type="checkbox" '+checked+' value="'+arr[1]+'" name="params['+key+']" id="'+key+'">';
                    html += "<td  >"+checkbox+"</td>";
                }
            }
            return new Handlebars.SafeString( html );

        });

        fetchUserProjectRole(  );



    });
    function fetchUserProjectRole(  ) {

        var params = {format: 'json', uid: '<?=$uid?>'};
        $.ajax({
            type: "GET",
            dataType: "json",
            async: true,
            url: '/admin/user/user_project_role_fetch',
            data: params,
            success: function (resp) {
                auth_check(resp);
                var source = $('#thead_tpl').html();
                var template = Handlebars.compile(source);
                var thead = template(resp.data);
                $('#thead_id').html(thead);

                var source = $('#list_tpl').html();
                var template2 = Handlebars.compile(source);
                var tbody = template2(resp.data);
                $('#render_id').html(tbody);

                $(".project_role_head").click(function () {

                    var role_id =  $(this).attr("data-role_id");
                    if($(this).is(":checked")){
                        $("input:checkbox[class='class_"+role_id+"']").each(function(){
                            $(this).prop("checked", true);
                        });
                    }else{
                        $("input:checkbox[class='class_"+role_id+"']").each(function(){
                            $(this).removeAttr("checked");
                        });
                    }
                });
            },
            error: function (res) {
                alert("请求数据错误" + res);
            }
        });
    }

</script>
</body>
</html>