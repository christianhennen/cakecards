<?php

class Upload extends AppModel {
    public function afterSave($created, $options = array()) {
        if($this->data['Upload']['type'] == 'font' && $created) {

        }
    }
}
?>