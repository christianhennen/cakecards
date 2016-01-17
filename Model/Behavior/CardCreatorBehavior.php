<?php
$vendor = App::path('Vendor');
require_once $vendor[0] . 'stil/gd-text/src/Box.php';
require_once $vendor[0] . 'stil/gd-text/src/Color.php';
require_once $vendor[0] . 'stil/gd-text/src/TextWrapping.php';
require_once $vendor[0] . 'stil/gd-text/src/VerticalAlignment.php';
require_once $vendor[0] . 'stil/gd-text/src/HorizontalAlignment.php';

class CardCreatorBehavior extends ModelBehavior
{

    public function afterSave(Model $model, $created, $options = array())
    {
        $conditions = array();
        if ($model->alias == 'Recipient') {
            $conditions = array("Recipient.id" => $model->data['Recipient']['id']);
        }
        if ($model->alias == 'Text') {
            $conditions = array("Text.id" => $model->data['Text']['id']);
        }
        if ($model->alias == 'Card') {
            $conditions = array("Card.id" => $model->data['Card']['id']);
        }
        $recipientModel = ClassRegistry::init('Recipient');
        $recipients = $recipientModel->find("all", array(
            "joins" => array(
                array(
                    "table" => "uploads",
                    "alias" => "Image",
                    "type" => "LEFT",
                    "conditions" => array(
                        "Card.image_upload_id = Image.id"
                    )
                ),
                array(
                    "table" => "uploads",
                    "alias" => "Font",
                    "type" => "LEFT",
                    "conditions" => array(
                        "Card.font_upload_id = Font.id"
                    )
                )
            ),
            "conditions" => $conditions,
            "fields" => array('Recipient.id', 'Recipient.salutation', 'Text.id', 'Text.text', 'Card.font_size', 'Card.x_position',
                'Card.y_position', 'Card.width', 'Card.height', 'Card.text_align_horizontal', 'Card.text_align_vertical', 'Card.line_height', 'Card.font_color_rgb', 'Image.id', 'Image.name', 'Font.id', 'Font.name'),
        ));
        foreach ($recipients as $recipient) {
            $this->createCard($recipient);
        }

    }

    public function createCard($recipient)
    {
        if(!file_exists('images/')) {
            mkdir('images',0755);
        }
        if(!file_exists('images/thumbnails/')) {
            mkdir('images/thumbnails',0755);
        }
        $image_path = "images/" . $recipient['Recipient']['id'] . ".png";
        $thumbnail_path = "images/thumbnails/" . $recipient['Recipient']['id'] . ".png";
        $cardimage_path = "files/" . $recipient['Image']['id'] . "/" . $recipient['Image']['name'];
        $color = explode(',', $recipient['Card']['font_color_rgb'], 3);
        $text = "" . $recipient['Recipient']['salutation'] . "\n" . $recipient['Text']['text'];

        $image = null;
        $ext = substr($recipient['Image']['name'], strrpos($recipient['Image']['name'], '.') + 1);
        if ($ext == "jpg" || $ext == "jpeg") {
            $image = imagecreatefromjpeg($cardimage_path);
        } else {
            $image = imagecreatefrompng($cardimage_path);
        }
        $x = $recipient['Card']['x_position'];
        $y = $recipient['Card']['y_position'];
        $width = $recipient['Card']['width'];
        $height = $recipient['Card']['height'];
        $box = new GDText\Box($image);
        $box->setFontFace("files/" . $recipient['Font']['id'] . "/" . $recipient['Font']['name']);
        $box->setFontColor(new GDText\Color($color[0], $color[1], $color[2]));
        $box->setFontSize($recipient['Card']['font_size']);
        $box->setLineHeight($recipient['Card']['line_height']);
        $box->setBox($x, $y, $width, $height);
        $box->setTextAlign($recipient['Card']['text_align_horizontal'], $recipient['Card']['text_align_vertical']);
        $box->draw($text);
        imagepng($image, $image_path);
        $orig_width = imagesx($image);
        $orig_height = imagesy($image);
        $width = 100;
        $height = (($orig_height * $width) / $orig_width);
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresized($new_image, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
        imagepng($new_image, $thumbnail_path);
        imagedestroy($image);
        imagedestroy($new_image);
    }
}