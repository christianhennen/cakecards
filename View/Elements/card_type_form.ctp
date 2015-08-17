<?

echo $this->Form->input('description', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Name'))));
echo $this->Form->input('image_upload_id', array('id' => 'cardUploadId', 'type' => 'hidden'));
echo $this->Form->input('font_upload_id', array('id' => 'fontUploadId', 'type' => 'hidden'));
echo "<div class=\"form-group\">";
echo $this->Form->label('image_button',__('Image'), DEFAULT_LABEL_OPTIONS);
echo "<div class=\"col-sm-2\">";
echo $this->Form->button(__('Choose...'), array('id' => 'mediaGalleryButton','type' => 'button', 'class' => 'btn btn-primary', "data-type" => 'card'));
echo "</div>
<div class=\"col-sm-3\">
<div class=\"thumbnail\" style=\"min-width:200px;\"><img id=\"cardThumbnail\" src=\"";
if (isset($cardtype)) {
    echo $this->webroot."files/".$cardtype['Image']['id']."/".$cardtype['Image']['name'];
}
echo "\">
    <div class=\"caption\">".__('Current image')."</div>
</div>
</div>
</div>";
echo "<div class=\"form-group\">";
echo $this->Form->label('image_button',__('Font'), DEFAULT_LABEL_OPTIONS);
echo "<div class=\"col-sm-2\">";
echo $this->Form->button(__('Choose...'), array('id' => 'mediaGalleryButton','type' => 'button', 'class' => 'btn btn-primary', "data-type" => 'font'));
echo "</div>
<div class=\"col-sm-3\">
<div class=\"thumbnail\" style=\"min-width:200px;\"><img id=\"fontThumbnail\" src=\"";
if (isset($cardtype)) {
    echo $this->webroot."files/".$cardtype['Font']['id']."/preview.png";
}
echo "\">
    <div class=\"caption\">".__('Current font')."</div>
</div>
</div>
</div>";
echo $this->Form->input('font_size', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Font size'))));
echo $this->Form->input('font_color_hex', array('id' => 'font-color-hex', 'label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Font color'))));
echo $this->Form->input('font_color_rgb', array('id' => 'font-color-rgb', 'type' => 'hidden'));
echo $this->Form->input('x_position', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Horizontal starting position'))));
echo $this->Form->input('y_position', array('label' => DEFAULT_LABEL_OPTIONS + array('text' =>  __('Vertical starting position'))));
echo $this->Form->input('rotation', array('label' => DEFAULT_LABEL_OPTIONS + array('text' =>  __('Rotation'))));

?>