<?php

/**
 * @property User $User
 * @property Project $Project
 */
class ProjectMembership extends AppModel
{
    public $belongsTo = array('User','Project');
    public $validate = array(
        'is_admin' => array(
            'rule' => 'boolean'
        )
    );
}