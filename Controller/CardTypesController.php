<?php
$vendor = App::path('Vendor');
require_once($vendor[0].'stil/gd-text/src/Box.php');
require_once($vendor[0].'stil/gd-text/src/Color.php');
require_once($vendor[0].'stil/gd-text/src/TextWrapping.php');
require_once($vendor[0].'stil/gd-text/src/VerticalAlignment.php');
require_once($vendor[0].'stil/gd-text/src/HorizontalAlignment.php');
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
            print_r($this->CardType->validationErrors); //show validationErrors

            debug($this->CardType->getDataSource()->getLog(false, false)); //show last sql query
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

    public function preview()
    {
        //TODO: Integrate this with CardCreatorBehavior

        if(!file_exists('images/card_previews/')) {
            mkdir('images/card_previews',0755);
        }
        $cardtype = $this->request->data;
        $this->layout = 'ajax';
        $this->loadModel('Person');
        $this->loadModel('Upload');
        $person = $this->Person->find('first');
        $cardImage = $this->Upload->findById($cardtype['CardType']['image_upload_id']);
        $font = $this->Upload->findById($cardtype['CardType']['font_upload_id']);
        $image_path = "images/card_previews/preview.png";
        $cardtypeimage_path = "files/" . $cardImage['Upload']['id'] . "/" . $cardImage['Upload']['name'];
        $color = explode(',', $cardtype['CardType']['font_color_rgb'], 3);
        $text = "" . $person['Person']['salutation'] . "\n" . $person['CardText']['text'];
        $image = null;
        $ext = substr($cardImage['Upload']['name'], strrpos($cardImage['Upload']['name'], '.') + 1);
        if ($ext == "jpg" || $ext == "jpeg") {
            $image = imagecreatefromjpeg($cardtypeimage_path);
        } else {
            $image = imagecreatefrompng($cardtypeimage_path);
        }
        $x = $cardtype['CardType']['x_position'];
        $y = $cardtype['CardType']['y_position'];
        $width = $cardtype['CardType']['width'];
        $height = $cardtype['CardType']['height'];
        $box = new GDText\Box($image);
        $box->setFontFace("files/" . $font['Upload']['id'] . "/" . $font['Upload']['name']);
        $box->setFontColor(new GDText\Color($color[0], $color[1], $color[2]));
        $box->setFontSize($cardtype['CardType']['font_size']);
        $box->setLineHeight($cardtype['CardType']['line_height']);
        $box->setBox($x,$y,$width,$height);
        $box->setTextAlign($cardtype['CardType']['text_align_horizontal'], $cardtype['CardType']['text_align_vertical']);
        $box->draw($text);
        imagepng($image, $image_path);
        $this->set('image_path', $image_path . "?" . time());
    }
}