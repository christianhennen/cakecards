<?php

/**
 * @property Upload $Image
 * @property Upload $Font
 * @property Project $Project
 */

class Card extends AppModel {
    public $actsAs = array('ProjectRelated');
    public $hasMany = 'Recipient';
    public $belongsTo = array(
        'Font' => array(
            'className' => 'Upload',
            'foreignKey' => 'font_upload_id'
        ),
        'Image' => array(
            'className' => 'Upload',
            'foreignKey' => 'image_upload_id'
        ),
        'Project'
    );
    public $displayField = 'description';
    public $validate = array(
        'description' => array(
            'descNotBlank' => array(
                'rule'       => 'notBlank',
                'required'   => true,
                'allowEmpty' => false,
                'message'    => 'Please provide a name for this card type!'
            ),
            'descUnique' => array(
                'rule' => array('isUnique', array('project_id', 'description'), false),
                'message' => 'A card with that description already exists for the current project. Please choose another description.',
                'on' => 'create'
            )
        ),
        'image_upload_id' => array(
            'rule' => array('isUnique', array('project_id', 'image_upload_id', 'font_upload_id'), false),
            'message' => 'A card with that image and font already exists for the current project. Please choose another image and/or font.'
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