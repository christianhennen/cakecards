<?php

/**
 * @property Text $Text
 * @property Card $Card
 * @property Project $Project
 */
class Recipient extends AppModel
{
    public $actsAs = array('ProjectRelated','CardCreator');
    public $belongsTo = array('Text','Card','Project');
    public $validate = array(
        'prename' => array(
            'rule' => 'notBlank',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please provide a valid prename!'
        ),
        'surname' => array(
            'rule' => 'notBlank',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please provide a valid surname!'
        ),
        'salutation' => array(
            'rule' => 'notBlank',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please provide a salutation for this recipient!'
        ),
        'email' => array(
            /*'emailUnique' => array(
                'rule' => array('isUnique', array('email','prename', 'surname' , 'project_id'), false),
                'message' => 'This recipient already exists. It doesn\'t need to be added.',
                'on' => 'create'
            ),*/
            'email' => array(
                'rule' => 'email',
                'required' => true,
                'allowEmpty' => false,
                'message' => 'Please provide a valid e-mail address!'
            )
        )
    );
}