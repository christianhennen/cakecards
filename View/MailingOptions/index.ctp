<div class="row">
    <div class="btn-toolbar col-sm-offset-1" role="toolbar">
        <?php echo $this->Html->link(
            $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-plus'))
            . ' ' . __('New mailing options'),
            array('action' => 'add'),
            array('class' => 'btn btn-primary', 'escape' => false)
        ); ?>
    </div>
</div>


<?php
$this->assign('title', __('Mailing options'));

echo "<div class=\"row btn-toolbar\" style='text-align: right' id=\"mailingOptionSwitches\"><label for='testModeSwitch'>" . __('Is test mode active?')
    . " </label> <input type='checkbox' id='testModeSwitch' ";
if (AuthComponent::user('testmode_active') == '1') {
    echo "checked = 'true'";
}
echo ">";
echo "</div>";

$currentSectionName = '';

foreach ($mailing_options as $mailing_option):

    if($mailing_option['Project']['name'] != null) {
        $currentScope = __('Project-wide');
    } else $currentScope = __('Personal');
    if ($currentScope != $currentSectionName) {
        $currentSectionName = $currentScope;
        echo "<div class=\"row sectionHeading\" style=\"margin-top: 20px; margin-bottom:10px;\"><div class=\"col-sm-12 col-xs-12\"><a name=\"section" . $currentSectionName . "\">" . $currentSectionName . "</a></div></div>";
    }

    echo "<div class=\"row\">";
    if ($mailing_option['MailingOption']['id'] == AuthComponent::user('mailing_option_id')) {
        echo "<div class=\"panel panel-success\">";
    } else {
        echo "<div class=\"panel panel-default\">";
    }
    echo "<div class=\"panel-heading\" style=\"min-height:55px;\">
    <div class=\"btn-group\" style=\"float:left\">";
    echo $this->Html->link(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-check')),
        array('action' => 'setActive', $mailing_option['MailingOption']['id']),
        array('class' => 'btn btn-default', 'style' => 'float:left', 'escape' => false)
    );
    echo $this->Html->link(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-pencil')),
        array('action' => 'edit', $mailing_option['MailingOption']['id']),
        array('class' => 'btn btn-default', 'style' => 'float:left', 'escape' => false)
    );
    echo $this->Form->postLink(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')),
        array('action' => 'delete', $mailing_option['MailingOption']['id']),
        array('class' => 'btn btn-danger', 'escape' => false),
        __('Do you really want to delete this mailing option set?')
    );
    echo "
    </div>
    <h3 class=\"panel-title\" style=\" margin-top: 7px; margin-left: 10px; float:left;\">" . $mailing_option['MailingOption']['description'] . "</h3>";
    echo "
        </div>
        <div class=\"panel-body\">
          <div class=\"row\" style=\"padding-left: 30px; padding-right:30px;\">
            <div class=\"col-sm-4 col-xs-6\">
              <div class=\"row\">
                <p style=\"font-weight:bold\">" . __('Mail server') . "</p><p>" . $mailing_option['MailingOption']['server'] . "</p>
              </div>
              <div class=\"row\">
                <p style=\"font-weight:bold\">" . __('Port') . "</p><p>" . $mailing_option['MailingOption']['port'] . "</p>
              </div>
              <div class=\"row\">
                <p style=\"font-weight:bold\">" . __('Use TLS') . "</p><p>";
    if ($mailing_option['MailingOption']['use_tls'] == 1) {
        echo "ja";
    } else echo "nein";
    echo "</p>
              </div>
              <div class=\"row\">
                <p style=\"font-weight:bold\">" . __('Timeout') . "</p><p>" . $mailing_option['MailingOption']['timeout'] . "</p>
              </div>
            </div>
            <div class=\"col-sm-4 col-xs-6\">
              <div class=\"row\">
                <p style=\"font-weight:bold\">" . __('Sender name') . "</p><p>" . $mailing_option['MailingOption']['from_name'] . "</p>
              </div>
              <div class=\"row\"style=\"margin-top: 10px;\">
                <p style=\"font-weight:bold\">" . __('Sender address') . "</p><p>" . $mailing_option['MailingOption']['from_address'] . "</p>
              </div>
              <div class=\"row\"style=\"margin-top: 10px;\">
                <p style=\"font-weight:bold\">" . __('Subject') . "</p><p>" . $mailing_option['MailingOption']['subject'] . "</p>
              </div>
            </div>
            <div class=\"col-sm-4 col-xs-6\">
              <div class=\"row\">
                <p style=\"font-weight:bold\">" . __('Username') . "</p><p>" . $mailing_option['MailingOption']['username'] . "</p>
              </div>
              <div class=\"row\" style=\"margin-top: 10px;\">
                <p style=\"font-weight:bold\">" . __('Password') . "</p><p>***********</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>";

endforeach;
unset($mailing_option); ?>

<script type="text/javascript">
    $('#testModeSwitch').on('switchChange.bootstrapSwitch', function (event, state) {
        if (this.checked) {
            window.location = myBaseUrl + "mailing_options/changeTestMode/1";
        } else {
            window.location = myBaseUrl + "mailing_options/changeTestMode/0";
        }
    });
</script>
