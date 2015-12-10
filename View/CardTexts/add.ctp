<?php
echo $this->element('form-header', array(
    'modelName' => 'CardText',
    'heading' => __('Add card text')
));
echo $this->element('card_text_form');
echo $this->element('form-footer');