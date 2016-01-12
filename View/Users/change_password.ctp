<?php
echo $this->element('form-header', array(
    'modelName' => 'User',
    'heading' => __('Change password')
));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->element('user_passwords');
echo $this->element('form-footer');