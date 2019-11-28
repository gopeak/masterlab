<div class="status status-<?=$empty_data_status?>" data-direction="vertical">
    <div class="img"></div>
    <div class="inner">
        <div class="message">
            <?=$empty_data_msg?>
        </div>

        <div class="handle">
            <?php if($empty_data_show_button) { ?>
            <a class="btn btn-default" href="#">返回首页</a>
            <a class="btn btn-warning" href="#">Check it out</a>
            <?php } ?>
        </div>
    </div>
</div>