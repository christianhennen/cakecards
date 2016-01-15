<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

/**
 * @property MailingOption $MailingOption
 */

class User extends AppModel
{
    public $hasMany = array('ProjectMembership', 'MailingOption');
    public $belongsTo = array('MailingOption', 'Project');
    public $validate = array(
        'username' => array(
            'usernameNotBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Username cannot be empty!'
            ),
            'usernameUnique' => array(
                'rule' => 'isUnique',
                'message' => 'A user with this name already exists. Please choose another name.'
            )
        ),
        'is_superadmin' => array(
            'rule' => 'boolean'
        ),
        'testmode_active' => array(
            'rule' => 'boolean'
        )
    );

    public function beforeSave($options = array())
    {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }
}