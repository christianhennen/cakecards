<?php
echo $this->element('form_header', array(
    'modelName' => 'Card',
    'heading' => __('Add card type')
));
echo $this->element('card_form');
echo $this->element('form_footer', array(
    'preview' => true
));
echo $this->element('media_gallery');