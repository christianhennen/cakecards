<?php
echo $this->element('form-header', array(
    'modelName' => 'User',
    'heading' => __('Add a user')
));
echo $this->element('user_form');
echo $this->element('user_passwords');
echo $this->element('form-footer');