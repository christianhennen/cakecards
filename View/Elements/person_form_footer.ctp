<?php
echo '<div class="col-sm-8" style="color:#999999; margin-bottom: 50px;">
    <div class="row" style="font-weight:bold;">
        <div class="col-sm-2 col-xs-2"><p>' . __('Text number') . '</p></div>
        <div class="col-sm-2 col-xs-2"><p>' . __('Type') . '</p></div>
        <div class="col-sm-8 col-xs-8"><p>' . __('Text') . '</p></div>
    </div>';

foreach ($cardtexts2 as $cardtext2):
    echo "<div class=\"row\">
        <div class=\"col-sm-2 col-xs-2\"><p>" . $cardtext2['CardText']['id'] . "</p></div>
        <div class=\"col-sm-2 col-xs-2\"><p>" . $cardtext2['CardType']['description'] . "</p></div>
        <div class=\"col-sm-8 col-xs-8\"><p>" . $cardtext2['CardText']['text'] . "</p></div>

         </div>";
endforeach;
unset($cardtexts2);