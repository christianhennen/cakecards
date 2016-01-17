<?php

/**
 * @property MailingOption $MailingOption
 * @property mixed Message
 * @property mixed User
 */
class MailingOptionsController extends AppController
{

    public $helpers = array('Html', 'Form');
    public $components = array('Message');

    public function index()
    {
        $this->set('mailing_options', $this->MailingOption->find('all'));
        $this->loadModel('User');
        $this->set('user', $this->User->findById($this->Auth->user('id'), array('id', 'testmode_active')));
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
        $this->set('cards', $this->MailingOption->Card->find('list'));
        $this->set('uploads', $this->MailingOption->Upload->findAllByType('signature'));
    }

    public function edit($id = null)
    {
        if (!$id OR !$mailing_option = $this->MailingOption->findById($id)) {
            throw new NotFoundException(__('The specified mailing options set was not found!'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->MailingOption->save($this->request->data)) {
                $this->Message->display(__('Mailing options have successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Mailing options could not be saved!'), 'danger');
        }
        $this->set('cards', $this->MailingOption->Card->find('list'));
        $this->set('uploads', $this->MailingOption->Upload->findAllByType('signature'));
        $this->request->data = $mailing_option;
        $this->set('mailing_option', $mailing_option);
    }

    public function changeMailingMode($mode = null)
    {
        $this->loadModel('User');
        $currentUser = $this->User->findById($this->Auth->user('id'), array('id', 'testmode_active'));
        if ($mode == '0') {
            $currentUser['User']['testmode_active'] = 0;
            if ($this->User->save($currentUser)) {
                $this->Message->display(
                    __('Mailing mode has been set to productive configuration. Mails are sent directly to recipients!'), 'warning'
                );
            }
        } else if ($mode == '1') {
            $currentUser['User']['testmode_active'] = 1;
            if ($this->User->save($currentUser)) {
                $this->Message->display(
                    __('Mailing mode has been set to test configuration. Mails are sent to the sender specified in the active mailing options. Recipients do not receive any mail!'), 'success'
                );
            }
        }
        $this->redirect(array('action' => 'index'));
    }
}