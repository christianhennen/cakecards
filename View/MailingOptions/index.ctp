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
if ($user['User']['testmode_active'] == '1') {
    echo "checked = 'true'";
}
echo ">";
echo "</div>";

$currentSectionTitle = '';
foreach ($mailing_options as $mailing_option):
    $currentCard = $mailing_option['Card']['description'];
    if ($currentCard != $currentSectionTitle) {
        $currentSectionTitle = $currentCard;
        echo "<div class=\"row\" style=\"margin-top: 20px; margin-bottom:10px;\"><div class=\"col-sm-12 col-xs-12\"><a name=\"section" . $currentSectionTitle . "\">" . $currentSectionTitle . "</a></div></div>";
    }
    echo
    "<div class=\"row\">";
    if ($mailing_option['MailingOption']['is_testmode'] == $user['User']['testmode_active']) {
        echo "<div class=\"panel panel-success\">";
    } else {
        echo "<div class=\"panel panel-danger\">";
    }
    echo "<div class=\"panel-heading\" style=\"min-height:55px;\">";
    echo $this->Html->link(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-pencil')),
        array('action' => 'edit', $mailing_option['MailingOption']['id']),
        array('class' => 'btn btn-default', 'style' => 'float:left', 'escape' => false)
    );
    echo "<h3 class=\"panel-title\" style=\" margin-top: 7px; margin-left: 10px; float:left;\">" . $mailing_option['MailingOption']['description'] . "</h3>";
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
                <p style=\"font-weight:bold\">" . __('Sender address') . "</p><p>" . $mailing_option['MailingOption']['from_adress'] . "</p>
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
            window.location = myBaseUrl + "mailing_options/changeMailingMode/2";
        } else {
            window.location = myBaseUrl + "mailing_options/changeMailingMode/0";
        }
    });
    $('#recipientModeSwitch').on('switchChange.bootstrapSwitch', function (event, state) {
        if (this.checked) {
            window.location = myBaseUrl + "mailing_options/changeMailingMode/2";
        } else {
            window.location = myBaseUrl + "mailing_options/changeMailingMode/1";
        }
    });
</script>
