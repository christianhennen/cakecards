<?php
/*
 * @property mixed ProjectMembership
 */
class Project extends AppModel
{
    public $hasMany = array('Text','Card','Recipient','ProjectMembership','MailingOption');
    public $displayField = 'name';
    public $validate = array(
        'description' => array(
            'rule' => 'notBlank',
            'required' => false,
            'allowEmpty' => true,
            'message' => 'Project descriptions may not be blank.'
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

    public function beforeSave($options = array())
    {
        foreach($this->data['User'] as $user) {
            if(key_exists('id',$user['ProjectMembership'][0])) $pm_id = $user['ProjectMembership'][0]['id']; else $pm_id = false;
            if($user['is_member'] == 0 && $pm_id) {
                $this->ProjectMembership->delete($pm_id);
            } elseif ($user['is_member'] == 1) {
                $this->ProjectMembership->save($user['ProjectMembership'][0]);
            }
            $this->ProjectMembership->clear();
        }
        return true;
    }
}