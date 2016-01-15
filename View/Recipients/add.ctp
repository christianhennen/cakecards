<?php
echo $this->element('form_header', array(
    'modelName' => 'Recipient',
    'heading' => __('Add a recipient')
));
echo $this->element('recipient_form');
echo $this->element('form_footer');