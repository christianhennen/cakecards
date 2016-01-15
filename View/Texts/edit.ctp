<?php
echo $this->element('form_header', array(
    'modelName' => 'Text',
    'heading' => __('Edit card text')
));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->element('text_form');
echo $this->element('form_footer');