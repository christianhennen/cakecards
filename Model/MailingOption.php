<?php

/**
 * @property Upload $Upload
 * @property Project $Project
 * @property User $User
 */
class MailingOption extends AppModel
{
    public $belongsTo = array('User','Project','Upload');
}