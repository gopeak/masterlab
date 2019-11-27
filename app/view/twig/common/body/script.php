<script type="text/javascript">

    var root_url = "/";
    var current_uid = "{{G_uid}}";
    var cur_project_id = '{{project_id}}';
    var cur_path_key = '{{project_root_url}}';
    var cur_project_name = '{{project_name}}';
    var _is_admin = {{_is_admin}};

    // {% if array.key is defined %}
    var _permCreateIssue =  {{_permCreateIssue}};
    var _projectPermArr = {{_projectPermArrJson}}

    window.gon={};
    gon.api_version="v4";
    gon.default_avatar_url="/gitlab/assets/no_avatar.png";
    gon.max_file_size=10;
    gon.asset_host=null;
    gon.relative_url_root="";
    gon.shortcuts_path="/help/shortcuts";
    gon.user_color_scheme="white";
    gon.katex_css_url="/gitlab/assets/katex.css";
    gon.katex_js_url="/gitlab/assets/katex.js";
    gon.current_user_id={{G_uid}};
    gon.current_username="{{user.username}}";
    gon.current_user_fullname="{{user.display_name}}";

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>