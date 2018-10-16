<?php
if ($show_announcement) { ?>

<div class="alert alert-define alert-info" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?=$show_announcement?>
</div>

<script type="text/javascript">
    $().alert()
</script>

<?php } ?>