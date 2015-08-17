<?php
/**
 *@property CardText $CardText
 */

class CardTextsController extends AppController {

    public $helpers = array('Html','Form');
    public $components = array('Message');

    public function index() {
        $this->set('cardtexts',$this->CardText->find('all', array(
            'order' => array('CardText.card_type_id' => 'desc'))));
    }

    public function add() {
        if ($this->request->is('post')) {
            if ($this->CardText->save($this->request->data)) {
                $this->Message->display(__('Card text has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Card text could not be saved!'), 'danger');
        }
        $this->set('cardTypes',$this->CardText->CardType->find('list'));
    }

    public function edit($id = null) {
        if (!$id OR !$cardtext = $this->CardText->findById($id)) {
            throw new NotFoundException(__('The specified card text was not found!'));
        }
        if ($this->request->is(array('post','put'))) {
            if ($this->CardText->save($this->request->data)) {
                $this->Message->display(__('Card text has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Card text could not be saved!'), 'danger');
        }
        $this->set('cardTypes',$this->CardText->CardType->find('list'));
        $this->request->data = $cardtext;
    }

    public function delete($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->CardText->delete($id)) {
            $this->Message->display(__('Card text has successfully been deleted.'), 'success');
            $this->redirect(array('action' => 'index'));
        }
    }

}
?>