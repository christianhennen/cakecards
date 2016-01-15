<?php
echo $this->element('form_header', array(
    'modelName' => 'MailingOption',
    'heading' => __('Add mailing options')
));
echo $this->element('mailing_option_form');
echo $this->element('form_footer');
echo $this->element('media_gallery');