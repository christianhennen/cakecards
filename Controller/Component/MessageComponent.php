<?php
App::uses('Component', 'Controller');

/**
 * @property mixed Session
 */
class MessageComponent extends Component {

    public $components = array('Session');

    public function display($message,$class) {
        $this->Session->setFlash($message, 'alert' , array(
                'plugin' => 'BoostCake',
                'class' => 'alert-'.$class
            )
        );
    }
}