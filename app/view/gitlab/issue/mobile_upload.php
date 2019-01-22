<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Masterlab移动端上传</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="/favicon.ico">
    <meta name="apple-mobile-web-app-capable" content="是">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <link href="/dev/lib/dropzone/min/dropzone.min.css" rel="stylesheet">
    <script src="/dev/lib/dropzone/min/dropzone.min.js"></script>
</head>
<body>

<div class="dropzone" id="myDropzone">
    <div class="am-text-success dz-message">
        点此选择文件
    </div>
</div>

<script type="text/javascript">

    var qr_code = '<?=$qr_token?>';
    var tmp_issue_id = '<?=$tmp_issue_id?>';

    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("#myDropzone", {
        url: "/issue/main/mobileUpload?qr_code="+qr_code+"&tmp_issue_id="+tmp_issue_id,
        addRemoveLinks: true,
        method: 'post',
        filesizeBase: 1024,
        sending: function (file, xhr, formData) {
            formData.append("filesize", file.size);
        },
        success: function (file, response, e) {

            console.log(response);
            //var res = JSON.parse(response);
            if (response.error != '') {
                $(file.previewTemplate).children('.dz-error-mark').css('opacity', '1')
            }
        }
    });
</script>

</body>
</html>



