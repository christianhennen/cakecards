<?php
/**
 *@property CardType $CardType
 */

class CardText extends AppModel {
	public $actsAs = array('CardCreator');
	public $belongsTo = 'CardType';
	public $hasMany = 'Person';
	public $validate = array(
    	'text' => array(
        'rule'       => 'notEmpty',
        'required'   => true,
        'allowEmpty' => false,
        'message'    => 'Please enter a text!'
    	)
	);
}
?>