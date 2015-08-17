<?
$otherButtons = $this->Html->link(__('Cancel'), array('action' => 'index'), array('class' => 'btn btn-danger', 'style' => 'margin-left:10px;'));
if (isset($preview)) {
    $otherButtons .= $this->Html->div('btn btn-primary', __('Preview'),array('id' => 'previewButton','style' => 'margin-left:10px;'));
}
?>

<div class="form-group">
    <?php echo $this->Form->submit(__('Save'), array(
        'div' => 'col-sm-9 col-sm-offset-3',
        'class' => 'btn btn-default',
        'after' => $otherButtons)
    );
    ?>
</div>
<?php echo $this->Form->end(); ?>
</div>
