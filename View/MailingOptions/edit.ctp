<?php
echo $this->element('form_header', array(
    'modelName' => 'MailingOption',
    'heading' => __('Edit mailing options')
));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->element('mailing_option_form');
echo $this->element('form_footer');
echo $this->element('media_gallery');