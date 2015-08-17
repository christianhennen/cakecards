<?php

echo $this->element('form-header', array(
    'modelName' => 'Upload',
    'heading' => __('Edit upload')
));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->element('upload_form');
echo $this->element('form-footer');

?>
