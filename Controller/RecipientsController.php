<?php

/**
 * @property Recipient $Recipient
 * @property mixed Message
 * @property mixed MailingOption
 * @property mixed User
 * @property mixed Text
 * @property mixed Card
 * @property mixed Permission
 */
class RecipientsController extends AppController
{
    public $helpers = array('CakePHPExcel.PhpExcel');

    public function index()
    {
        $this->set('recipients', $this->Recipient->find('all', array('order' => array('Recipient.surname' => 'asc'))));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            if ($this->Recipient->save($this->request->data)) {
                $this->Message->display(__('Recipient has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Recipient could not be saved!'), 'danger');
        }
        $this->set('texts', $this->Recipient->Text->find('list'));
        $this->set('cards', $this->Recipient->Card->find('list'));
    }

    public function edit($id = null)
    {
        if (!$id OR !$recipient = $this->Recipient->findById($id) OR $recipient[$this->Recipient->alias]['project_id'] != $this->Permission->pid()) {
            throw new NotFoundException(__('The specified recipient was not found!'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Recipient->save($this->request->data)) {
                $this->Message->display(__('Recipient has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Recipient could not be saved!'), 'danger');
        }
        $this->set('texts', $this->Recipient->Text->find('list'));
        $this->set('cards', $this->Recipient->Card->find('list'));
        $this->request->data = $recipient;
    }

    public function delete($id = null)
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if (!$id) {
            if (array_key_exists('ids', $this->request->data)) {
                $id = explode(',', $this->request->data['ids']);
                $recipients = $this->Recipient->findAllById($id);
                foreach ($recipients as $recipient) {
                    if ($recipient[$this->Recipient->alias]['project_id'] != $this->Permission->pid()) {
                        throw new NotFoundException(__('The specified card text was not found!'));
                    }
                    if ($this->Recipient->delete($recipient['Recipient']['id'])) {
                        $this->Message->display(__('Recipients have successfully been deleted.'), 'success');
                    } else {
                        $this->Message->display(__('Recipients could not be deleted.'), 'danger');
                    }
                }
            }
        } else {
            if (!$recipient = $this->Recipient->findById($id) OR $recipient[$this->Recipient->alias]['project_id'] != $this->Permission->pid()) {
                throw new NotFoundException(__('The specified card text was not found!'));
            }
            if ($this->Recipient->delete($id)) {
                $this->Message->display(__('Recipient has successfully been deleted.'), 'success');
            } else {
                $this->Message->display(__('Recipient could not be deleted.'), 'danger');
            }
        }
        $this->redirect(array('action' => 'index'));
    }

    public function exportExcel()
    {
        $this->loadModel('Text');
        $this->loadModel('Card');
        $this->set('recipients', $this->Recipient->find('all', array(
            'order' => array('Recipient.surname' => 'asc'))));
        $this->set('texts', $this->Text->find('all'));
        $this->set('cards', $this->Card->find('all'));
    }

    public function sendEmails($id = null)
    {
        if (!$id) {
            if (array_key_exists('ids', $this->request->data)) {
                $id = explode(',', $this->request->data['ids']);
                $this->set('recipients', $this->Recipient->find('all', array(
                    'conditions' => array(
                        "Recipient.id" => $id
                    ),
                    'order' => array('Recipient.surname' => 'asc'))));
            } else {
                $this->set('recipients', $this->Recipient->find('all', array(
                    'order' => array('Recipient.surname' => 'asc'))));
            }
        } else {
            $recipient = $this->Recipient->findById($id);
            if (!$recipient) {
                throw new NotFoundException(__('The specified recipient was not found!'));
            }
            $this->set('recipients', array($recipient));
        }
    }

    public function sendEmail($id = null)
    {
        $this->layout = 'ajax';
        if (!$id OR !$recipient = $this->Recipient->findById($id)) {
            throw new NotFoundException(__('The specified recipient was not found!'));
        }
        $this->set('recipient', $recipient);
        $this->loadModel('User');
        $user = $this->User->findById($this->Auth->user('id'), array('id', 'testmode_active', 'sender_is_recipient'));
        if ($user['User']['testmode_active'] == '1') {
            $testMode = 1;
        } else {
            $testMode = 0;
        }
        $this->loadModel('MailingOption');
        $mailing_option = $this->MailingOption->findByCardIdAndIsTestmode($recipient['Text']['card_id'], $testMode);
        $this->set('mailing_option', $mailing_option);

        App::uses('CakeEmail', 'Network/Email');
        $email = new CakeEmail();
        $tls = false;
        if ($mailing_option['MailingOption']['use_tls'] == 1) {
            $tls = true;
        }

        $email->config(array(
            'transport' => 'Smtp',
            'client' => null,
            'log' => true,
            'charset' => 'utf-8',
            'headerCharset' => 'utf-8',
            'emailFormat' => 'html',
            'host' => $mailing_option['MailingOption']['server'],
            'port' => $mailing_option['MailingOption']['port'],
            'tls' => $tls,
            'timeout' => $mailing_option['MailingOption']['timeout'],
            'username' => $mailing_option['MailingOption']['username'],
            'password' => $mailing_option['MailingOption']['password'],
        ));

        $email->subject($mailing_option['MailingOption']['subject']);

        $email->template('default', 'default');
        $email->emailFormat('both');

        $email->from(array($mailing_option['MailingOption']['from_adress'] => $mailing_option['MailingOption']['from_name']));

        if ($user['User']['sender_is_recipient'] == 1) {
            $email->to(array($mailing_option['MailingOption']['from_adress'] => $mailing_option['MailingOption']['from_name']));
        } else {
            $email->to(array($recipient['Recipient']['email'] => $recipient['Recipient']['prename'] . ' ' . $recipient['Recipient']['surname']));
        }

        $attachments = array(
            'card.png' => array(
                'file' => 'images/' . $recipient['Recipient']['id'] . '.png',
                'mimetype' => 'image/png',
                'contentId' => 'card'
            ));
        if ($mailing_option['Upload']['id'] != '') {
            if (strpos($mailing_option['MailingOption']['signature'], '[signature_image]') != false) {
                $signature = str_replace("[signature_image]", "<img src=\"cid:signature\">", $mailing_option['MailingOption']['signature']);
                $attachments['signature.png'] = array(
                    'file' => 'files/' . $mailing_option['Upload']['id'] . DS . $mailing_option['Upload']['name'],
                    'mimetype' => 'image/png',
                    'contentId' => 'signature'
                );
            } else {
                $signature = $mailing_option['MailingOption']['signature'];
            }
        } else{
            $signature = str_replace("[signature_image]", "", $mailing_option['MailingOption']['signature']);
        }
        $email->attachments($attachments);

        $text = "" . $recipient['Recipient']['salutation'] . "\n\n" . $recipient['Text']['text'];
        $html = '<span class="preheader" style="display: none !important; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">';
        $html .= $text . '</span><img src="cid:card" alt="' . $text . '"><br/>' . $signature;
        $email->viewVars(array('text' => $text, 'html' => $html));

        $this->set('email', $email);
    }
}