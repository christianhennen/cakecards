<?php
echo $this->Form->input('name', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Name'))));
echo $this->Form->input('description', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Description'))));
if(isset($users)) {
    echo '<div class="form-group">
            <label class="col-sm-3 control-label">'.__('Users').'</label>
            <div class="col-sm-6" style="border-left: 1px solid #cccccc">
            <div class="row" style="padding-left:15px">
                <div class="col-sm-4"><p style="text-align: right; padding-top:7px; font-weight:bold;">'.__('Username').'</p></div>
                <div class="col-sm-4"><p style="text-align: center; padding-top:7px; font-weight:bold;">'.__('Member?').'</p></div>
                <div class="col-sm-4"><p style="text-align: center; padding-top:7px; font-weight:bold;">'.__('Admin?').'</p></div>
            </div>';
    foreach ($users as $id=>$user) {
        if(!empty($user['ProjectMembership'])) $is_member = true; else $is_member = false;
        if ($is_member) {
            $is_admin = $user['ProjectMembership'][0]['is_admin'];
            $pm_id = $user['ProjectMembership'][0]['id'];
        } else {
            $is_admin = false;
            $pm_id = '';
        }
        echo '<div class="row" style="padding-left: 15px">';
        echo $this->Form->hidden('User.'.$id.'.id', array('value' => $user['User']['id']));
        echo '<div class="col-sm-4"><p style="text-align: right">'.$user['User']['username'].'</p></div>';
        echo '<div class="col-sm-4" style="text-align: center;">';
            echo $this->Form->checkbox('User.'.$id.'.is_member', array('type' => 'checkbox', 'checked' => $is_member, 'label' => false));
        echo '</div>';
        echo '<div class="col-sm-4" style="text-align: center;">';
        echo $this->Form->hidden('User.' . $id . '.ProjectMembership.0.id', array('value' => $pm_id));
        echo $this->Form->hidden('User.' . $id . '.ProjectMembership.0.project_id', array('value' => $this->request->data['Project']['id']));
        echo $this->Form->hidden('User.' . $id . '.ProjectMembership.0.user_id', array('value' => $user['User']['id']));
        echo $this->Form->checkbox('User.' . $id .'.ProjectMembership.0.is_admin', array('type' => 'checkbox', 'checked' => $is_admin, 'label' => false));
        echo '</div>';
        echo '</div>';
    }
    echo '</div></div>';
}