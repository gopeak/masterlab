<link rel="stylesheet" href="<?= ROOT_URL ?>dev/css/issue/detail-list.css"/>

<div class="help-btn">
    <i class="fa fa-question-circle"></i>
</div>
<div id="helper_panel" class="hide">
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
                        <li class="more-detail"><i class="fa fa-file"></i> 开始使用</li>
                        <li class="more-detail"><i class="fa fa-file"></i> 快捷键的试用</li>
                        <li class="new-page"><i class="fa fa-link"></i> 我们工作特点</li><!--可以做链接-->
                    </ul>
                </div>
                <hr>
                <div class="extra-help">
                    <ul>
                        <li class="comment-content"><i class="fa fa-comments"></i> contact us</li>
                        <li class="history-detail"><i class="fa fa-history"></i> 历史记录</li>
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