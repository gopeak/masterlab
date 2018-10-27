<link rel="stylesheet" href="<?= ROOT_URL ?>dev/css/helper.css"/>

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
                        <li class="more-detail"><i class="fa fa-file"></i> 快捷键</li>
                        <li class="new-page"><i class="fa fa-link"></i> 常见问题</li><!--可以做链接-->
                    </ul>
                </div>
                <hr>
                <div class="extra-help">
                    <ul>
                        <li class="comment-content"><a href="https://github.com/gopeak/masterlab/wiki/%E5%85%B3%E4%BA%8EMasterlab" target="_blank"><i class="fa fa-link"></i> 关于 Masterlab</a></li>
                        <li class="history-detail"><a href="https://github.com/gopeak/masterlab/wiki/%E5%85%B3%E4%BA%8E%E7%A0%94%E5%8F%91%E5%9B%A2%E9%98%9F" target="_blank"><i class="fa fa-link"></i> 关于研发团队</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bottom">
            <div class="search-help">
                <input type="text" class="searchAnswer" placeholder="You can Search what you need">
                <span class="icon-content"><i class="fa fa-search"></i></span>
            </div>
        </div>
    </div>
    <div class="clean-card hide">
        <i class="fa fa-times fa-fw"></i>
    </div>
    <div class="card hide" id="detail_content"><!--详细内容-->
        <div class="detail">
            <h4>这是一个标题</h4>
            <div class="fragment">欢迎光临参加本次主题</div>
            <div class="fragment">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Est explicabo ipsam non numquam pariatur perferendis possimus ratione veniam.
                Amet cumque deserunt eaque inventore laudantium mollitia quasi reiciendis tempore,
                voluptas voluptatem.
            </div>
            <div class="img-content"><!--2px白边-->
                <img src="<?=ROOT_URL?>dev/img/gitlab_header_logo.png" alt="">
            </div>
            <div class="fragment">
                <h4>这又是一个标题</h4>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                Est explicabo ipsam non numquam p<a href="">click me</a> perferendis possimus ratione veniam.
                Amet cumque deserunt eaque inventore laudantium mollitia quasi reiciendis tempore,
                voluptas voluptatem.
            </div>
            <p class="second-title">
                <span class="small-title">123456 : </span><a href="">456</a>
            </p>
            <p class="second-title">
                <span class="small-title">123456 : </span>
            </p>
            <div class="fragment-notice"><!--虚线框，背景色-->
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aut blanditiis culpa, cumque,
                dicta dolorum earum eligendi exercitationem facilis,
                illo inventore nam nesciunt nobis non numquam rem sunt veritatis vitae.
            </div>
            <div class="catalog-link">
                <p class="second-title">
                    <span class="small-title">链接地址：</span>
                </p>
                <ul>
                    <li><a href="">click me</a></li>
                    <li><a href="">click me</a></li>
                    <li><a href="">click me</a></li>
                </ul>
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
                $('#detail_content').removeClass('hide');
                $('.clean-card').removeClass('hide');
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