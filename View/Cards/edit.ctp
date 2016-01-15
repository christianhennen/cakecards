<?php
echo $this->element('form_header', array(
    'modelName' => 'Card',
    'heading' => __('Edit card type')
));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->element('card_form');
echo $this->element('form_footer', array(
    'preview' => true
));
echo $this->element('media_gallery');