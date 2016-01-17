<?php

/**
 * @property Recipient $Recipient
 * @property Project $Project
 */
class Text extends AppModel
{
    public $actsAs = array('ProjectRelated','CardCreator');
    public $belongsTo = 'Project';
    public $hasMany = 'Recipient';
    public $displayField = 'name';
    public $validate = array(
        'text' => array(
            'rule' => 'notBlank',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please enter a text!'
        ),
        'name' => array(
            'nameNotBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Name cannot be empty!'
            ),
            'nameUnique' => array(
                'rule' => 'isUnique',
                'message' => 'A card text with this name already exists. Please choose another name.',
                'on' => 'create'
            )
        )
    );
}