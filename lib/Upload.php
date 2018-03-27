<?php


class Upload
{
    public $max_size = '1000000';//设置上传文件大小
    public $file_name = 'date';//重命名方式代表以时间命名，其他则使用给予的名称
    public $allow_types;//允许上传的文件扩展名，不同文件类型用“|”隔开
    public $errmsg = '';//错误信息
    public $uploaded = '';//上传后的文件名(包括文件路径)
    public $save_path;//上传文件保存路径
    private $files;//提交的等待上传文件
    private $file_type = array();//文件类型
    private $ext = '';//上传文件扩展名

    /**
     * 构造函数，初始化类
     * @access public
     * @param string $file_name 上传后的文件名
     * @param string $save_path 上传的目标文件夹
     */
    public function __construct()
    {

    }

    /**
     * 判断是否为图片
     * @param unknown $fileNmae
     * @return boolean
     */
    public function isImage( $fileNmae )
    {
        $fileExt = pathinfo( $fileNmae, PATHINFO_EXTENSION );
        return in_array( $fileExt, array('gif', 'jpg', 'jpeg', 'png', 'bmp') ) ? true : false;
    }

    /**
     * 生成一个唯一的32位字符串（类似GUID）
     * @return string
     */
    public function getUniqueId()
    {
        return md5( uniqid( mt_rand(), true ) . microtime() );
    }

    /**
     * 照片另存为
     * @param string $sourceFilename 图片源文件名
     * @param string $destFilename 图片目标文件名
     * @param number $quality 图片质量
     * @return boolean
     * @author 秋士悲
     */
    public function imageSaveAs( $sourceFilename, $destFilename, $quality = 95 )
    {
        if ( !is_file( $sourceFilename ) ) {
            return false;
        }

        $im = imagecreatefromstring( file_get_contents( $sourceFilename ) );
        if ( $im === false ) {
            return false;
        }

        $ext = pathinfo( $sourceFilename, PATHINFO_EXTENSION );
        $ext = strtolower( $ext );

        switch ( $ext ) {
            case 'gif':
                imagegif( $im, $destFilename );
                break;
            case 'jpg':
                imagejpeg( $im, $destFilename, $quality );
                break;
            case 'jpeg':
                imagejpeg( $im, $destFilename, $quality );
                break;
            case 'png':
                imagepng( $im, $destFilename );
                break;
            case 'bmp':
                imagewbmp( $im, $destFilename );
                break;
            default:
                return false;
        }
        imagedestroy( $im );
        return true;
    }

    /**
     * 保存图片资源为文件，文件格式根据文件扩展名而定，quality参数仅用于jpg格式
     * @param resource $im 图片文件资源
     * @param string $fileName 要保存的文件名
     * @param integer $quality 保存质量
     * @return boolean
     * Author: mthorn.net
     */
    public function imageToFile( $im, $fileName, $quality = 95 )
    {
        if ( !$im ) {
            return false;
        }

        $ext = pathinfo( $fileName, PATHINFO_EXTENSION );
        $ext = strtolower( $ext );
        switch ( $ext ) {
            case 'gif':
                imagegif( $im, $fileName );
                break;
            case 'jpg':
                imagejpeg( $im, $fileName, $quality );
                break;
            case 'jpeg':
                imagejpeg( $im, $fileName, $quality );
                break;
            case 'png':
                imagepng( $im, $fileName );
                break;
            case 'bmp':
                imagewbmp( $im, $fileName );
                break;
            default:
                return false;
        }

        return true;
    }

    /**
     * 生成一个比宽或者高都不大于maxSize的缩略图
     * @param string $inputFileName 原图文件路径
     * @param $maxSize 最大尺寸
     * @return 生成缩略图的图片资源句柄
     * Author: mthorn.net
     */
    public function thumbnail( $inputFileName, $maxSize = 100 )
    {
        $info = getimagesize( $inputFileName );

        $type = isset($info['type']) ? $info['type'] : $info[2];

        // 检查服务器是否支持该图片格式
        if ( !(imagetypes() & $type) ) {
            // 服务器不支持文件格式
            return false;
        }
        $width = isset($info['width']) ? $info['width'] : $info[0];
        $height = isset($info['height']) ? $info['height'] : $info[1];

        // 计算宽高比
        $wRatio = $maxSize / $width;
        $hRatio = $maxSize / $height;
        // Using imagecreatefromstring will automatically detect the file type
        $sourceImage = imagecreatefromstring( file_get_contents( $inputFileName ) );

        // Calculate a proportional width and height no larger than the max size.
        if ( ($width <= $maxSize) && ($height <= $maxSize) ) {
            // 原始文件比缩略图尺寸还小，则什么也不做
            return $sourceImage;
        } elseif ( ($wRatio * $height) < $maxSize ) {
            // Image is horizontal
            $tHeight = ceil( $wRatio * $height );
            $tWidth = $maxSize;
        } else {
            // Image is vertical
            $tWidth = ceil( $hRatio * $width );
            $tHeight = $maxSize;
        }
        $thumb = imagecreatetruecolor( $tWidth, $tHeight );

        if ( $sourceImage === false ) {
            return false;
        }
        imagecopyresampled( $thumb, $sourceImage, 0, 0, 0, 0, $tWidth, $tHeight, $width, $height );
        imagedestroy( $sourceImage );

        return $thumb;
    }

    /**
     * 上传图片并生成缩略图
     * @param file $file 上传的图片文件，来自$_FILES
     * @param string $uploadDir 上传路径
     * @param string $filename 要保存为的文件名，不含路径
     * @param array $fileTypesArray 允许的文件类型数组，如array('jpg','JPG')
     * @param array $sizeArray 缩略图尺寸数组，例如array(100,200,300)
     * @param string $thumbPrefix 缩略图前缀
     * @param number $quality 保存质量（仅jpg）
     * @return multitype:boolean string |multitype:boolean string multitype:string
     */
    public function uploadImageAndMakeThumbnail( $file, $uploadDir = '', $filename = '', $fileTypesArray = array(), $sizeArray = array(200), $thumbPrefix = 'thumb_', $quality = 75, $maxFileSize = 0 )
    {
        if ( empty($fileTypesArray) ) {
            $fileTypesArray = array('jpg', 'gif', 'png', 'jpeg', 'bmp');
        }
        if ( $file['error'] != UPLOAD_ERR_OK ) {
            return array(false, '文件上传错误');
        }
        if ( $file['name'] == '' ) {
            return array(false, '文件名为空');
        }
        if ( $maxFileSize > 0 && $file['size'] > $maxFileSize ) {
            return array(false, '文件太大');
        }
        if ( !is_array( $sizeArray ) || empty($sizeArray) ) {
            return array(false, '未给定缩略图尺寸数组');
        }
        //取上传文件的扩展名
        $oldFilename = $file['name'];
        $fileExt = pathinfo( $oldFilename, PATHINFO_EXTENSION );

        //扩展名和文件类型数组全部转为小写
        $fileExt = strtolower( $fileExt );
        foreach ( $fileTypesArray as &$value ) {
            $value = strtolower( $value );
        }
        //检查是否允许的文件类型
        if ( !in_array( $fileExt, $fileTypesArray ) ) {
            return array(false, '不接受文件类型的上传：' . $fileExt);
        }
        if ( empty($filename) ) {
            $filename = $this->getUniqueId() . '.' . $fileExt;
        } elseif ( !stripos( $filename, $fileExt ) ) {
            $filename .= '.' . $fileExt;
        }
        if ( !is_dir( $uploadDir ) ) {
            mkdir( $uploadDir, 0777 );
        }
        $fullPath = $uploadDir . $filename;
        if ( file_exists( $fullPath ) ) {
            return array(false, '文件名已经存在');
        }
        $baseName = pathinfo( $fullPath, PATHINFO_FILENAME );
        if ( move_uploaded_file( $file['tmp_name'], $fullPath ) ) {
            //另存图片，更改图像质量
            if ( $fileExt == 'jpg' || $fileExt == 'jpeg' ) {
                $this->imageSaveAs( $fullPath, $fullPath, $quality );
            }
            //创建缩略图
            $thumbArray = array();
            foreach ( $sizeArray as $size ) {
                $thumbName = $thumbPrefix . $baseName . 'x' . $size . '.' . $fileExt;
                $thumbPath = $uploadDir . $thumbName;
                $im = $this->thumbnail( $fullPath, $size );
                $this->imageToFile( $im, $thumbPath, $quality );
                imagedestroy( $im );
                $thumbArray[$size] = $thumbName;
            }
            return array(true, $filename, $thumbArray);
        } else {
            return array(false, "文件上传失败：$oldFilename");
        }
    }

    /**
     * 上传任意格式文件
     * @param file $file 上传的文件，来自$_FILES
     * @param string $uploadDir 上传路径
     * @param string $filename 要保存为的文件名，不含路径
     * @param array $fileTypesArray 允许的文件类型数组，如array('jpg','JPG')
     * @return multitype:boolean string |multitype:boolean string multitype:string
     */
    public function uploadFile( $file, $uploadDir = '', $filename = '', $fileTypesArray = array(), $maxFileSize = 0 )
    {
        if ( empty($fileTypesArray) ) {
            $file_types_array = array('jpg', 'gif', 'png', 'jpeg', 'mid', 'txt', 'aac', 'amr', 'mp3', 'wav');
        }
        if ( $file['error'] != UPLOAD_ERR_OK ) {
            return array(false, '文件上传错误');
        }
        if ( $file['name'] == '' ) {
            return array(false, '文件名为空');
        }
        if ( $maxFileSize > 0 && $file['size'] > $maxFileSize ) {
            return array(false, '文件太大');
        }
        //取上传文件的扩展名
        $oldFilename = $file['name'];
        $fileExt = $this->getFileExt( $oldFilename );

        //扩展名和文件类型数组全部转为小写
        $fileExt = strtolower( $fileExt );
        foreach ( $fileTypesArray as &$value ) {
            $value = strtolower( $value );
        }
        //检查是否允许的文件类型
        if ( !in_array( $fileExt, $fileTypesArray ) ) {
            return array(false, '不接受文件类型：' . $fileExt);
        }
        if ( empty($filename) ) {
            $filename = $this->getUniqueId() . '.' . $fileExt;
        } elseif ( !stripos( $filename, $fileExt ) ) {
            $filename .= '.' . $fileExt;
        }
        if ( !is_dir( $uploadDir ) ) {
            mkdir( $uploadDir, 0777 );
        }
        $fullPath = $uploadDir . $filename;
        $baseName = pathinfo( $fullPath, PATHINFO_FILENAME );

        try {
            if ( move_uploaded_file( $file['tmp_name'], $fullPath ) ) {
                return array(true, $filename);
            } else {
                return array(false, "文件上传失败：$oldFilename");
            }
        } catch (\Exception $e) {
            return array(false, "文件上传失败：$oldFilename");
        }
    }

    /**
     * 获取文件扩展名.
     * @param $file
     * @return mixed
     */
    public function getFileExt( $file )
    {
        return pathinfo( $file, PATHINFO_EXTENSION );
    }

    /**
     * 移动文件
     * @param unknown $fileUrl
     * @param unknown $aimUrl
     * @param string $overWrite
     * @return boolean
     */
    public function moveFile( $fileUrl, $aimUrl, $overWrite = false )
    {
        if ( !file_exists( $fileUrl ) ) {
            return false;
        }
        if ( file_exists( $aimUrl ) && $overWrite = false ) {
            return false;
        } elseif ( file_exists( $aimUrl ) && $overWrite = true ) {
            unlink( $aimUrl );
        }
        $aimDir = dirname( $aimUrl );
        if ( !file_exists( $aimDir ) ) {
            $result = mkdir( $aimDir, 0777, true );
        }
        rename( $fileUrl, $aimUrl );
        return true;
    }
}
