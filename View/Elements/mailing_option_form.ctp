<?php
if (isset($mailing_option) && $mailing_option['MailingOption']['project_id'] != '' && $mailing_option['MailingOption']['user_id'] == '') {
    $is_projectwide = true;
} else {
    $is_projectwide = false;
}
echo $this->Form->input('project_id', array('id' => 'projectId', 'type' => 'hidden'));
echo $this->Form->input('description', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Description'))));
echo $this->Form->input('subject', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Subject'))));
if ($superadmin || $admin) {
    echo $this->Form->input('is_projectwide', array('type' => 'checkbox', 'checked' => $is_projectwide, 'label' => false, 'before' => '<label for="MailingOptionIsProjectwide" class="' . DEFAULT_LABEL_OPTIONS['class'] . '">' . __('Is this configuration project-wide?') . '</label>'));
}
echo "<hr/>";
echo $this->Form->input('signature', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Signature')), 'between' => '<div class="col-sm-9">'));
echo "<div class=\"form-group\">";
echo $this->Form->label('image_button', __('Image'), DEFAULT_LABEL_OPTIONS);
echo "<div class=\"col-sm-2\">";
echo $this->Form->button(__('Choose...'), array('id' => 'mediaGalleryButton', 'type' => 'button', 'class' => 'btn btn-primary', "data-type" => 'signature'));
echo "</div>
<div class=\"col-sm-3\">
<div class=\"thumbnail\" style=\"min-width:200px;\"><img id=\"signatureThumbnail\" src=\"";
if (isset($mailing_option) && $mailing_option['MailingOption']['upload_id'] != '') {
    echo $this->webroot . "files/" . $mailing_option['MailingOption']['upload_id'] . "/" . $mailing_option['Upload']['name'];
}
echo "\">
    <div class=\"caption\">" . __('Current image') . "</div>
</div>
</div>
</div>";
echo $this->Form->input('upload_id', array('id' => 'signatureUploadId', 'type' => 'hidden'));
echo "<hr/>";
echo $this->Form->input('server', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Mail server'))));
echo $this->Form->input('port', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Port'))));
echo $this->Form->input('timeout', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Time until timeout in ms'))));
echo $this->Form->input('use_tls', array('label' => false, 'before' => '<label for="MailingOptionUseTls" class="' . DEFAULT_LABEL_OPTIONS['class'] . '">' . __('Does the server use TLS?') . '</label>'));
echo "<hr/>";
echo $this->Form->input('from_address', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Sender address'))));
echo $this->Form->input('from_name', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Sender name'))));
echo $this->Form->input('username', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Username'))));
echo $this->Form->input('password', array('label' => DEFAULT_LABEL_OPTIONS + array('text' => __('Password'))));

?>
<script type="text/javascript">
    <?php echo "var templateTitle = '".__('Signature image')."';";
echo "var templateDesc = '".__('The following placeholder will be inserted into the signature.')."';";
?>
    $(document).ready(function () {

        tinymce.init({
            selector: "#MailingOptionSignature",
            language: appLanguage,
            plugins: "template link colorpicker image textcolor code",
            toolbar: "template link forecolor backcolor alignleft aligncenter alignright alignjustify fontselect fontsizeselect code",
            relative_urls: true,
            document_base_url: myBaseUrl,
            menu: {
                edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
                insert: {title: 'Insert', items: 'link template anchor'},
                view: {title: 'View', items: 'visualaid'},
                format: {
                    title: 'Format',
                    items: 'bold italic underline strikethrough superscript subscript | removeformat'
                },
                tools: {title: 'Tools', items: 'spellchecker code'}
            },
            templates: [
                {"title": templateTitle, "description": templateDesc, "content": '[signature_image]'}
            ]
        });
    });
</script>
