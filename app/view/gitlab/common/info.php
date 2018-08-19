<?php
$link = '';

if( $_links['type']=='back'){
    $link= 'javascript:history.go(-1);';
}else{
    $link= $_links['link'];
}

$siteName = (new \main\app\classes\SettingsLogic())->showSysTitle();
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
  <title><?=$siteName?></title>
  <style>
    body {
      color: #666;
      text-align: center;
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      margin: auto;
      font-size: 14px;
    }

    h1 {
      font-size: 36px;
      line-height: 100px;
      font-weight: normal;
      color: #456;
    }

    h2 {
      font-size: 24px;
      color: #666;
      line-height: 1.5em;
    }

    h3 {
      color: #456;
      font-size: 20px;
      font-weight: normal;
      line-height: 28px;
    }

    hr {
      max-width: 800px;
      margin: 18px auto;
      border: 0;
      border-top: 1px solid #EEE;
      border-bottom: 1px solid white;
    }

    img {
      max-width: 40vw;
      display: block;
      margin: 40px auto;
    }

    a {
      line-height: 100px;
      font-weight: normal;
      color: #4A8BEE;
      font-size: 18px;
      text-decoration: none;
    }

    .container {
      margin: auto 20px;
    }


  </style>

    <style>
        .empty {
            padding: 16px 0;
            position: relative;
        }
        .empty > .inner .img{
            background-repeat: no-repeat;
            background-position: center top;
        }
        .empty > .inner button {
            border: 0;
        }
        .empty > .inner .text {
            padding: 16px 0 0;
            text-align: center;
        }
        .empty[type=computer] > .inner .img {
            position: relative;
            background-image: url(../../gitlab/images/empty-computer.png);
            height: 200px;
        }
        .empty[type=computer] > .inner .info {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            color: rgba(0,0,0,0.55);
            text-align: center;
        }
        .empty[type=moon] > .inner .img {
            position: relative;
            background-image: url(../../gitlab/images/empty-moon.png);
            height: auto;
        }
        .empty[type=moon] > .inner .info {
            padding: 180px 0 0;
            color: rgba(0,0,0,0.55);
            text-align: center;
        }
        .empty[type=book] > .inner .img {
            position: relative;
            background-image: url(../../gitlab/images/empty-book.png);
            height: auto;
        }
        .empty[type=book] > .inner .info {
            padding: 240px 0 0;
            color: rgba(0,0,0,0.55);
            text-align: center;
        }
        .not-found{
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 16px 0
        }
        .not-found > .inner {
            display: flex;
        }
        .not-found > .inner .text {
            flex: 1;
        }
        .not-found > .inner .img{
            order: 2;
        }
        .not-found > .inner .text{
            order: 1;
        }
        .not-found > .inner .text > .type {
            font-size: 66px;
            font-weight: bolder;
            color: #bcc1cc;
            padding: 50px 0 0;
            font-family: Consolas Arial;
        }
        .not-found > .inner .text > .info {
            font-size: 24px;
            padding: 20px 0 0;
        }
        .not-found > .inner .text > .detail {
            font-size: 14px;
            padding: 0 0 20px;
            color: #bbb;
        }
        .logo{
            fill: currentColor;
            vertical-align: -0.15em;
            overflow: hidden;
            width: 1em;
            height: 1em;
        }
        .status{
            margin: 0 auto;
            display: flex;
        }
        .status .img{
            width: 180px;
            height: 180px;
            margin: 0 auto;
            background-repeat: no-repeat;
        }
        .status .inner{
            flex: 1;
        }
        .status .logo{
            width: 1em;
            height: 1em;
            border: 0;
        }
        .status svg use{
            stroke: rgba(0,0,0,0) !important;
        }
        .status.status-bag .img{
            background-image: url(../img/empty_bag.png)
        }
        .status.status-board .img{
            background-image: url(../img/empty_board.png)
        }
        .status.status-error .img{
            background-image: url(../img/empty_error.png)
        }
        .status.status-gps .img{
            background-image: url(../img/empty_gps.png)
        }
        .status.status-id .img{
            background-image: url(../img/empty_id.png)
        }
        .status.status-list .img{
            background-image: url(../img/empty_list.png)
        }
        .status.status-off-line .img{
            background-image: url(../img/empty_offline.png)
        }
        .status.status-search .img{
            background-image: url(../img/empty_search.png)
        }
        .status[data-direction="vertical"]{
            flex-direction: column;
            width: 300px;
        }
        .status[data-direction="vertical"] .message{
            text-align: center;
            padding: 0 0 16px;
        }
        .status[data-direction="vertical"] .handle{
            text-align: center;
        }
        .status[data-direction="horizontal"]{
            width: 500px;
            flex-direction: row;
            justify-content: space-between;
            align-items:center;
        }
        .status[data-direction="horizontal"] .img{
            order: 1;
        }
        .status[data-direction="horizontal"] .message{
            padding: 0 0 16px;
        }
    </style>

</head>

<body>
<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="126" height="86" style="display: none; position: absolute; left: -999em; top: -999em;">
    <symbol id="logo" viewBox="0 0 126 86">
        <ellipse cx="0" cy="50" rx="15" ry="40" style="transform: rotate(-45deg);"
                 fill="#ff8b04"
                 data-active-color="#fcc07a" />
        <ellipse cx="90" cy="-40" rx="15" ry="40" style="transform: rotate(45deg);"
                 fill="#ff8b04"
                 data-active-color="#fcc07a" />
        <ellipse cx="-14" cy="56" rx="15" ry="32" style="transform: rotate(-55deg);"
                 fill="#fd9e32"
                 data-active-color="#fcc07a" />
        <ellipse cx="88" cy="-48" rx="15" ry="32" style="transform: rotate(55deg);"
                 fill="#fd9e32"
                 data-active-color="#fcc07a" />
        <ellipse cx="-38" cy="50" rx="12" ry="26" style="transform: rotate(-75deg);"
                 fill="#ffb258"
                 data-active-color="#ff8b04"/>
        <ellipse cx="71" cy="-73" rx="12" ry="26" style="transform: rotate(75deg);"
                 fill="#ffb258"
                 data-active-color="#ff8b04" />
        <ellipse cx="-79" cy="-2" rx="12" ry="22" style="transform: rotate(-125deg);"
                 fill="#fcc07a"
                 data-active-color="#ff8b04" />
        <ellipse cx="6" cy="-107" rx="12" ry="22" style="transform: rotate(125deg);"
                 fill="#fcc07a"
                 data-active-color="#ff8b04" />
    </symbol>
</svg>

<div class="img">
      <svg class="logo" style="font-size: 21em; opacity: .6">
          <desc>MasterLab</desc>
          <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#logo"></use>
      </svg>
  </div>
  <h1>
      <?=$_title?>
  </h1>
  <div class="container">
    <h3><?=$_content?></h3>
    <hr />
    <p></p>

    <a href="javascript:history.back()" >Go back</a>
    <a href="<?=$link?>"  style="margin-left: 15px"  ><?=$_links['title']?></a>
  </div>
</body>
</html>
