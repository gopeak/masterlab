<link rel="stylesheet" href="<?= ROOT_URL ?>dev/css/helper.css?v=<?=$_version?>"/>

<!--<div class="help-btn">-->
<!--    <i class="fa fa-question-circle"></i>-->
<!--</div>-->

<div class="helper-btn animated js-key-help" id="helper-btn">
    <img class="helper-img" src="<?=ROOT_URL?>dev/img/helper-img.png">

    <div class="helper-hint notice-tooltip notice-type-success notice-position-left single-line hide_hint">
        <div class="notice-content">嘿，我来帮您！</div>
    </div>

    <div class="animated-circles">
        <div class="circle c-1"></div>
        <div class="circle c-2"></div>
        <div class="circle c-3"></div>
    </div>
</div>

<div id="helper_panel" class="helper-panel hide">
    <div class="close-helper">
        <span class="text">close</span>
        <span><i class="fa fa-times"></i></span>
    </div>
    <div class="bg-linear"></div>
    <div class="helper-content">
        <div class="panel">
            <div class="panel-title">
                <p>是否有以下这些疑问？</p>
            </div>
            <div class="panel-body">
                <div class="main-content">
                    <ul id="">
                        <li class="more-detail"><i class="fa fa-file"></i> 快速开始</li>
                        <li class="more-detail" id="short_key"><i class="fa fa-file"></i> 快捷键</li>
                        <li class="more-detail" id="qa"><i class="fa fa-file"></i> 常见问题</a></li>
                    </ul>
                </div>
                <hr>
                <div class="extra-help">
                    <ul>
                        <li><a href="http://www.masterlab.vip" target="_blank">Masterlab官网</a></li>
                        <li><a href="http://www.masterlab.vip/help.php?md=install" target="_blank">Masterlab安装及使用</a></li>
                        <li><a href="http://www.masterlab.vip/about.php" target="_blank">关于我们</a></li>
<!--                        <li class="comment-content"><a href="https://github.com/gopeak/masterlab/wiki/%E5%85%B3%E4%BA%8EMasterlab" target="_blank"><i class="fa fa-link"></i> 关于 Masterlab</a></li>-->
<!--                        <li class="history-detail"><a href="https://github.com/gopeak/masterlab/wiki/%E5%85%B3%E4%BA%8E%E7%A0%94%E5%8F%91%E5%9B%A2%E9%98%9F" target="_blank"><i class="fa fa-link"></i> 关于研发团队</a></li>-->
                    </ul>
                </div>
            </div>
        </div>
        <div class="bottom">
            <div class="search-help">
                <input type="text" class="searchAnswer" placeholder="该内容正在拼命建设中...">
                <span class="icon-content"><i class="fa fa-search"></i></span>
            </div>
        </div>
    </div>
    <div class="clean-card hide">
        <i class="fa fa-times fa-fw"></i>
    </div>
    <div class="card hide" id="detail_content"><!--详细内容-->
        <div class="detail">
            <h4>快速开始</h4>
            <p>在浏览器输入Masterlab网址</p>
            <div class="fragment">
                <h3>登录和注册</h3>
                <p>打开 Masterlab 的登录界面,输入用户名、密码即可登录 Masterlab 系统，如下图所示： </p>
            </div>
            <div class="img-content"><!--2px白边-->
                <a href="<?=ROOT_URL?>doc/images/login_01_thumb.png" target="_blank">
                    <img src="<?=ROOT_URL?>doc/images/login_01_thumb.png" title="点击查看">
                </a>
            </div>
            <div class="fragment">
                <p>点击注册链接，输入显示名称、邮箱地址、密码，点击确定即可，界面如下图所示： </p>
            </div>
            <div class="img-content"><!--2px白边-->
                <a href="<?=ROOT_URL?>doc/images/login_02_thumb.png" target="_blank">
                    <img src="<?=ROOT_URL?>doc/images/login_02_thumb.png" title="点击查看">
                </a>
            </div>
            <div class="fragment">
                <h3>创建组织</h3>
                <p>在首页上点击创建组织，其中组织关键字是用来做路由导航使用，要求必须唯一且必须为字母(如cnpc、huawei等)，如下图所示： </p>
            </div>
            <div class="img-content"><!--2px白边-->
                <a href="<?=ROOT_URL?>doc/images/org_01.png" target="_blank">
                    <img src="<?=ROOT_URL?>doc/images/org_01.png" title="点击查看">
                </a>
            </div>
            <div class="fragment">
                <h3>创建项目</h3>
                <p>在Masterlab首页上点击创建项目，在创建项目页面填写项目的详细信息。其中项目key是用来做路由导航使用，必须唯一且必须为字母(如android、ios等)；如下图所示： </p>
            </div>
            <div class="img-content"><!--2px白边-->
                <a href="<?=ROOT_URL?>doc/images/proj_01.png" target="_blank">
                    <img src="<?=ROOT_URL?>doc/images/proj_01.png" title="点击查看">
                </a>
            </div>
            <div class="fragment">
                <h3>项目设置</h3>
                <p>在项目的设置界面中，提供了基本信息、事项类型、版本、模块、标签、项目角色等设置，可以通过点击项目设置界面中对应的超链接进入页面进行相应设置 </p>
            </div>
            <div class="fragment">
                <h3>创建事项</h3>
                <p>在创建事项界面中，选择项目、事项类型，填写标题、描述，选择优先级、模块、经办人，设置开始日期、截止日期等，如下图所示：  </p>
            </div>
            <div class="img-content"><!--2px白边-->
                <a href="<?=ROOT_URL?>doc/images/issue_21.png" target="_blank">
                    <img src="<?=ROOT_URL?>doc/images/issue_21.png" title="点击查看">
                </a>
                <a href="<?=ROOT_URL?>doc/images/issue_22_thumb.png" target="_blank">
                    <img src="<?=ROOT_URL?>doc/images/issue_22_thumb.png" title="点击查看">
                </a>
            </div>
            <div class="fragment">
                <h3>敏捷开发</h3>
                <p>敏捷开发以用户的需求进化为核心，采用迭代、循序渐进的方法进行软件开发。 </p>
                <h4>创建迭代</h4>
                <p>在项目的详细信息界面中，点击迭代链接，点击左侧导航栏的创建迭代按钮，弹出创建迭代框，输入名称、描述、开始时间、结束时间，如下图所示：</p>
            </div>
            <div class="img-content"><!--2px白边-->
                <a href="<?=ROOT_URL?>doc/images/sprints_05.png" target="_blank">
                    <img src="<?=ROOT_URL?>doc/images/sprints_05.png" title="点击查看">
                </a>
            </div>
            <div class="fragment">
                <h4>跟踪和管理迭代</h4>
                <p>在项目的详细信息界面中，点击迭代链接，点击左侧导航栏的某个迭代，右侧将会显示该迭代的所有事项列表，可以拖动事项的顺序以调整事项在迭代事项列表的显示顺序</p>
            </div>
            <div class="fragment">
                <h4>通过看板管理迭代</h4>
                <p>在项目的详细信息界面中，点击看板链接，可以看到通过看板形式直观的展示各个状态的事项清单，如下图所示： </p>
            </div>
            <div class="fragment">
                <h3>数据和图表分析</h3>
                <p>Masterlab提供了丰富的图表和统计功能 </p>
            </div>
            <div class="img-content"><!--2px白边-->
                <a href="<?=ROOT_URL?>doc/images/chart_01.png" target="_blank">
                    <img src="<?=ROOT_URL?>doc/images/chart_01.png" title="点击查看">
                </a>
                <a href="<?=ROOT_URL?>doc/images/chart_02_thumb.png" target="_blank">
                    <img src="<?=ROOT_URL?>doc/images/chart_02_thumb.png" title="点击查看">
                </a>
            </div>
            <p class="second-title">
                <span class="small-title"></span><a href="http://www.masterlab.vip/help.php?md=quickstart" target="_blank">详细信息请点击查看</a>
            </p>
        </div>
    </div>
    <div class="card hide" id="detail_content_shortkey"><!--详细内容-->
        <div class="detail">
            <h4>Masterlab快捷键</h4>
            <p class="second-title">
                <span class="small-title">M : </span>打开导航菜单
            </p>
            <p class="second-title">
                <span class="small-title">S : </span>焦点搜索框
            </p>
            <p class="second-title">
                <span class="small-title">Ctrl+Enter : </span>提交表单
            </p>
            <p class="second-title">
                <span class="small-title">C : </span>打开创建表单
            </p>
            <p class="second-title">
                <span class="small-title">E : </span>编辑鼠标所在的事项
            </p>
            <p class="second-title">
                <span class="small-title">H : </span>打开帮助
            </p>
            <p class="second-title">
                <span class="small-title">N : </span>打开带快捷键提示菜单
            </p>
            <div class="catalog-link">
                <p class="second-title">
                    <span class="small-title">参考链接：</span>
                </p>
                <ul>
                    <li><a href="http://www.masterlab.vip/help.php" target="_blank">Masterlab 使用指南</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card hide" id="detail_content_qa"><!--详细内容-->
        <div class="detail">
            <h4>Masterlab常见问题</h4>
            <div class="fragment">
                <h3>如何快速的上手Masterlab？</h3>
                <p>1.首先以管理员身份登录Masterlab</p>
                <p>2.接着在系统中创建用户账号</p>
                <p>3.如果您的开发团队项目不多，可创建直接在defalut组织下创建项目</p>
                <p>4.在项目中再创建事项(bug 任务 优化改进型等)并分配给用户</p>
                <p>5.然后通过迭代看板和统计图表跟进事项的状态和解决结果。</p>
            </div>
            <div class="fragment">
                <h3>什么是事项？</h3>
                <p>事项可以是一件事情，一个任务，一个需求，或一个bug，如果masterlab自带的事项类型不满足您的需求，管理员可以在系统中添加自定义事项类型</p>
            </div>
            <div class="fragment">
                <h3>什么是经办人？</h3>
                <p>事项指派的处理人,也是负责人。分工明确，责任到人有利于提高团队协作的效率。</p>
            </div>
            <div class="fragment">
                <h3>状态和解决结果的区别？</h3>
                <p>状态是事项周期内的某一个过程的体现，状态一般由经办人如开发人员 设计师来变更。</p>
                <p>解决结果是对经办人处理事项状态的评定，解决结果一般由QA或产品经理在操作。</p>
                <p>状态和解决结果在用户刚使用的时候搞混，最好的区分方法由不同角色操作即可。</p>
            </div>
            <div class="fragment">
                <h3>什么是工作流？</h3>
                <p>工作流是按照一定的规则和过程执行一个事项，在Masterlab中体现在事项在生命周期内不同状态之间的变化。 每个状态以矩形框表示。  每个工作流跳转由箭头指引方向。你可以在 "系统"中添加自己的自定义工作流，详见<a target="_blank" href="http://www.masterlab.vip/help.php?md=explain_word">《使用指南》</a>。</p>
            </div>
            <div class="fragment">
                <h3>发现严重bug或修改怎么办？</h3>
                <p>您可以到 <a target="_blank" href="https://github.com/gopeak/masterlab/issues/new">GitHub</a> 提交您发现的bug或建议，我们将会尽快处理和反馈。</p>
            </div>
            <div class="fragment">
                <h3>Masterlab可以商业化吗？</h3>
                <p>你可以免费使用Masterlab社区版无需任何费用,您也可以对Masterlab社区版进行二次开发，但不得用于商业化，如需商业化或商业合作请联系QQ群<a target="_blank" href="https://jq.qq.com/?_wv=1027&k=51oDG9Z">314155057</a> 管理员进行授权。</p>
                <p>其他问题还可以加入我们的QQ群进行咨询:  <a target="_blank" href="https://jq.qq.com/?_wv=1027&k=51oDG9Z">314155057</a> </p>
            </div>
        </div>
    </div>
    <div class="card hide" id="contact-panel"><!--对话框-->
        <div class="top-part">
            <i class="fa fa-arrow-left"></i>
            <p class="text-center">
                <span class="small-title">建议&疑问</span>
            </p>
            <div class="img-group text-center">
                <div class="img-col">
                    <div class="img_item">
                        <img src="<?=ROOT_URL?>dev/img/test-float-panel.png" alt="">
                    </div>
                </div>
                <div class="img-col">
                    <div class="img_item">
                        <img src="<?=ROOT_URL?>dev/img/test-float-panel.png" alt="">
                    </div>
                </div>
                <div class="img-col">
                    <div class="img_item">
                        <img src="<?=ROOT_URL?>dev/img/test-float-panel.png" alt="">
                    </div>
                </div>
                <div class="img-col">
                    <div class="img_item">
                        <img src="<?=ROOT_URL?>dev/img/test-float-panel.png" alt="">
                    </div>
                </div>
                <div class="img-col">
                    <div class="img_item">
                        <img src="<?=ROOT_URL?>dev/img/test-float-panel.png" alt="">
                    </div>
                </div>
            </div>
            <p class="small-title text-center">我们的团队竭尽全力帮助您~</p>
            <p class="text-center">我们会在几小时之内解决您的疑问</p>
        </div>
        <div class="bottom-part">
            <span class="textarea-tips">留下您的建议或问题吧~</span>
            <textarea></textarea>
            <i class="spot"></i>
            <a href="" class="btn sendContact">提交</a>
        </div>
    </div>
    <div class="card hide" id="history-content"><!--历史信息-->
        <div class="top-part">
            <i class="fa fa-arrow-left"></i>
            <p class="text-center">
                <span class="small-title">12345</span>
            </p>
        </div>
        <div class="list-content">
            <div class="list-fragment">
                <p class="title-text">刚刚用户输入的问题XXX</p>
                <p>
                    <i class="fa fa-check"></i>
                    <span>已接收，等待回答</span>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        //helper的内容
        $('#helper_panel').on('click',function(e){
            if($(e.target).hasClass('more-detail')||$(e.target).hasClass('comment-content')||$(e.target).hasClass('history-detail')){
                $('.card').addClass('hide');
                $('.close-helper').addClass('hide');
                $('.helper-content').addClass('hide');
            }
            if($(e.target).parent().hasClass('clean-card')||$(e.target).hasClass('clean-card')||$(e.target).hasClass('fa-arrow-left')){
                $('.card').addClass('hide');
                $('.helper-content').removeClass('hide');
                $('.clean-card').addClass('hide');
                $('.close-helper').removeClass('hide');
            }
            if($(e.target).parent().hasClass('clean-card')||$(e.target).hasClass('clean-card')||$(e.target).hasClass('fa-arrow-left')){
                $('.card').addClass('hide');
                $('.helper-content').removeClass('hide');
                $('.clean-card').addClass('hide');
            }
            if($(e.target).hasClass('more-detail')){
                if($(e.target)[0].id==='short_key')
                {
                    $('#detail_content_shortkey').removeClass('hide');
                    $('.clean-card').removeClass('hide');
                }
                else if($(e.target)[0].id==='qa')
                {
                    $('#detail_content_qa').removeClass('hide');
                    $('.clean-card').removeClass('hide');
                }
                else {
                    $('#detail_content').removeClass('hide');
                    $('.clean-card').removeClass('hide');
                }
            }
            if($(e.target).hasClass('comment-content')){
                $('#contact-panel').removeClass('hide');
            }
            if($(e.target).hasClass('history-detail')){
                $('#history-content').removeClass('hide');
            }
        });

        $(".close-helper").on('click', function (e) {
            e.preventDefault();
            $('#helper_panel').addClass('hide never');
        });

        var $animated = $(".animated-circles");

        var wait = setInterval(function(){
            $(".helper-hint").removeClass("show_hint").addClass("hide_hint");
            clearInterval(wait);
        },4500);

        $('#helper-btn').hover(function(){
            addAnimation();
            clearInterval(wait);
            $(".helper-hint").removeClass("hide_hint").addClass("show_hint");
        }, function(){
            $(".helper-hint").removeClass("show_hint").addClass("hide_hint");
            removeAnimation();
        }).on('click', function () {
            $('#helper_panel').removeClass('hide');
            removeAnimation();
        });

        function addAnimation() {
            if($animated.hasClass('animated')) {
                setTimeout(function () {
                    $animated.removeClass('animated')
                }, 300, function () {
                    $animated.addClass('animated');
                })
            } else {
                $animated.addClass('animated');
            }
        }

        function removeAnimation() {
            $animated.removeClass('animated');
        }
    });
    /*todo:添加滚动事件，添加两属性值right:17px;scaleY(1)==>bg-linear(可以不做)*/
</script>