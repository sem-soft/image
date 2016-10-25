<?php

/**
 * Image resizer class
 */

namespace Sem\Image;

/**
 * @author Samsonov Vladimir <samsonov.sem@gmail.com>
 * @version 1.0.0
 */
class Imager
{
    
    /**
     * @var resource image resource
     */
    private $image;
    
    /**
     * Loads as image for proccessing
     * 
     * @param string $filename file to load
     */
    public function load($filename)
    {
        
        $info = getimagesize($filename);
        
        // See at loaded image type
        switch ($info[2]) {
            case IMAGETYPE_JPEG:
                $this->image = imagecreatefromjpeg($filename);;
                break;
            case IMAGETYPE_GIF:
                $this->image = imagecreatefromgif($filename);
                break;
            case IMAGETYPE_PNG:
                $this->image = imagecreatefrompng($filename);
        }
    }
    
    /**
     * Saves loaded image to file with optional image type, compression and permissions
     * 
     * @param string $filename name of the name image
     * @param int $type type of the new image
     * @param float $compression
     * @param int|null $permissions
     */
    public function save($filename, $type = IMAGETYPE_JPEG, $compression = 75, $permissions = null)
    {
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($this->image, $filename, $compression);
                break;
            case IMAGETYPE_GIF:
                imagegif($this->image, $filename, $compression);
                break;
            case IMAGETYPE_PNG:
                imagegif($this->image, $filename, $compression);
                break;
        }
        
        if ($permissions != null) {
           chmod($filename, $permissions);
        }
    }
    
    /**
     * Outputs procceded image to php I/O
     * 
     * @param int $type type of the new image
     * @param float $compression
     */
    public function output($type = IMAGETYPE_JPEG, $compression = 75)
    {
        $this->save(null, $type, $compression);
    }
    
    /**
     * Returns image incoded in base64
     * 
     * @param int $type type of the new image
     * @param float $compression
     * @return string
     */
    public function base64($type = IMAGETYPE_JPEG, $compression = 75)
    {
        ob_start();
        $this->output($type, $compression);
        $binaryImage = ob_get_clean();

        switch ($type) {
            case IMAGETYPE_JPEG:
                $filetype = 'jpg';
                break;
            case IMAGETYPE_GIF:
                $filetype = 'gif';
                break;
            case IMAGETYPE_PNG:
                $filetype = 'png';
                break;
        }
        
        return 'data:image/'.$filetype.';base64,'.base64_encode($binaryImage);
    }
    /**
     * Returns loaded image width
     * 
     * @return int
     */
    protected function getWidth()
    {
        return imagesx($this->image);
    }
    
    /**
     * Returns loaded image height
     * 
     * @return int
     */
    protected function getHeight()
    {
        return imagesy($this->image);
    }
    
    /**
     * Resize image based on it height changes with aspect ratio
     * 
     * @param int $height
     */
    public function resizeToHeight($height)
    {
       $ratio = $height / $this->getHeight();
       $width = $this->getWidth() * $ratio;
       
       $this->resize($width,$height);
    }
    
    /**
     * Resize image based on it width changes with aspect ratio
     * 
     * @param int $width
     */
    public function resizeToWidth($width)
    {
       $ratio = $width / $this->getWidth();
       $height = $this->getheight() * $ratio;
       
       $this->resize($width,$height);
    }
    
    /**
     * Sets the scale in percent to loaded image
     * 
     * @param integer $scale
     */
    public function scale($scale)
    {
       $width = $this->getWidth() * $scale / 100;
       $height = $this->getheight() * $scale / 100;
       
       $this->resize($width,$height);
    }
    
    /**
     * Resize image by width and height
     * 
     * @param int $width
     * @param int $height
     */
    public function resize($width, $height)
    {
       $newImage = imagecreatetruecolor($width, $height);
       imagecopyresampled($newImage, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
       $this->image = $newImage;
    }
}