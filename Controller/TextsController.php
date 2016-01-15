<?php

/**
 * @property Text $Text
 * @property mixed Message
 * @property mixed Permission
 */
class TextsController extends AppController
{

    public $helpers = array('Html', 'Form');
    public $components = array('Message','Permission');

    public function index()
    {
        $this->set('texts', $this->Text->findAllByProjectId($this->Permission->pid()));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $this->request->data[$this->Text->alias]['project_id'] = $this->Permission->pid();
            if ($this->Text->save($this->request->data)) {
                $this->Message->display(__('Card text has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Card text could not be saved!'), 'danger');
        }
    }

    public function edit($id = null)
    {
        if (!$id OR !$text = $this->Text->findById($id) OR $text[$this->Text->alias]['project_id'] != $this->Permission->pid()) {
            throw new NotFoundException(__('The specified card text was not found!'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Text->save($this->request->data)) {
                $this->Message->display(__('Card text has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Card text could not be saved!'), 'danger');
        }
        $this->request->data = $text;
    }

    public function delete($id)
    {
        if (!$id OR !$text = $this->Text->findById($id) OR $text[$this->Text->alias]['project_id'] != $this->Permission->pid()) {
            throw new NotFoundException(__('The specified card text was not found!'));
        }
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Text->delete($id)) {
            $this->Message->display(__('Card text has successfully been deleted.'), 'success');
            $this->redirect(array('action' => 'index'));
        }
    }

}