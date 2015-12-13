<?php

/**
 * @property Upload $Image
 * @property Upload $Font
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
            'rule'       => 'notBlank',
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
        'width' => array(
            'rule'       => 'numeric',
            'required'   => true,
            'allowEmpty' => false,
            'message'    => 'Please provide a valid number!'
        ),
        'height' => array(
            'rule'       => 'numeric',
            'required'   => true,
            'allowEmpty' => false,
            'message'    => 'Please provide a valid number!'
        ),
        'line_height' => array(
            'rule' => array('decimal', 1),
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please provide a valid floating number!'
        ),
        'text_align_horizontal' => array(
            'rule' => 'alphaNumeric',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please select a text alignment value!'
        ),
        'text_align_vertical' => array(
            'rule' => 'alphaNumeric',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Please select a text alignment value!'
        ),
        'font_color_hex' => array(
            'rule'       => 'notBlank',
            'required'   => true,
            'allowEmpty' => false,
            'message'    => 'Please provide a valid color!'
        ),
        'font_color_rgb' => array(
            'rule'       => 'notBlank',
            'required'   => true,
            'allowEmpty' => false,
            'message'    => 'Please provide a valid color!'
        )
    );
}