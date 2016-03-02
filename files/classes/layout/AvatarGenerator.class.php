<?php
class AvatarGenerator {
    private $key;
    /**
     * @param String $key klíč pro generování obrázku
    **/
    public function __construct($key){
        $this->key = $key;
    }
    
    public function render(){
        $image = imagecreatetruecolor(105,135);
        imagesavealpha( $image, true );
        $trans_background=imagecolorallocatealpha($image, 0, 0, 0, 127);
        imagefill($image, 0, 0, $trans_background);
        $klic = md5($this->key);
        $values = str_split($klic, 2);
        foreach($values as $value)
            $value = hexdec($value);
        //////////////////////////////////////////////
        ImageColorAllocate ($image, 255,255,255);
        //body
        $x = $this->getRandomPieceNumber($values[0],AVATAR_BASE_COUNT);
        $overlayImage = imagecreatefrompng(WEB_ROOT . '/graphics/avatars/images/m-base-'.$x.'.png');
        imagecopy($image, $overlayImage, 0, 0, 0, 0, 105, 135);
        //eyes
        $x = $this->getRandomPieceNumber($values[1],AVATAR_EYES_COUNT);
        $overlayImage = imagecreatefrompng(WEB_ROOT . '/graphics/avatars/images/m-eyes-'.$x.'.png');
        imagecopy($image, $overlayImage, 0, 0, 0, 0, 105, 135);
        //nose
        $x = $this->getRandomPieceNumber($values[2],AVATAR_NOSE_COUNT);
        $overlayImage = imagecreatefrompng(WEB_ROOT . '/graphics/avatars/images/m-nose-'.$x.'.png');
        imagecopy($image, $overlayImage, 0, 0, 0, 0, 105, 135);
        //lips
        $x = $this->getRandomPieceNumber($values[3],AVATAR_LIPS_COUNT);
        $overlayImage = imagecreatefrompng(WEB_ROOT . '/graphics/avatars/images/m-lips-'.$x.'.png');
        imagecopy($image, $overlayImage, 0, 0, 0, 0, 105, 135);
         //hair
        $x = $this->getRandomPieceNumber($values[4],AVATAR_HAIR_COUNT);
        $overlayImage = imagecreatefrompng(WEB_ROOT . '/graphics/avatars/images/m-hair-'.$x.'.png');
        imagecopy($image, $overlayImage, 0, 0, 0, 0, 105, 135);
        
        header('Content-type: image/png');
        ImagePng ($image);
        ImageDestroy($image);
    }
    
    private function getRandomPieceNumber($seed,$piecesCount){
        $number = ($seed % $piecesCount) + 1;
        return $number;
    }
    
}
