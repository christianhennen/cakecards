<div class="row center-block">
    <div id="mails" class="col-sm-11 center-block" style="float:none">

        <?php echo "<h1>" . __('Results of mail delivery') . "</h1>";

        $counter = count($recipients);

        echo "<h2 id=\"mailstatus\" style=\"margin-bottom:20px;\">"
            . __("%d e-mail(s) to send", $counter)
            . "</h2><button onclick=\"cancelRequests()\" id=\"cancelButton\" class=\"btn btn-danger\" style=\"margin-bottom:20px;\">
                <span class=\"glyphicon glyphicon-remove\"></span> " . __('Cancel') . "</button>";

        $this->assign('title', __('Mail delivery'));

        foreach ($recipients as $recipient):
            $counter--;
            echo "<p id=\"recipient" . $recipient['Recipient']['id'] . "\">" . __('Recipient') . ": " . $recipient['Recipient']['surname'] . ", " . $recipient['Recipient']['prename'] . " - </p>";
            echo
                "<script>
      $.ajaxq('emailQueue',{ 
        url: '" . $this->Html->url(array("controller" => "recipients", "action" => "sendEmail", $recipient['Recipient']['id'])) . "',
        cache: false, 
        success: function(html)
        {
          $(\"#recipient" . $recipient['Recipient']['id'] . "\").append(html); ";
            if ($counter == 0) {
                echo "$('#mailstatus').text('" . __('E-mail(s) successfully sent!') . "');
           $('#cancelButton').hide();";
            } else {
                echo "$('#mailstatus').text('" . __('%d e-mail(s) to send', $counter) . "');";
            }
            echo "
        }
  	 });
   </script>";

        endforeach;
        unset($recipient);
        ?>
    </div>
</div>