<?php
/**
 *@property Person $Person
 */

class PeopleController extends AppController {

    public $helpers = array('Html','Form','CakePHPExcel.PhpExcel');
    public $components = array('Message');

    public function index() {
        $this->set('people',$this->Person->find('all', array(
            'order' => array('Person.surname' => 'asc'))));
    }

    public function add() {
        if ($this->request->is('post')) {
            if ($this->Person->save($this->request->data)) {
                $this->Message->display(__('Recipient has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Recipient could not be saved!'), 'danger');
        }
        $this->set('cardTexts',$this->Person->CardText->find('list'));
        $this->set('cardtexts2',$this->Person->CardText->find('all'));
    }

    public function edit($id = null) {
        if (!$id OR !$person = $this->Person->findById($id)) {
            throw new NotFoundException(__('The specified recipient was not found!'));
        }
        if ($this->request->is(array('post','put'))) {
            if ($this->Person->save($this->request->data)) {
                $this->Message->display(__('Recipient has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Recipient could not be saved!'), 'danger');
        }
        $this->set('cardTexts',$this->Person->CardText->find('list'));
        $this->set('cardtexts2',$this->Person->CardText->find('all'));
        $this->request->data = $person;
    }

    public function delete($id = null) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if (!$id) {
            if (array_key_exists('ids', $this->request->data)) {
                $id = explode(',', $this->request->data['ids']);
                $people = $this->Person->findAllById($id);
                foreach ($people as $person) {
                    if($this->Person->delete($person['Person']['id'])) {
                        $this->Message->display(__('Recipients have successfully been deleted.'), 'success');
                    } else {
                        $this->Message->display(__('Recipients could not be deleted.'), 'danger');
                    }
                }
            }
        } else {
            if ($this->Person->delete($id)) {
                $this->Message->display(__('Recipient has successfully been deleted.'), 'success');
            } else {
                $this->Message->display(__('Recipient could not be deleted.'), 'danger');
            }
        }
        $this->redirect(array('action' => 'index'));
    }

    public function exportExcel() {
        $this->loadModel('CardText');
        $this->loadModel('CardType');
        $this->set('people',$this->Person->find('all', array(
            'order' => array('Person.surname' => 'asc'))));
        $this->set('cardtexts',$this->CardText->find('all'));
        $this->set('cardtypes',$this->CardType->find('all'));
    }

    public function sendEmails($id = null) {
        if (!$id) {
            if (array_key_exists('ids',$this->request->data)) {
                $id = explode(',',$this->request->data['ids']);
                $this->set('people',$this->Person->find('all', array(
                    'conditions' => array(
                        "Person.id" => $id
                    ),
                    'order' => array('Person.surname' => 'asc'))));
            } else {
                $this->set('people',$this->Person->find('all', array(
                    'order' => array('Person.surname' => 'asc'))));
            }
        } else {
            $person = $this->Person->findById($id);
            if (!$person) {
                throw new NotFoundException(__('The specified recipient was not found!'));
            }
            $this->set('people',array($person));
        }
    }

    public function sendEmail($id = null) {
        $this->layout = 'ajax';
        if (!$id OR !$person = $this->Person->findById($id)) {
            throw new NotFoundException(__('The specified recipient was not found!'));
        }
        $this->set('person',$person);
        $this->loadModel('User');
        $user = $this->User->findById($this->Auth->user('id'), array('id', 'testmode_active', 'sender_is_recipient'));
        if($user['User']['testmode_active'] == '1') {
            $testMode = 1;
        } else {
            $testMode = 0;
        }
        $this->loadModel('Option');
        $option = $this->Option->findByCardTypeIdAndIsTestmode($person['CardText']['card_type_id'],$testMode);
        $this->set('option',$option);

        App::uses('CakeEmail', 'Network/Email');
        $email = new CakeEmail();
        $tls = false;
        if ($option['Option']['use_tls'] == 1) {
            $tls = true;
        }

        $email->config(array(
            'transport' => 'Smtp',
            'client' => null,
            'log' => true,
            'charset' => 'utf-8',
            'headerCharset' => 'utf-8',
            'emailFormat' => 'html',
            'host' => $option['Option']['server'],
            'port' => $option['Option']['port'],
            'tls' => $tls,
            'timeout' => $option['Option']['timeout'],
            'username' => $option['Option']['username'],
            'password' => $option['Option']['password'],
        ));

        $email->subject($option['Option']['subject']);

        $email->template('default','default');
        $email->emailFormat('both');

        $email->from(array($option['Option']['from_adress'] => $option['Option']['from_name']));

        if ($user['User']['sender_is_recipient'] == 1) {
            $email->to(array($option['Option']['from_adress'] => $option['Option']['from_name']));
        } else {
            $email->to(array($person['Person']['email'] => $person['Person']['prename'].' '.$person['Person']['surname']));
        }


        $email->attachments(array(
            'card.png' => array(
                'file' => 'images/'.$person['Person']['id'].'.png',
                'mimetype' => 'image/png',
                'contentId' => 'card'
            ),
            'signature.png' => array(
                'file' => 'files/'.$option['Upload']['id'].DS.$option['Upload']['name'],
                'mimetype' => 'image/png',
                'contentId' => 'signature'
            )
        ));

        $signature = str_replace("[signature_image]","<img src=\"cid:signature\">",$option['Option']['signature']);


        $text = "".$person['Person']['salutation']."\n\n".$person['CardText']['text'];
        $html = '<span class="preheader" style="display: none !important; visibility: hidden; opacity: 0; color: transparent; height: 0; width: 0;">';
        $html .= $text.'</span><img src="cid:card" alt="'.$text.'"><br/>'.$signature;
        $email->viewVars(array('text' => $text, 'html' => $html));

        $this->set('email',$email);
    }
}
?>