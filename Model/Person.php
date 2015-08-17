<?php
/**
 *@property CardText $CardText
 */

class Person extends AppModel {
    public $actsAs = array('CardCreator');
	public $belongsTo = 'CardText';
	public $validate = array(
    	'prename' => array(
        'rule'       => 'notEmpty',
        'required'   => true,
        'allowEmpty' => false,
        'message'    => 'Please provide a valid prename!'
    	),
    	'surname' => array(
        'rule'       => 'notEmpty',
        'required'   => true,
        'allowEmpty' => false,
        'message'    => 'Please provide a valid surname!'
    	),
    	'salutation' => array(
        'rule'       => 'notEmpty',
        'required'   => true,
        'allowEmpty' => false,
        'message'    => 'Please provide a salutation for this recipient!'
    	),
    	'email' => array(
        'rule'       => 'email',
        'required'   => true,
        'allowEmpty' => false,
        'message'    => 'Please provide a valid e-mail address!'
    	)
	);
}
?>