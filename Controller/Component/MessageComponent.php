<?
App::uses('Component', 'Controller');
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
?>