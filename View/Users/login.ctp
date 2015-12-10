<?php

echo $this->element('form-header', array(
    'modelName' => 'User',
    'heading' => __('Login')
));

echo $this->Form->input('username', array('label' => array(
    'class' => 'col-sm-3 control-label', 'text' => __('Username'))));
echo $this->Form->input('password', array('label' => array(
    'class' => 'col-sm-3 control-label', 'text' => __('Password'))));
?>
<div class="form-group">
    <?php echo $this->Form->submit(__('Login'), array(
        'div' => 'col-sm-9 col-sm-offset-3',
        'class' => 'btn btn-default'
    ));
    ?>
</div>
<?php echo $this->Form->end(); ?>
</div>