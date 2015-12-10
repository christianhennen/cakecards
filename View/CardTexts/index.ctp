<div class="row">
    <div class="btn-toolbar" role="toolbar">
        <? echo $this->Html->link(
            $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-plus'))
            . ' ' . __('New card text'),
            array('action' => 'add'),
            array('class' => 'btn btn-primary', 'escape' => false)
        ); ?>
    </div>
</div>

<?php

$this->assign('title', __('Card texts'));
$currentSectionTitle = '';

foreach ($cardtexts as $cardtext):

    $currentCardType = $cardtext['CardType']['description'];
    if ($currentCardType != $currentSectionTitle) {
        $currentSectionTitle = $currentCardType;
        echo "<div class=\"row\" style=\"margin-top: 20px; margin-bottom:10px;\"><div class=\"col-sm-12 col-xs-12\"><a name=\"section" . $currentSectionTitle . "\">" . $currentSectionTitle . "</a></div></div>";
    }

    echo "<div class=\"row\" style=\"margin-bottom:20px\">
   <div class=\"col-sm-1 col-xs-2\">";
    echo $this->Html->link(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-pencil')),
        array('action' => 'edit', $cardtext['CardText']['id']),
        array('class' => 'btn btn-default', 'escape' => false)
    );
    echo "</div>
   <div class=\"col-sm-1 col-sm-push-6 col-xs-10\">";
    echo $this->Form->postLink(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')),
        array('action' => 'delete', $cardtext['CardText']['id']),
        array('class' => 'btn btn-danger', 'escape' => false),
        __('Do you really want to delete this card text?')
    );
    echo "
   </div>
   <div class=\"col-sm-6 col-sm-pull-1 col-xs-12\"><p>" . $cardtext['CardText']['text'] . "</p></div>
 </div>";
    ?>
<?php endforeach; ?>
<?php unset($cardtext); ?>

