<?php
echo $this->element('form-header', array(
    'modelName' => 'CardType',
    'heading' => __('Edit card type')
));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->element('card_type_form');
echo $this->element('form-footer', array(
    'preview' => true
));
echo $this->element('media_gallery');