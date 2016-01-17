<?php
echo $this->element('form_header', array(
    'modelName' => 'Project',
    'heading' => __('Edit project')
));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->element('project_form');
echo $this->element('form_footer');