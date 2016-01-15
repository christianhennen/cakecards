<?php
$vendor = App::path('Vendor');
require_once($vendor[0].'stil/gd-text/src/Box.php');
require_once($vendor[0].'stil/gd-text/src/Color.php');
require_once($vendor[0].'stil/gd-text/src/TextWrapping.php');
require_once($vendor[0].'stil/gd-text/src/VerticalAlignment.php');
require_once($vendor[0].'stil/gd-text/src/HorizontalAlignment.php');
/**
 * @property Card $Card
 * @property mixed Message
 * @property mixed Recipient
 * @property mixed Upload
 */
class CardsController extends AppController
{
    public $helpers = array('Html', 'Form');
    public $components = array('Message');

    public function index()
    {
        $this->set('cards', $this->Card->find('all'));
    }

    public function add()
    {
        if ($this->request->is('post')) {
            if ($this->Card->save($this->request->data)) {
                $this->Message->display(__('Card type has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Card type could not be saved!'), 'danger');
        }
    }

    public function edit($id = null)
    {
        if (!$id OR !$card = $this->Card->findById($id)) {
            throw new NotFoundException(__('The specified card type was not found!'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Card->save($this->request->data)) {
                $this->Message->display(__('Card type has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Card type could not be saved!'), 'danger');
            print_r($this->Card->validationErrors); //show validationErrors

            debug($this->Card->getDataSource()->getLog(false, false)); //show last sql query
        }
        $this->request->data = $card;
        $this->set('card', $card);
    }

    public function delete($id)
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Card->delete($id)) {
            $this->Message->display(__('Card type has successfully been deleted.'), 'success');
            $this->redirect(array('action' => 'index'));
        }
    }

    public function preview()
    {
        //TODO: Integrate this with CardCreatorBehavior

        $card = $this->request->data;
        $this->layout = 'ajax';
        $this->loadModel('Recipient');
        $this->loadModel('Upload');

        $recipient = $this->Recipient->find('first');
        if (empty($recipient)) {
            $text = __("Dear recipient,\nThis is a test text for the card preview\nLorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.\n\nGreetings\nCakeCards");
        } else {
            $text = "" . $recipient['Recipient']['salutation'] . "\n" . $recipient['Text']['text'];
        }

        $cardImage = $this->Upload->findById($card['Card']['image_upload_id']);
        $font = $this->Upload->findById($card['Card']['font_upload_id']);
        if (!empty($cardImage) && !empty($font)) {
            $image_path = "images/card_preview.png";
            $cardimage_path = "files/" . $cardImage['Upload']['id'] . "/" . $cardImage['Upload']['name'];
            $color = explode(',', $card['Card']['font_color_rgb'], 3);

            $image = null;
            $ext = substr($cardImage['Upload']['name'], strrpos($cardImage['Upload']['name'], '.') + 1);
            if ($ext == "jpg" || $ext == "jpeg") {
                $image = imagecreatefromjpeg($cardimage_path);
            } else {
                $image = imagecreatefrompng($cardimage_path);
            }
            $x = $card['Card']['x_position'];
            $y = $card['Card']['y_position'];
            $width = $card['Card']['width'];
            $height = $card['Card']['height'];
            $box = new GDText\Box($image);
            $box->setFontFace("files/" . $font['Upload']['id'] . "/" . $font['Upload']['name']);
            $box->setFontColor(new GDText\Color($color[0], $color[1], $color[2]));
            $box->setFontSize($card['Card']['font_size']);
            $box->setLineHeight($card['Card']['line_height']);
            $box->setBox($x, $y, $width, $height);
            $box->setTextAlign($card['Card']['text_align_horizontal'], $card['Card']['text_align_vertical']);
            $box->draw($text);
            imagepng($image, $image_path);
            $this->set('image_path', $image_path . "?" . time());
        } else {
            $this->set('message',__('There is no card image or font defined. Preview could not be generated.'));
        }
    }
}