<?php
echo $this->element('form_header', array(
    'modelName' => 'Project',
    'heading' => __('Add project')
));
echo $this->element('project_form');
echo $this->element('form_footer');