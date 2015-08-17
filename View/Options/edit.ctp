<?php

echo $this->element('form-header', array(
    'modelName' => 'Option',
    'heading' => __('Edit mailing options')
));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->element('option_form');
echo $this->element('form-footer');
echo $this->element('media_gallery');

?>
