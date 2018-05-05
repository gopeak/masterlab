<script>

    var root_url = "<?= ROOT_URL;?>";
    var current_uid = "<?=@$_SESSION[main\app\classes\UserAuth::SESSION_UID_KEY]?>";
    window.gon={};
    gon.api_version="v4";
    gon.default_avatar_url="<?=ROOT_URL?>gitlab/assets/no_avatar.png";
    gon.max_file_size=10;
    gon.asset_host=null;
    gon.relative_url_root="";
    gon.shortcuts_path="<?=ROOT_URL?>help/shortcuts";
    gon.user_color_scheme="white";
    gon.katex_css_url="<?=ROOT_URL?>gitlab/assets/katex.css";
    gon.katex_js_url="<?=ROOT_URL?>gitlab/assets/katex.js";

</script>