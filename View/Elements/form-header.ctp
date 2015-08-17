<div class="row center-block">
    <div class="col-sm-9">
<?php

const DEFAULT_LABEL_OPTIONS = array('class' => 'col-sm-3 control-label');

$this->assign('title', $heading);
echo "<h1>".$heading."</h1>";

echo $this->Form->create($modelName, array(
    'type' => 'file',
    'inputDefaults' => array(
        'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
        'div' => 'form-group',
        'label' => DEFAULT_LABEL_OPTIONS,
        'between' => '<div class="col-sm-6">',
        'after' => '</div>',
        'class' => 'form-control'
    ),
    'class' => 'well form-horizontal'
)); ?>