<?php
class Project extends AppModel
{
    public $hasMany = array('Text','Card','Recipient','ProjectMembership','MailingOption');
    public $displayField = 'name';
    public $validate = array(
        'description' => array(
            'rule' => 'alphaNumeric',
            'required' => false,
            'allowEmpty' => true,
            'message' => 'Project descriptions may only contain alphanumeric characters.'
        ),
        'name' => array(
            'nameNotBlank' => array(
                'rule' => 'notBlank',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Please provide a project name!'
            ),
            'nameUnique' => array(
                'rule' => 'isUnique',
                'message' => 'A project with this name already exists. Please choose another name.',
                'on' => 'create'
            )
        )
    );
}