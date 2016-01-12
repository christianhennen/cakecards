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
        } else {
            $this->Auth->allow('logout');
            $admins = $this->User->findAllByIsAdmin('1');
            /* If there is no admin defined (either because the database was upgraded before the admin flag was introduced
             or because setting the admin flag has been forgotten on first start) the first user in the database will be set as admin */
            if (empty($admins)) {
                $user = $this->User->find('first');
                $this->User->read('is_admin', $user['User']['id']);
                $this->User->set('is_admin', '1');
                $this->User->save();
            }
        }
    }

    public function index()
    {
        if (($this->Auth->user('is_admin') == 1)) {
            $this->set('users', $this->User->find('all'));
        } else {
            $this->set('users', array('User' => $this->User->findById($this->Auth->user('id'))));
        }
    }

    public function add()
    {
        if (($this->User->find('count') == 0 || $this->Auth->user('is_admin') == 1)) {
            if ($this->request->is('post')) {
                if ($this->User->save($this->request->data)) {
                    $this->Message->display(__('User has successfully been saved.'), 'success');
                    $this->redirect(array('action' => 'index'));
                }
                $this->Message->display(__('User could not be saved!'), 'danger');
            }
        } else {
            $this->Message->display(__('Only administrators can add other user accounts!'), 'danger');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function edit($id = null)
    {
        if (!$id OR !$this->User->findById($id)) {
            throw new NotFoundException(__('The specified user was not found!'));
        }
        if (($this->Auth->user('is_admin') == 1) || $this->Auth->user('id') == $id) {
            if ($this->request->is(array('post', 'put'))) {
                if ($this->User->save($this->request->data)) {
                    $this->Message->display(__('User has successfully been saved.'), 'success');
                    $this->redirect(array('action' => 'index'));
                }
                $this->Message->display(__('User could not be saved!'), 'danger');
            }
            $this->request->data = $this->User->read(null, $id);
        } else {
            $this->Message->display(__('Only administrators can edit other user accounts!'), 'danger');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function change_password($id = null)
    {
        if (!$id OR !$this->User->findById($id)) {
            throw new NotFoundException(__('The specified user was not found!'));
        }
        if (($this->Auth->user('is_admin') == 1) || $this->Auth->user('id') == $id) {
            if ($this->request->is(array('post', 'put'))) {
                if ($this->User->save($this->request->data)) {
                    $this->Message->display(__('Password has successfully been changed.'), 'success');
                    $this->redirect(array('action' => 'index'));
                }
                $this->Message->display(__('Password could not be changed!'), 'danger');
            }
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        } else {
            $this->Message->display(__("Only administrators can change other user's passwords!"), 'danger');
            $this->redirect(array('action' => 'index'));
        }
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
            if ($this->Auth->user('is_admin') == 1) {
                if ($this->User->delete($id)) {
                    $this->Message->display(__('User has successfully been deleted.'), 'success');
                    $this->redirect(array('action' => 'index'));
                }
                $this->Message->display(__('User could not be deleted.'), 'danger');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Message->display(__('Only administrators can delete other user accounts!'), 'danger');
                $this->redirect(array('action' => 'index'));
            }
        } else {
            throw new MethodNotAllowedException();
        }
    }

    public function login()
    {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirectUrl());
            }
            $this->Message->display(__('Wrong username or password!'), 'danger');
        }
    }

    public function logout()
    {
        $this->redirect($this->Auth->logout());
    }

}