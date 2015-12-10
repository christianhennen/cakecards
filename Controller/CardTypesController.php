<?php

/**
 * @property CardType $CardType
 * @property mixed Message
 * @property mixed Person
 * @property mixed Upload
 */
class CardTypesController extends AppController
{

    public $helpers = array('Html', 'Form');
    public $components = array('Message');

    public function index()
    {
        $this->set('cardtypes', $this->CardType->find('all'));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            if ($this->CardType->save($this->request->data)) {
                $this->Message->display(__('Card type has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Card type could not be saved!'), 'danger');
        }
    }

    public function edit($id = null)
    {
        if (!$id OR !$cardtype = $this->CardType->findById($id)) {
            throw new NotFoundException(__('The specified card type was not found!'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->CardType->save($this->request->data)) {
                $this->Message->display(__('Card type has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Card type could not be saved!'), 'danger');
        }
        $this->request->data = $cardtype;
        $this->set('cardtype', $cardtype);
    }

    public function delete($id)
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->CardType->delete($id)) {
            $this->Message->display(__('Card type has successfully been deleted.'), 'success');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function preview($id)
    {
        $cardtype = $this->request->data;
        $this->layout = 'ajax';
        $this->loadModel('Person');
        $this->loadModel('Upload');
        $person = $this->Person->find('first');
        $cardImage = $this->Upload->findById($cardtype['CardType']['image_upload_id']);
        $font = $this->Upload->findById($cardtype['CardType']['font_upload_id']);
        $image_path = "images/card_previews/" . $id . ".png";
        $cardtypeimage_path = "files/" . $cardImage['Upload']['id'] . "/" . $cardImage['Upload']['name'];
        $color = explode(',', $cardtype['CardType']['font_color_rgb'], 3);
        $text = "" . $person['Person']['salutation'] . "\n\n" . $person['CardText']['text'];
        $image = null;
        $ext = substr($cardImage['Upload']['name'], strrpos($cardImage['Upload']['name'], '.') + 1);
        if ($ext == "jpg" || $ext == "jpeg") {
            $image = imagecreatefromjpeg($cardtypeimage_path);
        } else {
            $image = imagecreatefrompng($cardtypeimage_path);
        }
        $font_color = ImageColorAllocate($image, $color[0], $color[1], $color[2]);
        imagettftext($image, $cardtype['CardType']['font_size'], $cardtype['CardType']['rotation'], $cardtype['CardType']['x_position'], $cardtype['CardType']['y_position'], $font_color, "files/" . $font['Upload']['id'] . "/" . $font['Upload']['name'], $text);
        imagepng($image, $image_path);
        $this->set('image_path', $image_path . "?" . time());
    }
}