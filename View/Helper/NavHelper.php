<?php

/**
 * @property mixed Html
 */
class NavHelper extends AppHelper
{
    public $name = 'Nav';
    public $helpers = array('Html');
    private $navItems = array();

    public function main()
    {
        $this->navItems = array(
            array(
                'title' => '<span class="glyphicon glyphicon-user"></span> ' . __('Recipients'),
                'url' => array('controller' => 'people', 'action' => 'index', '')
            ),
            array(
                'title' => '<span class="glyphicon glyphicon-comment"></span> ' . __('Card texts'),
                'url' => array('controller' => 'card_texts', 'action' => 'index', '')
            ),
            array(
                'title' => '<span class="glyphicon glyphicon-picture"></span> ' . __('Card types'),
                'url' => array('controller' => 'card_types', 'action' => 'index', '')
            ),
            array(
                'title' => '<span class="glyphicon glyphicon-envelope"></span> ' . __('Mailing options'),
                'url' => array('controller' => 'options', 'action' => 'index', '')
            ),
            array(
                'title' => '<span class="glyphicon glyphicon-lock"></span> ' . __('Security'),
                'url' => array('controller' => 'users', 'action' => 'index', '')
            )
        );
        if (AuthComponent::user('id')) {
            $logoutButton = '<form class="navbar-form navbar-right" action="'
                . $this->Html->url(array("controller" => "users", "action" => "logout")) .
                '" method="get"><button class="btn btn-default">' . __('Logout') . '</button></form>';
            return '
				<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
        <span class="sr-only">' . __('Toggle navigation') . '</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar-collapse-1">
    <ul class="nav navbar-nav">' . $this->nav($this->navItems) . '
			</ul>' . $logoutButton . '</div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid --></nav>';
        } else {
            return '';
        }

    }

    private function nav($items)
    {
        $content = '';
        foreach ($items as $item) {
            $class = '';
            if ($this->isActive($item)) {
                $class = 'active';
            }
            $url = $this->getUrl($item);
            $content .= '<li class="' . $class . '">' . $this->Html->link($item['title'], $url, array(
                    'escape' => false)) . '</li>';
        }
        return $content;
    }

    private function getUrl($item)
    {
        $url = false;
        if (isset($item['url'])) {
            $url = $item['url'];
        }
        return $url;
    }

    private function isActive($item)
    {
        $url = $this->Html->url($this->getUrl($item));
        if ($this->here == $url || ($url != '/' && strlen($this->here) > strlen($url) && substr($this->here, 0, strlen($url)) == $url)) {
            $active = true;
        } else {
            $active = false;
        }
        return $active;
    }
}