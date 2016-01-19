<div class="row">
    <div class="btn-toolbar" role="toolbar">
        <?php echo $this->Html->link(
            $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-plus'))
            . ' ' . __('New card text'),
            array('action' => 'add'),
            array('class' => 'btn btn-primary', 'escape' => false)
        ); ?>
    </div>
</div>

<?php

$this->assign('title', __('Texts'));

echo "<div class=\"row\" style=\"margin-bottom:20px\">
    <div class=\"col-sm-2 col-sm-push-6 col-xs-12\"><h4>" . __('Actions') . "</h4></div>
   <div class=\"col-sm-2 col-sm-pull-2 col-xs-12\"><h4>" . __('Name') . "</h4></div>
   <div class=\"col-sm-4 col-sm-pull-2 col-xs-12\"><h4>" . __('Text') . "</h4></div>
 </div>";

foreach ($texts as $text):

    echo "<div class=\"row\" style=\"margin-bottom:20px\">
    <div class=\"col-sm-2 col-sm-push-6 col-xs-12 btn-group\">";
    echo $this->Html->link(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-pencil')),
        array('action' => 'edit', $text['Text']['id']),
        array('class' => 'btn btn-default', 'escape' => false)
    );
    echo $this->Form->postLink(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')),
        array('action' => 'delete', $text['Text']['id']),
        array('class' => 'btn btn-danger', 'escape' => false),
        __('Do you really want to delete this card text?')
    );
    echo "
   </div>
   <div class=\"col-sm-2 col-sm-pull-2 col-xs-12\"><p>" . $text['Text']['name'] . "</p></div>
   <div class=\"col-sm-4 col-sm-pull-2 col-xs-12\"><p>" . $text['Text']['text'] . "</p></div>
 </div>";
    ?>
<?php endforeach; ?>
<?php unset($text); ?>

