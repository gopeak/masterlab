<script>

    var root_url = "/";
    var current_uid = "<?=@$_SESSION[main\app\classes\UserAuth::SESSION_UID_KEY]?>";
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

</script>