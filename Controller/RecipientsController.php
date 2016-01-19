<?php

/**
 * @property Recipient $Recipient
 * @property mixed Message
 * @property mixed Upload
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
                    if ($this->Recipient->delete($recipient[$this->Recipient->alias]['id'])) {
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

        $mailing_option = $this->Auth->user('CurrentMailingOption');
        $this->set('mailing_option', $mailing_option);

        App::uses('CakeEmail', 'Network/Email');
        $email = new CakeEmail();
        $tls = false;
        if ($mailing_option['use_tls'] == 1) {
            $tls = true;
        }

        $email->config(array(
            'transport' => 'Smtp',
            'client' => null,
            'log' => false,
            'charset' => 'utf-8',
            'headerCharset' => 'utf-8',
            'emailFormat' => 'html',
            'host' => $mailing_option['server'],
            'port' => $mailing_option['port'],
            'tls' => $tls,
            'timeout' => $mailing_option['timeout'],
            'username' => $mailing_option['username'],
            'password' => $mailing_option['password'],
        ));

        $email->subject($mailing_option['subject']);

        $email->template('default', 'default');
        $email->emailFormat('both');

        $email->from(array($mailing_option['from_address'] => $mailing_option['from_name']));

        if ($this->Auth->user('testmode_active') == 1) {
            $email->to(array($mailing_option['from_address'] => $mailing_option['from_name']));
        } else {
            $email->to(array($recipient[$this->Recipient->alias]['email'] => $recipient[$this->Recipient->alias]['prename'] . ' ' . $recipient[$this->Recipient->alias]['surname']));
        }

        $attachments = array(
            'card.png' => array(
                'file' => 'images/' . $recipient[$this->Recipient->alias]['id'] . '.png',
                'mimetype' => 'image/png',
                'contentId' => 'card'
            ));
        $this->loadModel('Upload');
        $upload = $this->Upload->findById($mailing_option['upload_id']);
        if ($upload) {
            if (strpos($mailing_option['signature'], '[signature_image]') != false) {
                $signature = str_replace("[signature_image]", "<img src=\"cid:signature\">", $mailing_option['signature']);
                $attachments['signature.png'] = array(
                    'file' => 'files/' . $upload[$this->Upload->alias]['id'] . DS . $upload[$this->Upload->alias]['name'],
                    'mimetype' => 'image/png',
                    'contentId' => 'signature'
                );
            } else {
                $signature = $mailing_option['signature'];
            }
        } else{
            $signature = str_replace("[signature_image]", "", $mailing_option['signature']);
        }
        $email->attachments($attachments);

        $text = "" . $recipient[$this->Recipient->alias]['salutation'] . "\n\n" . $recipient['Text']['text'];
        $html = '<span class="preheader" style="display: none !important; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">';
        $html .= $text . '</span><img src="cid:card" alt="' . $text . '"><br/>' . $signature;
        $email->viewVars(array('text' => $text, 'html' => $html));

        $this->set('email', $email);
    }
}