<?php
echo $this->element('form_header', array(
    'modelName' => 'User',
    'heading' => __('Edit user')
));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->element('user_form');
echo $this->element('form_footer');