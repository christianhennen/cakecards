<?php

/**
 * @property Project $Project
 * @property mixed Message
 * @property mixed Permission
 * @property mixed User
 */
class ProjectsController extends AppController
{
    public function index()
    {
        if($this->Permission->superAdmin()) {
            $this->set('projects', $this->Project->find('all'));
            $this->set('superadmin', true);
        } else {
            $this->Project->Behaviors->load('Containable');
            $projects = $this->Project->find('all', array(
                'contain' => array(
                    'ProjectMembership' => array(
                        'conditions' => array('ProjectMembership.user_id' => $this->Auth->user('id'))))));
            $this->set('projects',$projects);
            $this->set('superadmin', false);
        }
    }

    public function add()
    {
        if ($this->Permission->superAdmin()) {
            if ($this->request->is('post')) {
                if ($this->Project->save($this->request->data)) {
                    $this->Message->display(__('Project has successfully been saved.'), 'success');
                    $this->redirect(array('action' => 'index'));
                }
                $this->Message->display(__('Project could not be saved!'), 'danger');
            }
        } else {
            $this->Message->display(__('Only super administrators can add projects!'), 'danger');
            $this->redirect(array('controller' => 'recipients', 'action' => 'index'));
        }
    }

    public function edit($id = null)
    {
        if($this->Permission->superAdmin()) {
            if (!$id OR !$project = $this->Project->findById($id)) {
                throw new NotFoundException(__('The specified Project was not found!'));
            }
            if ($this->request->is(array('post', 'put'))) {
                if ($this->Project->save($this->request->data)) {
                    $this->Message->display(__('Project has successfully been saved.'), 'success');
                    $this->redirect(array('action' => 'index'));
                }
                $this->Message->display(__('Project could not be saved!'), 'danger');
            }
            $this->request->data = $project;
        } else {
                $this->Message->display(__('Only super administrators can edit projects!'), 'danger');
                $this->redirect(array('controller' => 'recipients', 'action' => 'index'));
            }
    }

    public function setActive($id = null)
    {
        if (!$id OR !$project = $this->Project->findById($id)) {
            throw new NotFoundException(__('The specified project was not found!'));
        }
        $this->loadModel('User');
        $currentUser = $this->User->findById($this->Auth->user('id'));
        $currentUser[$this->User->alias]['project_id'] = $id;
        unset($currentUser[$this->User->alias]['password']);
        if ($this->User->save($currentUser)) {
            $this->Message->display(__('Project has successfully been switched.'), 'success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Message->display(__('Project could not be switched!'), 'danger');
        $this->redirect(array('action' => 'index'));
    }

    public function delete($id)
    {
        if($this->Permission->superAdmin()) {
            if (!$id OR !$project = $this->Project->findById($id)) {
                throw new NotFoundException(__('The specified Project was not found!'));
            }
            if ($this->request->is('get')) {
                throw new MethodNotAllowedException();
            }
            if ($this->Project->delete($id)) {
                $this->Message->display(__('Project has successfully been deleted.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
        } else {
            $this->Message->display(__('Only super administrators can delete projects!'), 'danger');
            $this->redirect(array('controller' => 'recipients', 'action' => 'index'));
        }
    }

}