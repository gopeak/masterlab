<script type="text/javascript">

    var root_url = "<?=ROOT_URL?>";
    var current_uid = "<?=@$_SESSION[main\app\classes\UserAuth::SESSION_UID_KEY]?>";
    window.gon={};
    gon.api_version="v4";
    gon.default_avatar_url="<?=ROOT_URL?>gitlab/assets/no_avatar.png";
    gon.max_file_size=10;
    gon.asset_host=null;
    gon.relative_url_root="";
    gon.shortcuts_path="/help/shortcuts";
    gon.user_color_scheme="white";
    gon.katex_css_url="<?=ROOT_URL?>gitlab/assets/katex.css";
    gon.katex_js_url="<?=ROOT_URL?>gitlab/assets/katex.js";
    gon.current_user_id=<?echo isset($user['uid']) ? $user['uid']: '0' ?>;
    gon.current_username="<?echo isset($user['username']) ? $user['username']: '' ?>";
    gon.current_user_fullname="<?echo isset($user['display_name']) ? $user['display_name']: '' ?>";

</script>