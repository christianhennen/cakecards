<?php
echo $this->element('form_header', array(
    'modelName' => 'Recipient',
    'heading' => __('Edit a recipient')
));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->element('recipient_form');
echo $this->element('form_footer');