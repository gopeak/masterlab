<?php
$page = 'ux';
?>
<!DOCTYPE html>
<!-- saved from url=(0058)https://antv.alipay.com/zh-cn/g2/3.x/tutorial/history.html -->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>MasterLab - 互联网项目、产品管理解决方案--UX设计原则</title>
    <link rel="icon" href="https://gw.alipayobjects.com/os/antv/assets/favoricon.png" type="image/x-icon">
    <link rel="stylesheet" href="./history_files/bootstrap.min.css">
    <link rel="stylesheet" href="./history_files/bootstrap-grid.min.css">
    <link rel="stylesheet" href="./history_files/font_470089_q8g1f7kwli.css">
    <link rel="stylesheet" href="./history_files/common-84eda.css">
    <link rel="stylesheet" href="./history_files/solarized-light.css">
    <link rel="stylesheet" href="./history_files/tocbot.css">
    <link rel="stylesheet" href="./history_files/doc-dda30.css">
    <link href="./favicon.ico" rel="shortcut icon" type="image/x-icon">

    <link href="./favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="./product_files/index-1.css">
    <link rel="stylesheet" type="text/css" href="./product_files/index-2.css">
    <link rel="stylesheet" type="text/css" href="./product_files/featrue.css">

</head>
<body class="template-doc">
<div style="display: none">
    <img src="./history_files/logo-with-text.svg" alt=""> <img
            src="./history_files/bpKcpwimYnZMTarUxCEd.png" alt="">
</div>
<? include 'header.php' ?>

<div class="drawer-toggle"><span class="iconfont icon-menu-fold"></span></div>
<div class="drawer-overlay"></div>

<div class="doc-container container-fluid">
    <div class="row flex-xl-nowrap">
        <div class="menu bd-sidebar drawer">
            <div class="inner">
                <div class="filter-container"></div>
                <ul class="list-group">
                    <li class="list-group-item"><a href="./design.php">设计原则</a></li>
                    <li class="list-group-item active"><a href="./color.php">色彩</a></li>
                    <li class="list-group-item "><a href="./fonts.php">字体</a></li>
                </ul>
            </div>
        </div>
        <div class="detail content">
            <div class="toc-container" style="position: absolute;">
                <div class="toc">
                    <ul class="toc-list ">
                        <li class="toc-list-item"><a href="#_色彩" class="toc-link node-name--H1  is-active-link">色彩</a>
                            <ul class="toc-list ">
                                <li class="toc-list-item"><a href="#_色板" class="toc-link node-name--H2 ">色板</a>
                                    <ul class="toc-list ">
                                        <li class="toc-list-item"><a href="#_分类色板"
                                                                     class="toc-link node-name--H3 ">分类色板</a></li>
                                        <li class="toc-list-item"><a href="#_连续色板"
                                                                     class="toc-link node-name--H3 ">连续色板</a></li>
                                        <li class="toc-list-item"><a href="#_语义色板"
                                                                     class="toc-link node-name--H3 ">语义色板</a></li>
                                    </ul>
                                </li>
                                <li class="toc-list-item"><a href="#_透明度使用建议"
                                                             class="toc-link node-name--H2 ">透明度使用建议</a></li>
                                <li class="toc-list-item"><a href="#_无障碍色彩检验"
                                                             class="toc-link node-name--H2 ">无障碍色彩检验</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <article><h1 id="_色彩"><a href="#_色彩" class="anchor"></a>色彩</h1>
                <p>AntV 的色彩是基于 <a href="https://docs.gitlab.com/ee/development/ux_guide/features.html">Gitlab 和 Ant Design 色彩体系</a>，并结合数据可视化特性而设计。在数据可视化设计中，对色彩的运用应首先考虑准确性，需达到信息传递、操作指引、交互反馈，或是强化、凸显某一个信息的目的，其次是品牌识别性。
                </p>
                <p>选择 AntV 色彩时有以下三个注意点：</p>
                <ul>
                    <li>根据不同的数据特性选择相应的色彩，保证数据传达的准确性；</li>
                    <li>结合当前页面环境，建立视觉连续性；</li>
                    <li>视觉层次清晰可辨，保证色彩足够的对比度的同时更容易被视障碍（色盲、色弱）用户辨别。</li>
                </ul>
                <h2 id="_色板"><a href="#_色板" class="anchor"><span class="iconfont icon-link"></span></a>色板</h2>
                <p>AntV 色板包含分类色板、连续色板及语义色板，用户选择色板时需对照数据特性选择相应配色方案。</p>
                <h3 id="_分类色板"><a href="#_分类色板" class="anchor"><span class="iconfont icon-link"></span></a>分类色板</h3>
                <table>
                    <thead>
                    <tr>
                        <th style="text-align:left"><strong>色板定义</strong></th>
                        <th style="text-align:left">通过每个颜色的不同，传达不同的数据点之间的视觉差异</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="text-align:left"><strong>适用数据类型</strong></td>
                        <td style="text-align:left">分类型数据（也称离散型数据）</td>
                    </tr>
                    <tr>
                        <td style="text-align:left"><strong>示例</strong></td>
                        <td style="text-align:left">事物分类、部门名称、地理位置等</td>
                    </tr>
                    </tbody>
                </table>
                <p>分类色板中的颜色不具有任何语义，因此我们建议按照以下顺序使用。</p>
                <div id="palette-category">
                    <div id="palette1" class="palette">
                        <div class="color" style="background: #1890FF" data-clipboard-text="#1890FF">
                            <span class="color-value" style="color: #314659;">#1890FF</span>
                        </div>
                        <div class="color" style="background: #2FC25B" data-clipboard-text="#2FC25B">
                            <span class="color-value" style="color: #FFF;">#2FC25B</span>
                        </div>
                        <div class="color" style="background: #FACC14" data-clipboard-text="#FACC14">
                            <span class="color-value" style="color: #314659;">#FACC14</span>
                        </div>
                        <div class="color" style="background: #223273" data-clipboard-text="#223273">
                            <span class="color-value" style="color: #FFF;">#223273</span>
                        </div>
                        <div class="color" style="background: #8543E0" data-clipboard-text="#8543E0">
                            <span class="color-value" style="color: #314659;">#8543E0</span>
                        </div>
                        <div class="color" style="background: #13C2C2" data-clipboard-text="#13C2C2">
                            <span class="color-value" style="color: #314659;">#13C2C2</span>
                        </div>
                        <div class="color" style="background: #3436C7" data-clipboard-text="#3436C7">
                            <span class="color-value" style="color: #FFF;">#3436C7</span>
                        </div>
                        <div class="color" style="background: #F04864" data-clipboard-text="#F04864">
                            <span class="color-value" style="color: #314659;">#F04864</span>
                        </div>
                    </div>
                </div>
                <h3 id="_连续色板"><a href="#_连续色板" class="anchor"><span class="iconfont icon-link"></span></a>连续色板</h3>
                <table>
                    <thead>
                    <tr>
                        <th style="text-align:left"><strong>色板定义</strong></th>
                        <th style="text-align:left">通过使用不同的深浅层次，传达从低到高的值</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="text-align:left"><strong>适用数据类型</strong></td>
                        <td style="text-align:left">连续型数据</td>
                    </tr>
                    <tr>
                        <td style="text-align:left"><strong>示例</strong></td>
                        <td style="text-align:left">年龄、销售额、时间、温度等</td>
                    </tr>
                    </tbody>
                </table>
                <div id="palette-linear">
                    <div id="palette2" class="palette">
                        <div class="color" style="background: #E6F7FF" data-clipboard-text="#E6F7FF">
                            <span class="color-value" style="color: #314659;">#E6F7FF</span>
                        </div>
                        <div class="color" style="background: #BAE7FF" data-clipboard-text="#BAE7FF">
                            <span class="color-value" style="color: #314659;">#BAE7FF</span>
                        </div>
                        <div class="color" style="background: #91D5FF" data-clipboard-text="#91D5FF">
                            <span class="color-value" style="color: #314659;">#91D5FF</span>
                        </div>
                        <div class="color" style="background: #69C0FF" data-clipboard-text="#69C0FF">
                            <span class="color-value" style="color: #314659;">#69C0FF</span>
                        </div>
                        <div class="color" style="background: #40A9FF" data-clipboard-text="#40A9FF">
                            <span class="color-value" style="color: #314659;">#40A9FF</span>
                        </div>
                        <div class="color" style="background: #1890FF" data-clipboard-text="#1890FF">
                            <span class="color-value" style="color: #314659;">#1890FF</span>
                        </div>
                        <div class="color" style="background: #096DD9" data-clipboard-text="#096DD9">
                            <span class="color-value" style="color: #FFF;">#096DD9</span>
                        </div>
                        <div class="color" style="background: #0050B3" data-clipboard-text="#0050B3">
                            <span class="color-value" style="color: #FFF;">#0050B3</span>
                        </div>
                        <div class="color" style="background: #003A8C" data-clipboard-text="#003A8C">
                            <span class="color-value" style="color: #FFF;">#003A8C</span>
                        </div>
                        <div class="color" style="background: #002766" data-clipboard-text="#002766">
                            <span class="color-value" style="color: #FFF;">#002766</span>
                        </div>
                    </div>
                </div>
                <h4 id="_色板生成工具"><a href="#_色板生成工具" class="anchor"><span class="iconfont icon-link"></span></a>色板生成工具
                </h4>
                <p>如果上面的色板不能满足你的需求，你可以选择一个主色，Ant Design 的<a
                            href="https://ant.design/docs/spec/colors-cn#%E8%89%B2%E6%9D%BF%E7%94%9F%E6%88%90%E5%B7%A5%E5%85%B7">色彩生成算法工具</a>会为你生成完整的色板。
                </p>
                <h3 id="_语义色板"><a href="#_语义色板" class="anchor"><span class="iconfont icon-link"></span></a>语义色板</h3>
                <table>
                    <thead>
                    <tr>
                        <th style="text-align:left"><strong>色板定义</strong></th>
                        <th style="text-align:left">通过四种公认的颜色，来传达“好”、“差”、“重要”和“中性”等含义，且具备深浅层次</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="text-align:left"><strong>适用数据类型</strong></td>
                        <td style="text-align:left">公认的有含义的数据</td>
                    </tr>
                    <tr>
                        <td style="text-align:left"><strong>示例</strong></td>
                        <td style="text-align:left">好、差、重要、中性、男女、主次等</td>
                    </tr>
                    </tbody>
                </table>
                <p>表达正面的、可行、植物、安全、成功等含义</p>
                <blockquote><p>ps. 在西方股票市场，绿色代表股价上升；在中国股票市场则相反。</p></blockquote>
                <div id="palette-success">
                    <div id="palette3" class="palette">
                        <div class="color" style="background: #F0FFF2" data-clipboard-text="#F0FFF2">
                            <span class="color-value" style="color: #314659;">#F0FFF2</span>
                        </div>
                        <div class="color" style="background: #D7F5DC" data-clipboard-text="#D7F5DC">
                            <span class="color-value" style="color: #314659;">#D7F5DC</span>
                        </div>
                        <div class="color" style="background: #A7E8B4" data-clipboard-text="#A7E8B4">
                            <span class="color-value" style="color: #314659;">#A7E8B4</span>
                        </div>
                        <div class="color" style="background: #7BDB91" data-clipboard-text="#7BDB91">
                            <span class="color-value" style="color: #314659;">#7BDB91</span>
                        </div>
                        <div class="color" style="background: #53CF74" data-clipboard-text="#53CF74">
                            <span class="color-value" style="color: #314659;">#53CF74</span>
                        </div>
                        <div class="color" style="background: #2FC25B" data-clipboard-text="#2FC25B">
                            <span class="color-value" style="color: #FFF;">#2FC25B</span>
                        </div>
                        <div class="color" style="background: #1E9C48" data-clipboard-text="#1E9C48">
                            <span class="color-value" style="color: #FFF;">#1E9C48</span>
                        </div>
                        <div class="color" style="background: #107535" data-clipboard-text="#107535">
                            <span class="color-value" style="color: #FFF;">#107535</span>
                        </div>
                        <div class="color" style="background: #074F24" data-clipboard-text="#074F24">
                            <span class="color-value" style="color: #FFF;">#074F24</span>
                        </div>
                        <div class="color" style="background: #032914" data-clipboard-text="#032914">
                            <span class="color-value" style="color: #FFF;">#032914</span>
                        </div>
                    </div>
                </div>
                <p>表达警告、注意、阻止等含义</p>
                <div id="palette-warn">
                    <div id="palette4" class="palette">
                        <div class="color" style="background: #FFF7E6" data-clipboard-text="#FFF7E6">
                            <span class="color-value" style="color: #314659;">#FFF7E6</span>
                        </div>
                        <div class="color" style="background: #FFE7BA" data-clipboard-text="#FFE7BA">
                            <span class="color-value" style="color: #314659;">#FFE7BA</span>
                        </div>
                        <div class="color" style="background: #FFD591" data-clipboard-text="#FFD591">
                            <span class="color-value" style="color: #314659;">#FFD591</span>
                        </div>
                        <div class="color" style="background: #FFC069" data-clipboard-text="#FFC069">
                            <span class="color-value" style="color: #314659;">#FFC069</span>
                        </div>
                        <div class="color" style="background: #FFA940" data-clipboard-text="#FFA940">
                            <span class="color-value" style="color: #314659;">#FFA940</span>
                        </div>
                        <div class="color" style="background: #FA8C16" data-clipboard-text="#FA8C16">
                            <span class="color-value" style="color: #314659;">#FA8C16</span>
                        </div>
                        <div class="color" style="background: #D46B08" data-clipboard-text="#D46B08">
                            <span class="color-value" style="color: #FFF;">#D46B08</span>
                        </div>
                        <div class="color" style="background: #AD4E00" data-clipboard-text="#AD4E00">
                            <span class="color-value" style="color: #FFF;">#AD4E00</span>
                        </div>
                        <div class="color" style="background: #873800" data-clipboard-text="#873800">
                            <span class="color-value" style="color: #FFF;">#873800</span>
                        </div>
                        <div class="color" style="background: #612500" data-clipboard-text="#612500">
                            <span class="color-value" style="color: #FFF;">#612500</span>
                        </div>
                    </div>
                </div>
                <p>表达负面的、不可行、严重、危险、失败等含义</p>
                <div id="palette-error">
                    <div id="palette5" class="palette">
                        <div class="color" style="background: #FFF0F0" data-clipboard-text="#FFF0F0">
                            <span class="color-value" style="color: #314659;">#FFF0F0</span>
                        </div>
                        <div class="color" style="background: #FFDCDC" data-clipboard-text="#FFDCDC">
                            <span class="color-value" style="color: #314659;">#FFDCDC</span>
                        </div>
                        <div class="color" style="background: #FFC8CB" data-clipboard-text="#FFC8CB">
                            <span class="color-value" style="color: #314659;">#FFC8CB</span>
                        </div>
                        <div class="color" style="background: #FF9EA8" data-clipboard-text="#FF9EA8">
                            <span class="color-value" style="color: #314659;">#FF9EA8</span>
                        </div>
                        <div class="color" style="background: #FC7486" data-clipboard-text="#FC7486">
                            <span class="color-value" style="color: #314659;">#FC7486</span>
                        </div>
                        <div class="color" style="background: #F04864" data-clipboard-text="#F04864">
                            <span class="color-value" style="color: #314659;">#F04864</span>
                        </div>
                        <div class="color" style="background: #C93251" data-clipboard-text="#C93251">
                            <span class="color-value" style="color: #FFF;">#C93251</span>
                        </div>
                        <div class="color" style="background: #A32240" data-clipboard-text="#A32240">
                            <span class="color-value" style="color: #FFF;">#A32240</span>
                        </div>
                        <div class="color" style="background: #7C132F" data-clipboard-text="#7C132F">
                            <span class="color-value" style="color: #FFF;">#7C132F</span>
                        </div>
                        <div class="color" style="background: #570D23" data-clipboard-text="#570D23">
                            <span class="color-value" style="color: #FFF;">#570D23</span>
                        </div>
                    </div>
                </div>
                <p>表达中性、可忽略的、次要、失效、已结束等含义</p>
                <div id="palette-secondary">
                    <div id="palette6" class="palette">
                        <div class="color" style="background: #FAFBFC" data-clipboard-text="#FAFBFC">
                            <span class="color-value" style="color: #314659;">#FAFBFC</span>
                        </div>
                        <div class="color" style="background: #F2F4F5" data-clipboard-text="#F2F4F5">
                            <span class="color-value" style="color: #314659;">#F2F4F5</span>
                        </div>
                        <div class="color" style="background: #EBEDF0" data-clipboard-text="#EBEDF0">
                            <span class="color-value" style="color: #314659;">#EBEDF0</span>
                        </div>
                        <div class="color" style="background: #CED4D9" data-clipboard-text="#CED4D9">
                            <span class="color-value" style="color: #314659;">#CED4D9</span>
                        </div>
                        <div class="color" style="background: #A3B1BF" data-clipboard-text="#A3B1BF">
                            <span class="color-value" style="color: #314659;">#A3B1BF</span>
                        </div>
                        <div class="color" style="background: #697B8C" data-clipboard-text="#697B8C">
                            <span class="color-value" style="color: #FFF;">#697B8C</span>
                        </div>
                        <div class="color" style="background: #314659" data-clipboard-text="#314659">
                            <span class="color-value" style="color: #FFF;">#314659</span>
                        </div>
                        <div class="color" style="background: #0D1A26" data-clipboard-text="#0D1A26">
                            <span class="color-value" style="color: #FFF;">#0D1A26</span>
                        </div>
                    </div>
                </div>
                <p>热力图专用</p>
                <div id="palette-heatmap">
                    <div id="palette7" class="palette">
                        <div class="color" style="background: #531DAB" data-clipboard-text="#531DAB">
                            <span class="color-value" style="color: #FFF;">#531DAB</span>
                        </div>
                        <div class="color" style="background: #2F54EB" data-clipboard-text="#2F54EB">
                            <span class="color-value" style="color: #FFF;">#2F54EB</span>
                        </div>
                        <div class="color" style="background: #40A9FF" data-clipboard-text="#40A9FF">
                            <span class="color-value" style="color: #314659;">#40A9FF</span>
                        </div>
                        <div class="color" style="background: #5CDBD3" data-clipboard-text="#5CDBD3">
                            <span class="color-value" style="color: #314659;">#5CDBD3</span>
                        </div>
                        <div class="color" style="background: #B7EB8F" data-clipboard-text="#B7EB8F">
                            <span class="color-value" style="color: #314659;">#B7EB8F</span>
                        </div>
                        <div class="color" style="background: #FFE58F" data-clipboard-text="#FFE58F">
                            <span class="color-value" style="color: #314659;">#FFE58F</span>
                        </div>
                        <div class="color" style="background: #FFC069" data-clipboard-text="#FFC069">
                            <span class="color-value" style="color: #314659;">#FFC069</span>
                        </div>
                        <div class="color" style="background: #FF7A45" data-clipboard-text="#FF7A45">
                            <span class="color-value" style="color: #314659;">#FF7A45</span>
                        </div>
                        <div class="color" style="background: #F53B44" data-clipboard-text="#F53B44">
                            <span class="color-value" style="color: #FFF;">#F53B44</span>
                        </div>
                        <div class="color" style="background: #A8071A" data-clipboard-text="#A8071A">
                            <span class="color-value" style="color: #FFF;">#A8071A</span>
                        </div>
                    </div>
                </div>
                <h2 id="_透明度使用建议"><a href="#_透明度使用建议" class="anchor"><span class="iconfont icon-link"></span></a>透明度使用建议
                </h2>
                <table>
                    <thead>
                    <tr>
                        <th style="text-align:left">形态</th>
                        <th style="text-align:left">建议透明度</th>
                        <th style="text-align:left">实例</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="text-align:left">线<br>例如：折线图、图的边线</td>
                        <td style="text-align:left">100%</td>
                        <td style="text-align:left"><img
                                    src="https://gw.alipayobjects.com/zos/rmsportal/hrpMdOPMTWnCrCrBSSvj.png"
                                    width="132" alt="line" style="width: 132px"></td>
                    </tr>
                    <tr>
                        <td style="text-align:left">中等面积<br>例如：柱形图、饼图、环图、漏斗图等</td>
                        <td style="text-align:left">85%</td>
                        <td style="text-align:left"><img
                                    src="https://gw.alipayobjects.com/zos/rmsportal/rzlkDFcyDflYfGYlJIRz.png"
                                    width="132" alt="pie" style="width: 132px"> <img
                                    src="https://gw.alipayobjects.com/zos/rmsportal/WtXZARTsHWPAIuRYNrWT.png"
                                    width="132" alt="bar" style="width: 132px"></td>
                    </tr>
                    <tr>
                        <td style="text-align:left">大面积<br>例如：面积图、点图、雷达图等</td>
                        <td style="text-align:left">30%</td>
                        <td style="text-align:left"><img
                                    src="https://gw.alipayobjects.com/zos/rmsportal/vKVfUIQcaFtdlGdIZGTH.png"
                                    width="132" alt="point" style="width: 132px"> <img
                                    src="https://gw.alipayobjects.com/zos/rmsportal/LbhQlkkUiCiTXaKpRkRb.png"
                                    width="132" alt="area" style="width: 132px"></td>
                    </tr>
                    </tbody>
                </table>
                <h2 id="_无障碍色彩检验"><a href="#_无障碍色彩检验" class="anchor"><span class="iconfont icon-link"></span></a>无障碍色彩检验
                </h2>
                <p>以上色板均通过 <a href="http://www.color-blindness.com/coblis-color-blindness-simulator/">色盲色弱测试工具</a>
                    测试，如果你使用了新的色板，我们建议使用此工具进行检验。</p>
                <div class="prev-next"><a href="./design.php" class="float-left pre">设计原则 </a><a
                            href="./fonts.php" class="float-right next">字体</a></div>
            </article>
        </div>
    </div>
</div>

<footer class="navbar navbar-expand-lg bg-dark" style="display: none">
    <div class="container">
        <div class="navbar-collapse" id="navbarFooter">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item"><a class="declaration" href="https://weibo.com/antv2017"><span
                                class="iconfont icon-sinaweibo"></span></a></li>
                <li class="nav-item"><a class="declaration" href="https://github.com/antvis/"><span
                                class="iconfont icon-github"></span></a></li>
                <li class="nav-item"><a class="declaration" href="https://antv.alipay.com/zh-cn/about.html">关于我们</a>
                </li>
            </ul>
            <a class="declaration" href="https://docs.alipay.com/policies/privacy/antfin">隐私权政策</a> <span>|</span> <a
                    class="declaration" href="https://render.alipay.com/p/f/fd-izto3cem/index.html">权益保障承诺书</a> <span>ICP 证浙 B2-2-100257 Copyright © 蚂蚁金融服务集团</span>
        </div>
    </div>
</footer>
<script type="text/javascript">/* eslint-disable */
    window.__meta = {
        "currentProduct": "g2",
        "assets": "/assets",
        "dist": "/assets/dist/3.0.0",
        "href": "/zh-cn/g2/3.x/tutorial/history.html",
        "locale": "zh-cn",
        "version": "3.0.0"
    };</script>
<script src="./history_files/lodash-4.17.4.min.js"></script>
<script src="./history_files/jquery-3.2.1.min.js"></script>
<script src="./history_files/jquery.autocomplete-1.4.3.min.js"></script>
<script src="./history_files/jquery.visible-1.2.0.min.js"></script>
<script src="./history_files/popper.min.js"></script>
<script src="./history_files/bootstrap.min.js"></script>
<script src="./history_files/lazyload-2.0.0-beta.2.min.js"></script>
<div id="___tracers" style="display:none">

</div>
<script src="./history_files/jquery.headroom-0.9.4.min.js"></script>
<script src="./history_files/clipboard-1.7.1.min.js"></script>
<script src="./history_files/tocbot.min.js"></script>
<script src="./history_files/doc-eda67.js"></script>
<script src="./history_files/common-729ed.js"></script>
<div class="autocomplete-suggestions"
     style="position: absolute; display: none; max-height: 300px; z-index: 9999;"></div>
<div class="autocomplete-suggestions"
     style="position: absolute; display: none; max-height: 300px; z-index: 9999;"></div>
</body>
</html>