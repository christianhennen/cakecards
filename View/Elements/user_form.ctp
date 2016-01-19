<?php
if (isset($user) && $user['User']['is_superadmin'] == 1) {
    $is_superadmin = true;
} else {
    $is_superadmin = false;
}
echo $this->Form->input('username', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Username'))));
if (AuthComponent::user('is_superadmin') == 1) {
    echo $this->Form->input('is_superadmin', array('type' => 'checkbox', 'checked' => $is_superadmin, 'label' => false, 'before' => '<label for="UserIsSuperadmin" class="' . DEFAULT_LABEL_OPTIONS['class'] . '">' . __('Is this user a super admin?') . '</label>'));
}