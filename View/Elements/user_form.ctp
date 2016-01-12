<?php
echo $this->Form->input('username', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Username'))));
if (AuthComponent::user('is_admin') == 1) {
    echo $this->Form->input('is_admin', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Is this an admin account?'))));
}