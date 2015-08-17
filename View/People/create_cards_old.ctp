
  <div class="row center-block">
   <div id="cards" class="col-sm-11 center-block" style="float:none">
   <h1 style="margin-bottom:20px;">Ergebnisse der Karten-Erzeugung</h1>
   <?php 

   $this->assign('title', 'Empfänger');

   foreach ($people as $person): 
   echo "<script>$.get(\"".$this->Html->url(array("controller" => "people", "action" => "createCard", $person['Person']['id']))."\").done(function(html) {
      $(\"#cards\").append(html);
   });</script>";

  endforeach;
  unset($person);
  ?>
</div>
</div>
<a href="#" class="top"></a>
  <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h3 class="modal-title">Detailansicht</h3>
        </div>
        <div class="modal-body">
            <a href="#" class="thumbnail"><img src=""></a>
        </div>
        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal">Schliessen</button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    $(document).on('click','.thumbnail',function(){
      event.preventDefault();
      var title = $(this).parent('a').attr("title");
      $('.modal-title').html(title);
      var person_id = $(this).children('span').html();
      var img_src = '<?php echo $this->webroot."images/"?>' + person_id + '.png'
      $('.modal-body a img').attr('src',img_src);
      $('#myModal').modal({show:true});
    });
  </script>