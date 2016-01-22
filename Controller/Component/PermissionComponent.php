<?php
App::uses('Component','Controller');

/**
 * @property mixed Auth
 * @property mixed ProjectMembership
 */
class PermissionComponent extends Component {

    public $components = array('Auth');

    public function pid()
    {
        return $this->Auth->user('project_id');
    }

    public function admin($pid) {
        if(!$pid) {
            $pid = $this->pid();
        }
        if($this->Auth->user('id')) {
            $model = ClassRegistry::init('ProjectMembership');
            $pm = $model->findByUserIdAndProjectId($this->Auth->user('id'), $pid);
            if (isset($pm['ProjectMembership']) && $pm['ProjectMembership']['is_admin'] == 1) return true;
            else return false;
        }
        else return false;
    }

    public function superAdmin()
    {
        if ($this->Auth->user('is_superadmin') == 1) return true;
        else return false;
    }


}