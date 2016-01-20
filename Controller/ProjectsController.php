<?php

/**
 * @property Project $Project
 * @property mixed Message
 * @property mixed Permission
 */
class ProjectsController extends AppController
{
    public function index()
    {
        if($this->Permission->superAdmin()) {
            $this->set('projects', $this->Project->find('all'));
        } else {
            $this->Message->display(__('Only super administrators can view projects!'), 'danger');
            $this->redirect(array('controller' => 'recipients', 'action' => 'index'));
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