<?php

$textAlignmentHorizontal = array('left'=>__('Left'), 'center' => __('Center'), 'right' => __('Right'));
$textAlignmentVertical = array('top' => __('Top'), 'center' => __('Center'), 'bottom' => __('Bottom'));

echo $this->Form->input('description', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Name'))));
echo $this->Form->input('image_upload_id', array('id' => 'cardUploadId', 'type' => 'hidden'));
echo $this->Form->input('font_upload_id', array('id' => 'fontUploadId', 'type' => 'hidden'));
echo "<div class=\"form-group\">";
echo $this->Form->label('image_button', __('Image'), DEFAULT_LABEL_OPTIONS);
echo "<div class=\"col-sm-2\">";
echo $this->Form->button(__('Choose...'), array('id' => 'mediaGalleryButton', 'type' => 'button', 'class' => 'btn btn-primary', "data-type" => 'card'));
echo "</div>
<div class=\"col-sm-3\">
<div class=\"thumbnail\" style=\"min-width:200px;\"><img id=\"cardThumbnail\" src=\"";
if (isset($card)) {
    echo $this->webroot . "files/" . $card['Image']['id'] . "/" . $card['Image']['name'];
}
echo "\">
    <div class=\"caption\">" . __('Current image - click to select textarea') . "</div>
</div>
</div>
</div>";
echo "<div class=\"form-group\">";
echo $this->Form->label('image_button', __('Font'), DEFAULT_LABEL_OPTIONS);
echo "<div class=\"col-sm-2\">";
echo $this->Form->button(__('Choose...'), array('id' => 'mediaGalleryButton', 'type' => 'button', 'class' => 'btn btn-primary', "data-type" => 'font'));
echo "</div>
<div class=\"col-sm-3\">
<div class=\"thumbnail\" style=\"min-width:200px;\"><img id=\"fontThumbnail\" src=\"";
if (isset($card)) {
    echo $this->webroot . "files/" . $card['Font']['id'] . "/preview.png";
}
echo "\">
    <div class=\"caption\">" . __('Current font') . "</div>
</div>
</div>
</div>";
echo $this->Form->input('font_size', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Font size'))));
echo $this->Form->input('font_color_hex', array('id' => 'font-color-hex', 'label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Font color'))));
echo $this->Form->input('font_color_rgb', array('id' => 'font-color-rgb', 'type' => 'hidden'));
echo $this->Form->input('x_position', array('id' => 'x-position', 'type' => 'hidden'));
echo $this->Form->input('y_position', array('id' => 'y-position', 'type' => 'hidden'));
echo $this->Form->input('width', array('id' => 'width', 'type' => 'hidden'));
echo $this->Form->input('height', array('id' => 'height', 'type' => 'hidden'));
echo $this->Form->input('line_height', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Line Height'))));
echo $this->Form->input('text_align_horizontal', array('type'=>'select','options' => $textAlignmentHorizontal, 'empty' => __('--Please select--'), 'label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Horizontal Text Alignment'))));
echo $this->Form->input('text_align_vertical', array('type' => 'select','options' => $textAlignmentVertical, 'empty' => __('--Please select--'), 'label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Vertical Text Alignment'))));