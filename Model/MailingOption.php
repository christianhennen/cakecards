<?php

/**
 * @property Upload $Upload
 * @property Project $Project
 * @property User $User
 */
class MailingOption extends AppModel
{
    public $belongsTo = array('User','Project','Upload');
    public $actsAs = array('ProjectRelated');
    public $validate = array(
        'description' => array(
            'rule' => 'notBlank',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please provide a description!'
        ),
        'server' => array(
            'rule' => array('custom','/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/'),
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please provide a valid server address!'
        ),
        'port' => array(
            'rule' => 'naturalNumber',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please provide a valid port number!'
        ),
        'timeout' => array(
            'rule' => array('naturalNumber',true),
            'required' => false,
            'allowEmpty' => true,
            'message' => 'Please provide a valid timeout value!'
        ),
        'from_address' => array(
            'rule' => 'email',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please provide a valid email address!'
        ),
        'from_name' => array(
            'rule' => 'notBlank',
            'required' => false,
            'allowEmpty' => true,
            'message' => 'Please provide a valid sender name!'
        ),
        'username' => array(
            'rule' => 'notBlank',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please provide a username!'
        ),
        'password' => array(
            'rule' => 'notBlank',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please provide a pasword!'
        ),
        'subject' => array(
            'rule' => 'notBlank',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please provide a subject!'
        )
    );
}