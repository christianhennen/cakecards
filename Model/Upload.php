<?php

class Upload extends AppModel {
    public function beforeSave($options = array()) {
        if($this->data['Upload']['type'] == 'font') {
            $image = imagecreatefrompng('img/font-preview.png');
            $font_color = ImageColorAllocate($image,0,0,0);
            imagettftext($image, 18, 0, 0,  30, $font_color, "files/".$this->data['Upload']['id']."/".$this->data['Upload']['name'], $this->data['Upload']['name']);
            imagepng($image, "files/".$this->data['Upload']['id']."/preview.png");
        }
    }
}
?>