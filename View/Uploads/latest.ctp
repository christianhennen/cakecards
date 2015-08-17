<?
    $path = $this->webroot.'files/'.$upload['Upload']['id'].'/'.$upload['Upload']['name'];
    if ($upload['Upload']['type'] == 'font') {
        $path = $this->webroot.'files/'.$upload['Upload']['id'].'/preview.png';
    }
    echo '<div class="col-sm-6"><a href="" class="thumbnail" upload_id="'.$upload['Upload']['id'].'">
    <img src="'.$path.'"></a>
    </div>';

?>