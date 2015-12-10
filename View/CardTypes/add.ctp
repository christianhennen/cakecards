<?php
echo $this->element('form-header', array(
    'modelName' => 'CardType',
    'heading' => __('Add card type')
));
echo $this->element('card_type_form');
echo $this->element('form-footer', array(
    'preview' => true
));
echo $this->element('media_gallery');