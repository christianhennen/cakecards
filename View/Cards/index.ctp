<div class="row">
    <div class="btn-toolbar col-sm-offset-1" role="toolbar">
        <?php echo $this->Html->link(
            $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-plus'))
            . ' ' . __('New card type'),
            array('action' => 'add'),
            array('class' => 'btn btn-primary', 'escape' => false)
        ); ?>
    </div>
</div>

<?php

$textAlignmentHorizontal = array('left' => __('Left'), 'center' => __('Center'), 'right' => __('Right'));
$textAlignmentVertical = array('top' => __('Top'), 'center' => __('Center'), 'bottom' => __('Bottom'));

$this->assign('title', __('Cards'));

foreach ($cards as $card):
    echo "
    <div class=\"row\">
      <div class=\"panel panel-default\">
        <div class=\"panel-heading\">
          <div class=\"btn-group\" style=\"float:left\">";
    echo $this->Html->link(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-pencil')),
        array('action' => 'edit', $card['Card']['id']),
        array('class' => 'btn btn-default', 'escape' => false)
    );
    echo $this->Form->postLink(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')),
        array('action' => 'delete', $card['Card']['id']),
        array('class' => 'btn btn-danger', 'escape' => false),
        __('Do you really want to delete this card type?')
    );
    echo "
          </div>
          <p style=\"font-weight:bold; margin-top: 5px; margin-left: 90px;\">" . $card['Card']['description'] . "</p>
        </div>
        <div class=\"panel-body\">
          <div class=\"row\">
            <div class=\"col-sm-4 col-xs-5\">
              <p style=\"font-weight:bold\">" . __('Image') . "</p>
              <div class=\"thumbnail\"><img src=\"" . $this->webroot . "files/" . $card['Image']['id'] . "/" . $card['Image']['name'] . "\"></div>
            </div>
            <div class=\"col-sm-8 col-xs-12\">
              <div class=\"row\" style=\"margin-bottom:15px;margin-top:30px;\">
                <div class=\"col-sm-6 col-xs-6\">
                  <p style=\"font-weight:bold\">" . __('Font') . "</p><img src=\"" . $this->webroot . "files/" . $card['Font']['id'] . "/preview.png\">
                </div>
                <div class=\"col-sm-6 col-xs-6\">
                  <p style=\"font-weight:bold\">" . __('Horizontal Text Alignment') . "</p>" . $textAlignmentHorizontal[$card['Card']['text_align_horizontal']] . "
                </div>
              </div>
              <div class=\"row\" style=\"margin-bottom:15px;\">
              <div class=\"col-sm-6 col-xs-6\">
                  <p style=\"font-weight:bold\">" . __('Font size') . "</p>" . $card['Card']['font_size'] . "
                </div>
                <div class=\"col-sm-6 col-xs-6\">
                  <p style=\"font-weight:bold\">" . __('Vertical Text Alignment') . "</p>" . $textAlignmentVertical[$card['Card']['text_align_vertical']] . "
                </div>
              </div>
              <div class=\"row\">
                <div class=\"col-sm-6 col-xs-6\">
                  <p style=\"font-weight:bold\">" . __('Font color') . "</p><div class=\"thumbnail\" style=\"height:40px; width:60px;\"><div style=\"height:30px; width:50px; border: 1px solid lightgrey; background-color:" . $card['Card']['font_color_hex'] . "\"></div></div>
                </div>
                <div class=\"col-sm-6 col-xs-6\">
                  <p style=\"font-weight:bold\">" . __('Line Height') . "</p>" . $card['Card']['line_height'] . "
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>";

endforeach;
unset($card); ?>