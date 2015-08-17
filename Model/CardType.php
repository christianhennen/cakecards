<?php
/**
 *@property Upload $Image
 *@property Upload $Font
 */

class CardType extends AppModel {
    public $actsAs = array('CardCreator');
    public $hasMany = array('CardText','Option');
    public $belongsTo = array(
        'Font' => array(
            'className' => 'Upload',
            'foreignKey' => 'font_upload_id'
        ),
        'Image' => array(
            'className' => 'Upload',
            'foreignKey' => 'image_upload_id'
        )
    );
    public $displayField = 'description';
    public $validate = array(
        'description' => array(
            'rule'       => 'notEmpty',
            'required'   => true,
            'allowEmpty' => false,
            'message'    => 'Please provide a name for this card type!'
        ),
        'font_size' => array(
            'rule'       => 'numeric',
            'required'   => true,
            'allowEmpty' => false,
            'message'    => 'Please provide a valid number!'
        ),
        'x_position' => array(
            'rule'       => 'numeric',
            'required'   => true,
            'allowEmpty' => false,
            'message'    => 'Please provide a valid number!'
        ),
        'y_position' => array(
            'rule'       => 'numeric',
            'required'   => true,
            'allowEmpty' => false,
            'message'    => 'Please provide a valid number!'
        ),
        'font_color_hex' => array(
            'rule'       => 'notEmpty',
            'required'   => true,
            'allowEmpty' => false,
            'message'    => 'Please provide a valid color!'
        ),
        'font_color_rgb' => array(
            'rule'       => 'notEmpty',
            'required'   => true,
            'allowEmpty' => false,
            'message'    => 'Please provide a valid color!'
        ),
        'rotation' => array(
            'rule'       => 'numeric',
            'required'   => true,
            'allowEmpty' => false,
            'message'    => 'Please provide a valid number!'
        )
    );
}
?>