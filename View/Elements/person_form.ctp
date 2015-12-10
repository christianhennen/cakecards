<?php
echo $this->Form->input('prename', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Prename'))));
echo $this->Form->input('surname', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Surname'))));
echo $this->Form->input('salutation', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Salutation'))));
echo $this->Form->input('email', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('E-mail address'))));
echo $this->Form->input('card_text_id', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Text number (see below)'))));