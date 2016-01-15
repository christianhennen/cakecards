<?php
echo $this->element('form_header', array(
    'modelName' => 'Text',
    'heading' => __('Add card text')
));
echo $this->element('text_form');
echo $this->element('form_footer');