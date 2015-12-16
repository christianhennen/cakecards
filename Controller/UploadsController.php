<?php

/**
 * @property Upload $Upload
 * @property mixed Message
 * @property mixed webroot
 */
class UploadsController extends AppController
{
    private $types = array('card','font','signature');
    public $helpers = array('Html', 'Form');
    public $components = array('Message', 'RequestHandler');

    public function index($id = null)
    {
        $this->layout = 'ajax';
        if (array_key_exists('type', $this->request->query)) {
            $type = $this->request->query['type'];
        } else {
            $type = null;
        }
        if (!$id AND !$type) {
            $uploads = $this->Upload->find('all');
            $this->set(array(
                'uploads' => $uploads,
                '_serialize' => array('uploads')));
        } elseif ($id AND !$type) {
            $this->set(array(
                'uploads' => $this->Upload->findAllById($id),
                '_serialize' => array('uploads')));
        } elseif (!$id AND $type AND in_array($type,$this->types)) {
            $this->set(array(
                'uploads' => $this->Upload->findAllByType($type),
                '_serialize' => array('uploads')));
        } else {
            $this->set(array(
                'uploads' => $this->Upload->findAllByIdAndType($id, $type),
                '_serialize' => array('uploads')));
        }
    }

    public function isImage($ext, $mimeType)
    {
        if (($ext == "jpg" || $ext == "jpeg" || $ext == "png") && ($mimeType == "image/jpeg" || $mimeType == "image/png")) return true;
        else return false;
    }

    public function isFont($ext, $mimeType)
    {
        if (($ext == "ttf") && ($mimeType == "font/ttf" || $mimeType == "font/truetype" || $mimeType == "application/octet-stream")) return true;
        else return false;
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $result = null;
            $file = $this->request->data['files'];
            $type = $this->request->data['type'];
            $filename = basename($file['name']);
            if ((!empty($file)) && ($file['error'] == 0)) {
                $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
                if (($this->isImage($ext, $file["type"]) || $this->isFont($ext, $file["type"])) && ($file["size"] < 20000000)) {
                    $this->Upload->set('name', $filename);
                    $this->Upload->set('size', $file["size"]);
                    $this->Upload->set('type', $type);
                    if ($this->Upload->save()) {
                        $id = $this->Upload->getInsertID();
                        $newname = WWW_ROOT . "files" . DS . $id . DS . $filename;
                        mkdir(WWW_ROOT . "files/" . $id);
                        if ((move_uploaded_file($file['tmp_name'], $newname))) {
                            $url = $this->webroot . "files" . DS . $id . DS . $filename;
                            if ($this->isImage($ext, $file["type"])) {
                                $image = null;
                                if ($ext == "jpg" || $ext == "jpeg") {
                                    $image = imagecreatefromjpeg($newname);
                                } else {
                                    $image = imagecreatefrompng($newname);
                                }
                                $orig_width = imagesx($image);
                                $orig_height = imagesy($image);
                                $width = 900;
                                $height = (($orig_height * $width) / $orig_width);
                                $new_image = imagecreatetruecolor($width, $height);
                                imagecopyresampled($new_image, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);
                                if ($ext == "jpg" || $ext == "jpeg") {
                                    imagejpeg($new_image, $newname);
                                } else {
                                    imagepng($new_image, $newname);
                                }
                                imagedestroy($image);
                                imagedestroy($new_image);
                            } elseif ($this->isFont($ext, $file["type"])) {
                                $image = imagecreatefrompng('files/font-preview.png');
                                $font_color = ImageColorAllocate($image, 0, 0, 0);
                                imagettftext($image, 18, 0, 0, 30, $font_color, $newname, $filename);
                                imagepng($image, "files/" . $id . "/preview.png");
                            }
                            $result = array("files" => array(array(
                                "name" => $filename,
                                "size" => $file["size"],
                                "url" => $url,
                                "id" => $id
                            )));
                        } else {
                            $this->Upload->delete($id);
                            $result = array("files" => array(array(
                                "name" => $filename,
                                "error" => __('An error occured during file upload!')
                            )));
                        }
                    } else {
                        $result = array("files" => array(array(
                            "name" => $filename,
                            "error" => __('Error: Could not save file')
                        )));
                    }

                } else {
                    $result = array("files" => array(array(
                        "name" => $filename,
                        "error" => __('Error: Only files under 20Mb in .jpg .png or .ttf format are accepted for upload!')
                    )));
                }
            } else {
                $result = array("files" => array(array(
                    "name" => $filename,
                    "error" => __('Error: No file uploaded!')
                )));
            }
            $this->set(array(
                'uploads' => $result,
                '_serialize' => 'uploads'));
        }

    }

    public function edit($id = null)
    {
        if (!$id OR !$upload = $this->Upload->findById($id)) {
            throw new NotFoundException(__('The specified upload was not found!'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Upload->save($this->request->data)) {
                $this->Message->display(__('Upload has successfully been saved.'), 'success');
                $this->redirect(array('action' => 'index'));
            }
            $this->Message->display(__('Upload could not be saved!'), 'danger');
        }
        $this->request->data = $upload;
    }

    public function latest()
    {
        $this->set(array(
            'upload' => $this->Upload->find('first', array('order' => array('id' => 'DESC'))),
            '_serialize' => array('upload')));
    }

}