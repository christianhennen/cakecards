<?php

if($superadmin OR $admin) {
    echo '<div class="row">
    <div class="btn-toolbar" role="toolbar">'
        . $this->Html->link(
            $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-plus'))
            . ' ' . __('New user'),
            array('action' => 'add'),
            array('class' => 'btn btn-primary', 'escape' => false)
        ) .
    '</div>
</div>';
}

$this->assign('title', __('Users'));

echo "<div class=\"row\" style=\"margin-bottom:10px;\">
   <div class=\"col-sm-1 col-xs-2\"><h4>" . __('Role') . "</h4></div>
   <div class=\"col-sm-2 col-xs-4\"><h4>" . __('Username') . "</h4></div>
   <div class=\"col-sm-4 col-xs-6\"><h4>" . __('Info') . "</h4></div>
   <div class=\"col-sm-5 col-xs-12\"><h4>" . __('Actions') . "</h4></div>
   </div>";

foreach ($users as $user):
    if($user['ProjectMembership'] || $superadmin):
    $role = __('User');
    foreach ($user['ProjectMembership'] as $pm) {
        if($pm['id'] == AuthComponent::user('project_id')) {
            if($pm['is_admin']) $role = __('Admin');
            else $role = __('User');
        }
    }
    if ($user['User']['is_superadmin'] == 1) $role = __('Superadmin');
    echo "<div class=\"row\" style=\"margin-bottom:10px;\">
   <div class=\"col-sm-1 col-xs-2\"><p>" . $role . "</p></div>
   <div class=\"col-sm-2 col-xs-4\"><p>" . $user['User']['username'] . "</p></div>
   <div class=\"col-sm-4 col-xs-6\"><p>" . $user['User']['info'] . "</p></div>
   <div class=\"btn-group col-sm-5 col-xs-12\">";
    echo $this->Html->link(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-pencil'))
        . '<span class=\"hidden-xs\"> ' . __('Edit') . '</span>',
        array('action' => 'edit', $user['User']['id']),
        array('class' => 'btn btn-default', 'escape' => false)
    );
    echo $this->Html->link(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-lock'))
        . '<span class=\"hidden-xs\"> ' . __('Change password') . '</span>',
        array('action' => 'change_password', $user['User']['id']),
        array('class' => 'btn btn-default', 'escape' => false)
    );
    if ($user['User']['id'] != AuthComponent::user('id')) {
        echo $this->Form->postLink(
            $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')) . "<span class=\"hidden-xs\"> " . __('Delete') . "</span>",
            array('action' => 'delete', $user['User']['id']),
            array('class' => 'btn btn-danger', 'escape' => false),
            __('Do you really want to delete this user?')
        );
    }
    echo "
   </div>
 </div>";
    ?>
<?php endif;
endforeach; ?>
<?php unset($user); ?>
