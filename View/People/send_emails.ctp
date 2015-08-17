<div class="row center-block">
   <div id="mails" class="col-sm-11 center-block" style="float:none">

<? echo "<h1>".__('Results of mail delivery')."</h1>";

    $counter = count($people);

   echo "<h2 id=\"mailstatus\" style=\"margin-bottom:20px;\">"
        .__("%d e-mail(s) to send",$counter)
        ."</h2><button onclick=\"cancelRequests()\" id=\"cancelButton\" class=\"btn btn-danger\" style=\"margin-bottom:20px;\">
                <span class=\"glyphicon glyphicon-remove\"></span> ".__('Cancel')."</button>";

   $this->assign('title', __('Mail delivery'));

   foreach ($people as $person): 
    $counter--;
    echo "<p id=\"person".$person['Person']['id']."\">".__('Recipient').": ".$person['Person']['surname'].", ".$person['Person']['prename']." - </p>";
   	echo 
    "<script>
      $.ajaxq('emailQueue',{ 
        url: '".$this->Html->url(array("controller" => "people", "action" => "sendEmail", $person['Person']['id']))."',
        cache: false, 
        success: function(html)
        {
          $(\"#person".$person['Person']['id']."\").append(html); ";
          if ($counter == 0) {
           echo "$('#mailstatus').text('".__('E-mail(s) successfully send!')."');
           $('#cancelButton').hide();";
          } else {
           echo "$('#mailstatus').text('".__('%d e-mail(s) to send',$counter)."');";
          }
        echo "
        }
  	 });
   </script>";

  endforeach;
  unset($person);
  ?>
</div>
</div>