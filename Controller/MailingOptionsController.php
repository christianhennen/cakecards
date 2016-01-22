<?php

/**
 * @property MailingOption $MailingOption
 * @property mixed Message
 * @property mixed User
 * @property mixed Permission
 */
class MailingOptionsController extends AppController
{

    public function index()
    {
        $this->set('mailing_options', $this->MailingOption->find('all', array('order' => array('MailingOption.project_id' => 'asc'))));
        $this->set('superadmin', $this->Permission->superAdmin());
        $this->set('admin', $this->Permission->admin(null));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            if ($this->MailingOption->save($this->request->data)) {
                $this->Message->display(__('Mailing options have successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Mailing options could not be saved!'), 'danger');
        }
        $this->set('uploads', $this->MailingOption->Upload->findAllByType('signature'));
        $this->set('superadmin', $this->Permission->superAdmin());
        $this->set('admin', $this->Permission->admin(null));
    }

    public function edit($id = null)
    {
        if (!$id OR !$mailing_option = $this->MailingOption->findById($id)) {
            throw new NotFoundException(__('The specified mailing option set was not found!'));
        }
        if ($this->Permission->superAdmin() || $this->Permission->admin(null) || $mailing_option[$this->MailingOption->alias]['user_id'] == $this->Auth->user('id')) {
            if ($this->request->is(array('post', 'put'))) {
                if ($this->MailingOption->save($this->request->data)) {
                    $this->Message->display(__('Mailing options have successfully been saved.'), 'success');
                    $this->redirect(array('action' => 'index'));
                }
                $this->Message->display(__('Mailing options could not be saved!'), 'danger');
            }
            $this->set('uploads', $this->MailingOption->Upload->findAllByType('signature'));
            $this->request->data = $mailing_option;
            $this->set('mailing_option', $mailing_option);
            $this->set('superadmin', $this->Permission->superAdmin());
            $this->set('admin', $this->Permission->admin(null));
        } else {
            $this->Message->display(__('Only administrators can edit project-wide mailing options!'), 'danger');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function delete($id)
    {
        if (!$id OR !$mailing_option = $this->MailingOption->findById($id)) {
            throw new NotFoundException(__('The specified mailing option set was not found!'));
        }
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Permission->superAdmin() || $this->Permission->admin(null) || $mailing_option[$this->MailingOption->alias]['user_id'] == $this->Auth->user('id')) {
            if ($this->MailingOption->delete($id)) {
                $this->Message->display(__('Mailing option set has successfully been deleted.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
        } else {
            $this->Message->display(__('Only administrators can delete project-wide mailing options!'), 'danger');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function setActive($id = null)
    {
        //TODO: Check if user is allowed to switch to this mailing option
        if (!$id OR !$mailing_option = $this->MailingOption->findById($id)) {
            throw new NotFoundException(__('The specified mailing option set was not found!'));
        }
        $this->loadModel('User');
        $currentUser = $this->User->findById($this->Auth->user('id'));
        $currentUser[$this->User->alias]['mailing_option_id'] = $id;
        unset($currentUser[$this->User->alias]['password']);
        if ($this->User->save($currentUser)) {
            $this->Message->display(__('Mailing options have successfully been switched.'), 'success');
            $this->redirect(array('action' => 'index'));
        }
        $this->Message->display(__('Mailing options could not be switched!'), 'danger');
        $this->redirect(array('action' => 'index'));
    }

    public function changeTestMode($mode = null)
    {
        $this->loadModel('User');
        $currentUser = $this->User->findById($this->Auth->user('id'), array('id', 'testmode_active'));
        if ($mode == '0') {
            $currentUser['User']['testmode_active'] = 0;
            unset($currentUser[$this->User->alias]['password']);
            if ($this->User->save($currentUser)) {
                $this->Message->display(
                    __('Mailing mode has been set to productive configuration. Mails are sent directly to recipients!'), 'warning'
                );
            }
        } else if ($mode == '1') {
            $currentUser['User']['testmode_active'] = 1;
            unset($currentUser[$this->User->alias]['password']);
            if ($this->User->save($currentUser)) {
                $this->Message->display(
                    __('Mailing mode has been set to test configuration. Mails are sent to the sender specified in the active mailing options. Recipients do not receive any mail!'), 'success'
                );
            }
        }
        $this->redirect(array('action' => 'index'));
    }
}