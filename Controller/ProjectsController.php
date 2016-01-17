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
        $this->set('projects', $this->Project->find('all'));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            if ($this->Project->save($this->request->data)) {
                $this->Message->display(__('Project has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Project could not be saved!'), 'danger');
        }
    }

    public function edit($id = null)
    {
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
    }

    public function delete($id)
    {
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
    }

}