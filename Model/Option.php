<?php
/**
 *@property Upload $Upload
 *@property CardType $CardType
 */
class Option extends AppModel {
    public $belongsTo = array('CardType','Upload');
    public $validate = array (
        'is_testmode' => array(
            'rule' => array('isUnique', array('card_type_id', 'is_testmode'), false),
            'message' => 'The selected combination of card type and test mode already exists. Please edit the corresponding option set if you want to change any values.'
        )
    );
}
?>