<?php

/**
 * @property User $User
 * @property mixed Message
 * @property mixed Permission
 * @property mixed ProjectMembership
 */
class UsersController extends AppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
        if ($this->User->find('count') == 0) {
            $this->Auth->allow('logout', 'add');
        } else {
            $this->Auth->allow('logout');
            $superadmins = $this->User->findAllByIsSuperadmin('1');
            /* If there is no admin defined (either because the database was upgraded before the admin flag was introduced
             or because setting the admin flag has been forgotten on first start) the first user in the database will be set as admin */
            if (empty($superadmins)) {
                $user = $this->User->find('first');
                $this->User->read('is_superadmin', $user['User']['id']);
                $this->User->set('is_superadmin', '1');
                $this->User->save();
            }
        }
    }

    public function index()
    {
        $superadmin = $this->Permission->superAdmin();
        $this->set('superadmin', $superadmin);
        $admin = $this->Permission->admin(null);
        $this->set('admin', $admin);
        if ($superadmin) {
            $this->set('users', $this->User->find('all'));
        } elseif ($admin) {
            $this->User->Behaviors->load('Containable');
            $users = $this->User->find('all', array(
                'contain' => array(
                    'ProjectMembership.project_id = "'.$this->Permission->pid().'"')));
            $this->set('users', $users);
        }
        else {
            $this->set('users', array('User' => $this->User->findById($this->Auth->user('id'))));
        }
    }

    public function add()
    {
        if ($this->User->find('count') == 0 || $this->Permission->superAdmin() || $this->Permission->admin(null)) {
            if ($this->request->is('post')) {
                if ($this->request->data['User']['password'] != $this->request->data['User']['passwd']) {
                    $this->Message->display(__('Passwords do not match. Please try again!'), 'danger');
                    $this->redirect(array('action' => 'add'));
                }
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
        if (!$id OR !$user = $this->User->findById($id)) {
            throw new NotFoundException(__('The specified user was not found!'));
        }
        if ($this->Permission->superAdmin() || $this->Permission->admin(null) || $this->Auth->user('id') == $id) {
            if ($this->request->is(array('post', 'put'))) {
                unset($user[$this->User->alias]['password']);
                if ($this->User->save($this->request->data)) {
                    $this->Message->display(__('User has successfully been saved.'), 'success');
                    $this->redirect(array('action' => 'index'));
                }
                $this->Message->display(__('User could not be saved!'), 'danger');
            }
            unset($user[$this->User->alias]['password']);
            $this->request->data = $user;
            $this->set('user', $user);
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
        if ($this->Permission->superAdmin() || $this->Permission->admin(null) || $this->Auth->user('id') == $id) {
            if ($this->request->is(array('post', 'put'))) {
                if ($this->request->data['User']['password'] != $this->request->data['User']['passwd']) {
                    $this->Message->display(__('Passwords do not match. Please try again!'), 'danger');
                    $this->redirect(array('action' => 'change_password', $id));
                }
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
            if ($this->Permission->superAdmin() || $this->Permission->admin(null)) {
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
                $this->redirect(array('controller' => 'recipients', 'action' => 'index'));
            } else {
                $this->Message->display(__('Wrong username or password!'), 'danger');
            }
        }
    }

    public function logout()
    {
        $this->Session->write('Auth.redirect', null);
        $this->redirect($this->Auth->logout());
    }

}