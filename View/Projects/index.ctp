<div class="row">
    <div class="btn-toolbar" role="toolbar">
        <?php echo $this->Html->link(
            $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-plus'))
            . ' ' . __('New project'),
            array('action' => 'add'),
            array('class' => 'btn btn-primary', 'escape' => false)
        ); ?>
    </div>
</div>

<?php

$this->assign('title', __('Projects'));

foreach ($projects as $project):

    echo "<div class=\"row\" style=\"margin-bottom:20px\">
   <div class=\"col-sm-1 col-xs-2\">";
    echo $this->Html->link(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-pencil')),
        array('action' => 'edit', $project['Project']['id']),
        array('class' => 'btn btn-default', 'escape' => false)
    );
    echo "</div>
   <div class=\"col-sm-1 col-sm-push-6 col-xs-10\">";
    echo $this->Form->postLink(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')),
        array('action' => 'delete', $project['Project']['id']),
        array('class' => 'btn btn-danger', 'escape' => false),
        __('Do you really want to delete this project?')
    );
    echo "
   </div>
   <div class=\"col-sm-2 col-sm-pull-1 col-xs-12\"><p>" . $project['Project']['name'] . "</p></div>
   <div class=\"col-sm-4 col-sm-pull-1 col-xs-12\"><p>" . $project['Project']['description'] . "</p></div>
 </div>";
    ?>
<?php endforeach; ?>
<?php unset($project); ?>

