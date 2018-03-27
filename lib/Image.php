<?php

 

/**
 * Created by PhpStorm.
 * User: cszchen
 * Date: 2016/5/21
 * Time: 16:13
 */

class Image
{
    CONST THUMB_AUTO = 0;
    CONST THUMB_FILL = 1;

    protected $source;

    protected function __construct(){}

    public static function load($source)
    {
        $self = new static();
        if (is_string($source) && file_exists($source)) {
            $self->loadImage($source);
        } elseif(is_resource($source)) {
            $self->source = $source;
        } else {
            throw new \Exception('can not load the resource');
        }
        return $self;
    }

    public static function create($width, $height)
    {
        $self = new static();
        $img = imagecreatetruecolor($width, $height);
        $self->setSource($img);
        return $self;
    }

    public function getSize()
    {
        return [
            imagesx($this->getSource()),
            imagesy($this->getSource())
        ];
    }

    public function crop($x, $y, $width = 0, $height = 0)
    {
        $sourceWidth = imagesx($this->getSource());
        $sourceHeight = imagesy($this->getSource());
        if ($x + $width > $sourceWidth || $x > $sourceWidth) {
            throw new \Exception('The crop width is out of the range');
        }
        if ($y + $height > $sourceHeight || $y > $sourceHeight) {
            throw new \Exception('The crop height is out of the range');
        }
        $width = $width ?: $sourceWidth - $x;
        $height = $height ?: $sourceHeight - $y;
        $rect = [
            'x' => $x,
            'y' => $y,
            'width' => $width,
            'height' => $height
        ];
        $img = imagecrop($this->getSource(), $rect);
        $this->setSource($img);
        return $this;
    }

    /**
     * @param $percent int
     * @return $this
     */
    public function resize($percent)
    {
        if ($percent >= 100 || $percent <= 0) {
            return $this;
        }
        $sourceWidth = imagesx($this->getSource());
        $sourceHeight = imagesy($this->getSource());
        $width = round($sourceWidth * $percent / 100);
        $height = round($sourceHeight * $percent / 100);
        $img = imagecreatetruecolor($width, $height);
        imagecopyresampled($img, $this->getSource(), 0, 0, 0, 0, $width, $height, $sourceWidth, $sourceHeight);
        $this->setSource($img);
        return $this;
    }

    public function thumb($maxWidth, $maxHeight, $mod = self::THUMB_AUTO)
    {
        $sourceWidth = imagesx($this->getSource());
        $sourceHeight = imagesy($this->getSource());
        if ($mod == self::THUMB_FILL) {
            $width = $maxWidth;
            $height = $maxHeight;
        } else {
            if ($sourceWidth <= $maxWidth && $sourceHeight <= $maxHeight) {
                return $this;
            }
            $wRatio = $maxWidth / $sourceWidth;
            $hRatio = $maxHeight / $sourceHeight;
            if ($wRatio * $sourceHeight < $maxHeight) {
                $height = round($wRatio * $sourceHeight);
                $width = $maxWidth;
            } elseif ($hRatio * $sourceWidth < $maxWidth) {
                $width = round($hRatio * $sourceWidth);
                $height = $maxHeight;
            } else {
                return $this;
            }
        }
        $img = imagecreatetruecolor($width, $height);
        imagecopyresampled($img, $this->getSource(), 0, 0, 0, 0, $width, $height, $sourceWidth, $sourceHeight);
        $this->setSource($img);
        return $this;
    }

    public function save($path, $format = 'png')
    {
        switch (strtolower($format)) {
            case 'png':
                imagepng($this->getSource(), $path);
                break;
            case 'jpg':
            case 'jpeg':
                imagejpeg($this->getSource(), $path);
                break;
        }
    }

    public function output($format = 'png')
    {
        ob_end_clean();
        //header('Content-Type:' . $this->size['mime']);
        switch (strtolower($format)) {
            case 'png':
                header('Content-Type:image/png');
                imagepng($this->getSource());
                break;
            case 'jpg':
            case 'jpeg':
                header('Content-Type:image/jpeg');
                imagejpeg($this->getSource());
                break;
        }
    }

    protected function loadImage($file)
    {
        $size = getimagesize($file);
        if ($size == false) {
            throw new \Exception($file . ' is not a image file!');
        }
        $this->source = imagecreatefromstring(file_get_contents($file));
    }

    protected function getSource()
    {
        return $this->source;
    }

    protected function setSource($source)
    {
        $this->clean();
        $this->source = $source;
    }

    protected function clean()
    {
        if ($this->getSource()) {
            imagedestroy($this->getSource());
        }
    }

}
