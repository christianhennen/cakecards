<div class="row">
    <div class="btn-toolbar" role="toolbar">
        <?php echo $this->Html->link(
            $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-plus'))
            . ' ' . __('New user'),
            array('action' => 'add'),
            array('class' => 'btn btn-primary', 'escape' => false)
        ); ?>
    </div>
</div>

<?php

$this->assign('title', __('Users'));

echo "<div class=\"row\" style=\"margin-bottom:10px;\">
   <div class=\"col-sm-3 col-xs-12\"><h4>" . __('Username') . "</h4></div>
   <div class=\"col-sm-6 col-xs-12\"><h4>" . __('Actions') . "</h4></div>
   </div>";

foreach ($users as $user):
    echo "<div class=\"row\" style=\"margin-bottom:10px;\">
   <div class=\"col-sm-3 col-xs-12\"><p>" . $user['User']['username'] . "</p></div>
   <div class=\"btn-group col-sm-6 col-xs-12\">";
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
    echo $this->Form->postLink(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')) . "<span class=\"hidden-xs\"> " . __('Delete') . "</span>",
        array('action' => 'delete', $user['User']['id']),
        array('class' => 'btn btn-danger', 'escape' => false),
        __('Do you really want to delete this user?')
    );
    echo "
   </div>
 </div>";
    ?>
<?php endforeach; ?>
<?php unset($user); ?>
