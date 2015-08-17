<?php

echo $this->element('form-header', array(
	'modelName' => 'Person',
	'heading' => __('Add a recipient')
));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->element('person_form');
echo $this->element('form-footer');
echo $this->element('person_form_footer');

?>