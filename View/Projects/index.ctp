<?php
if($superadmin) {
    echo '<div class="row">
    <div class="btn-toolbar" role="toolbar">' .
        $this->Html->link(
            $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-plus'))
            . ' ' . __('New project'),
            array('action' => 'add'),
            array('class' => 'btn btn-primary', 'escape' => false)
        ) .
        '</div>
</div>';
}
$this->assign('title', __('Projects'));

echo "<div class=\"row\" style=\"margin-bottom:20px\">
    <div class=\"col-sm-2 col-sm-push-6 col-xs-12\"><h4>" . __('Actions') . "</h4></div>
   <div class=\"col-sm-2 col-sm-pull-2 col-xs-12\"><h4>" . __('Name') . "</h4></div>
   <div class=\"col-sm-4 col-sm-pull-2 col-xs-12\"><h4>" . __('Description') . "</h4></div>
 </div>";

foreach ($projects as $project):
    echo "<div class=\"row\" style=\"margin-bottom:20px\">
   <div class=\"col-sm-2 col-sm-push-6 col-xs-12 btn-group\">";
    echo $this->Html->link(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-share')),
        array('action' => 'setActive', $project['Project']['id']),
        array('class' => 'btn btn-default', 'escape' => false)
    );
    if($project['ProjectMembership'][0]['is_admin'] || $superadmin) {
    echo $this->Html->link(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-pencil')),
        array('action' => 'edit', $project['Project']['id']),
        array('class' => 'btn btn-default', 'escape' => false)
    );
    }
    if($superadmin) {
    echo $this->Form->postLink(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')),
        array('action' => 'delete', $project['Project']['id']),
        array('class' => 'btn btn-danger', 'escape' => false),
        __('Do you really want to delete this project?')
    );
    }
    echo "
   </div>
   <div class=\"col-sm-2 col-sm-pull-2 col-xs-12\"><p>" . $project['Project']['name'] . "</p></div>
   <div class=\"col-sm-4 col-sm-pull-2 col-xs-12\"><p>" . $project['Project']['description'] . "</p></div>
 </div>";
    ?>
<?php endforeach; ?>
<?php unset($project); ?>

