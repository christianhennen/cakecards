<?php

/**
 * @property Option $Option
 * @property mixed Message
 * @property mixed User
 */
class OptionsController extends AppController
{

    public $helpers = array('Html', 'Form');
    public $components = array('Message');

    public function index()
    {
        $this->set('options', $this->Option->find('all'));
        $this->loadModel('User');
        $this->set('user', $this->User->findById($this->Auth->user('id'), array('id', 'testmode_active', 'sender_is_recipient')));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            if ($this->Option->save($this->request->data)) {
                $this->Message->display(__('Mailing options have successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Mailing options could not be saved!'), 'danger');
        }
        $this->set('cardtypes', $this->Option->CardType->find('list'));
        $this->set('uploads', $this->Option->Upload->findAllByType('signature')); //TODO: Replace enum type with array
    }

    public function edit($id = null)
    {
        if (!$id OR !$option = $this->Option->findById($id)) {
            throw new NotFoundException(__('The specified mailing options set was not found!'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Option->save($this->request->data)) {
                $this->Message->display(__('Mailing options have successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Mailing options could not be saved!'), 'danger');
        }
        $this->set('cardtypes', $this->Option->CardType->find('list'));
        $this->set('uploads', $this->Option->Upload->findAllByType('signature'));
        $this->request->data = $option;
        $this->set('option', $option);
    }

    public function changeMailingMode($mode = null)
    {
        $this->loadModel('User');
        $currentUser = $this->User->findById($this->Auth->user('id'), array('id', 'testmode_active', 'sender_is_recipient'));
        if ($mode == '0') {
            $currentUser['User']['testmode_active'] = 0;
            $currentUser['User']['sender_is_recipient'] = 0;
            if ($this->User->save($currentUser)) {
                $this->Message->display(
                    __('Mailing mode has been set to productive configuration. Mails are sent directly to recipients!'), 'warning'
                );
            }
        } else if ($mode == '1') {
            $currentUser['User']['testmode_active'] = 1;
            $currentUser['User']['sender_is_recipient'] = 0;
            if ($this->User->save($currentUser)) {
                $this->Message->display(
                    __('Mailing mode has been set to test configuration. However, mails are sent directly to recipients!'), 'warning'
                );
            }
        } else {
            $currentUser['User']['testmode_active'] = 1;
            $currentUser['User']['sender_is_recipient'] = 1;
            if ($this->User->save($currentUser)) {
                $this->Message->display(
                    __('Mailing mode has been set to test configuration. Mails are sent to the sender specified in the mailing options. Recipients do not receive any mail!'), 'success'
                );
            }
        }
        $this->redirect(array('action' => 'index'));
    }
}