<?php
echo $this->element('form-header', array(
    'modelName' => 'User',
    'heading' => __('Add a user')
));
echo $this->element('user_form');
echo $this->Form->input('password', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Password'))));
echo $this->Form->input('password2', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Re-enter Password'))));
echo $this->element('form-footer');