<?php
$vendor = App::path('Vendor');
require_once($vendor[0] . 'stil/gd-text/src/Box.php');
require_once($vendor[0] . 'stil/gd-text/src/Color.php');
require_once($vendor[0] . 'stil/gd-text/src/TextWrapping.php');
require_once($vendor[0] . 'stil/gd-text/src/VerticalAlignment.php');
require_once($vendor[0] . 'stil/gd-text/src/HorizontalAlignment.php');

class CardCreatorBehavior extends ModelBehavior
{

    public function afterSave(Model $model, $created, $options = array())
    {
        $conditions = array();
        if ($model->alias == 'Person') {
            $conditions = array("Person.id" => $model->data['Person']['id']);
        }
        if ($model->alias == 'CardText') {
            $conditions = array("CardText.id" => $model->data['CardText']['id']);
        }
        if ($model->alias == 'CardType') {
            $conditions = array("CardType.id" => $model->data['CardType']['id']);
        }
        $personModel = ClassRegistry::init('Person');
        $people = $personModel->find("all", array(
            "joins" => array(
                array(
                    "table" => "card_types",
                    "alias" => "CardType",
                    "type" => "LEFT",
                    "conditions" => array(
                        "CardText.card_type_id = CardType.id",
                    )
                ),
                array(
                    "table" => "uploads",
                    "alias" => "Image",
                    "type" => "LEFT",
                    "conditions" => array(
                        "CardType.image_upload_id = Image.id"
                    )
                ),
                array(
                    "table" => "uploads",
                    "alias" => "Font",
                    "type" => "LEFT",
                    "conditions" => array(
                        "CardType.font_upload_id = Font.id"
                    )
                )
            ),
            "conditions" => $conditions,
            "fields" => array('Person.id', 'Person.id', 'Person.salutation', 'CardText.id', 'CardText.text', 'CardType.font_size', 'CardType.x_position',
                'CardType.y_position', 'CardType.width', 'CardType.height', 'CardType.text_align_horizontal', 'CardType.text_align_vertical', 'CardType.line_height', 'CardType.font_color_rgb', 'Image.id', 'Image.name', 'Font.id', 'Font.name'),
        ));
        foreach ($people as $person) {
            $this->createCard($person);
        }

    }

    public function createCard($person)
    {
        if(!file_exists('images/')) {
            mkdir('images',0755);
        }
        if(!file_exists('images/thumbnails/')) {
            mkdir('images/thumbnails',0755);
        }
        $image_path = "images/" . $person['Person']['id'] . ".png";
        $thumbnail_path = "images/thumbnails/" . $person['Person']['id'] . ".png";
        $cardtypeimage_path = "files/" . $person['Image']['id'] . "/" . $person['Image']['name'];
        $color = explode(',', $person['CardType']['font_color_rgb'], 3);
        $text = "" . $person['Person']['salutation'] . "\n" . $person['CardText']['text'];

        $image = null;
        $ext = substr($person['Image']['name'], strrpos($person['Image']['name'], '.') + 1);
        if ($ext == "jpg" || $ext == "jpeg") {
            $image = imagecreatefromjpeg($cardtypeimage_path);
        } else {
            $image = imagecreatefrompng($cardtypeimage_path);
        }
        $x = $person['CardType']['x_position'];
        $y = $person['CardType']['y_position'];
        $width = $person['CardType']['width'];
        $height = $person['CardType']['height'];
        $box = new GDText\Box($image);
        $box->setFontFace("files/" . $person['Font']['id'] . "/" . $person['Font']['name']);
        $box->setFontColor(new GDText\Color($color[0], $color[1], $color[2]));
        $box->setFontSize($person['CardType']['font_size']);
        $box->setLineHeight($person['CardType']['line_height']);
        $box->setBox($x, $y, $width, $height);
        $box->setTextAlign($person['CardType']['text_align_horizontal'], $person['CardType']['text_align_vertical']);
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