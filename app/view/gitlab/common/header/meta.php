<?php

$siteName = (new \main\app\classes\SettingsLogic())->showSysTitle();
if( isset( $title) && !empty($title) ) {
    $title = $title.' · '.$siteName;
}else{
    $title = $siteName;
}
?>
<title><?=$title.'--打造国内极致的项目管理工具!'?></title>

<meta charset="utf-8">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta content="object" property="og:type">
<meta content="MasterLab" property="og:site_name">
<meta content="Sign in" property="og:title">
<meta content="GitLab Community Edition" property="og:description">
<meta content="<?=ROOT_URL?>passport/login" property="og:url">
<meta content="summary" property="twitter:card">
<meta content="Sign in" property="twitter:title">
<meta content="GitLab Community Edition" property="twitter:description">
<meta content="<?=ROOT_URL?>gitlab/assets/gitlab_logo.png" property="og:image">
<meta content="<?=ROOT_URL?>gitlab/assets/gitlab_logo.png" property="twitter:image">

<meta content="GitLab Community Edition" name="description">

<meta name="csrf-param" content="authenticity_token" />
<meta name="csrf-token" content="alAZE77Wv+jsZsepqr5ffMh6XJjLYUkeLjs0bvLB64/6J1vbN6l9FujLjDfRLABcXz9HXgsOk4Ob9gBXooWBaA==" />
<meta content="origin-when-cross-origin" name="referrer">
<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
<meta content="#474D57" name="theme-color">

