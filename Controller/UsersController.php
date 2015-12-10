<?php

/**
 * @property User $User
 * @property mixed Message
 */
class UsersController extends AppController
{

    public $components = array('Message');

    public function beforeFilter()
    {
        parent::beforeFilter();
        if ($this->User->find('count') == 0) {
            $this->Auth->allow('logout', 'add');
        } else
            $this->Auth->allow('logout');
    }

    public function index()
    {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function add()
    {
        if ($this->request->is('post')) {
            if ($this->User->save($this->request->data)) {
                $this->Message->display(__('User has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('User could not be saved!'), 'danger');
        }
    }

    public function edit($id = null)
    {
        if (!$id OR !$this->User->findById($id)) {
            throw new NotFoundException(__('The specified user was not found!'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->User->save($this->request->data)) {
                $this->Message->display(__('User has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('User could not be saved!'), 'danger');
        }
        $this->request->data = $this->User->read(null, $id);
        unset($this->request->data['User']['password']);
    }

    public function delete($id = null)
    {
        if ($this->request->is('post')) {
            if (!$id OR !$this->User->findById($id)) {
                throw new NotFoundException(__('The specified user was not found!'));
            }
            if ($this->Auth->user('id') == $id) {
                $this->Message->display(__('You can\'t delete your own user account!'), 'danger');
                $this->redirect(array('action' => 'index'));
            }
            if ($this->User->delete($id)) {
                $this->Message->display(__('User has successfully been deleted.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('User could not be deleted.'), 'danger');
            $this->redirect(array('action' => 'index'));
        } else {
            throw new MethodNotAllowedException();
        }
    }

    public function login()
    {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect(array('controller' => 'people', 'action' => 'index'));
            }
            $this->Message->display(__('Wrong username or password!'), 'danger');
        }
    }

    public function logout()
    {
        $this->redirect($this->Auth->logout());
    }

}