<?php
echo $this->element('form-header', array(
    'modelName' => 'Option',
    'heading' => __('Add mailing options')
));
echo $this->element('option_form');
echo $this->element('form-footer');
echo $this->element('media_gallery');