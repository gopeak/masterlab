<?php
if ($G_show_announcement[0]) { ?>
<script src="<?=ROOT_URL?>dev/vendor/jquery.cookie.js"></script>
<div class="alert alert-define alert-info" role="alert" id="my-announcement">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?=$G_show_announcement[1]?>
</div>

<script type="text/javascript">
    //$().alert()
    $('#my-announcement').on('closed.bs.alert', function () {
        $.removeCookie('announcement');
        // 14天后过期
        $.cookie('announcement', <?=$G_show_announcement[2]?>, { expires: 14, path: '/'});
    })

</script>

<?php } ?>