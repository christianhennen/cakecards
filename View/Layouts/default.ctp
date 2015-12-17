<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
date_default_timezone_set('Etc/UTC');
?>
<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $title_for_layout; ?>
    </title>
    <?php
    echo $this->Html->meta('icon');
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css("bootstrap-switch.min");
    echo $this->Html->css('jquery.minicolors');
    echo $this->Html->css('imgareaselect-default');
    echo $this->Html->css('cakecards');
    echo $this->Html->css('jquery_file_upload/jquery.fileupload');
    echo $this->Html->css('jquery_file_upload/jquery.fileupload-ui');
    echo $this->Html->script("jquery-2.1.4.min");
    echo $this->Html->script("bootstrap.min");
    echo $this->Html->script("cakecards");
    echo $this->Html->script("bootstrap-switch.min");
    echo $this->Html->script('jquery.imgareaselect');
    echo $this->Html->script("scroll-top");
    echo $this->Html->script("sprintf.min");
    echo $this->Html->script("jquery.ajaxq-0.0.1");
    echo $this->Html->script("jquery.minicolors.min");
    echo $this->Html->script("jquery.fastLiveFilter");
    echo $this->Html->script("tinymce/tinymce.min");
    echo $this->Html->script("tinymce/jquery.tinymce.min");
    echo $this->Html->script("jquery_file_upload/vendor/jquery.ui.widget");
    echo $this->Html->script("jquery_file_upload/jquery.fileupload");
    echo $this->Html->script("jquery_file_upload/jquery.iframe-transport");

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
    <script type="text/javascript">
        <?php
            echo "var myBaseUrl = '".$this->webroot."';";
            echo "var appLanguage = '".$this->Session->read('Config.language')."';";
            ?>


        function cancelRequests() {
            $.ajaxq('emailQueue');
            $('#mailstatus').text('Versand abgebrochen!');
            $('#cancelButton').hide();
        }

        $(document).ready(function () {

            $('.top').UItoTop();
            $('#font-color-hex').minicolors({
                change: function () {
                    var rgbObj = $('#font-color-hex').minicolors('rgbObject', null);
                    var fontcolor = rgbObj.r + ',' + rgbObj.g + ',' + rgbObj.b;
                    $('#font-color-rgb').attr('value', fontcolor);
                    $('#font-color-rgb').val(fontcolor);
                },
                changeDelay: 200,
                control: 'hue',
                defaultValue: $('#font-color-hex').attr('value'),
                hide: null,
                hideSpeed: 100,
                inline: false,
                letterCase: 'lowercase',
                opacity: false,
                position: 'bottom right',
                show: null,
                showSpeed: 100,
                opacity: false,
                theme: 'bootstrap'
            });

            $('#saveForm').submit(function () {
                var formData = $(this).serialize();
                var formUrl = $(this).attr('action');
                $.ajax({
                    type: 'POST',
                    url: formUrl,
                    data: formData,
                    success: function (data, textStatus, xhr) {
                        $('#container').append(data);
                    },
                    error: function (xhr, textStatus, error) {
                        alert(textStatus);
                    }
                });
                return false;
            });
            <?php echo "var ontext ='".__('Yes')."'; var offtext = '".__('No')."';" ?>
            $("#OptionEditForm").find(":checkbox").bootstrapSwitch({onText: ontext, offText: offtext});
            $("#OptionAddForm").find(":checkbox").bootstrapSwitch({onText: ontext, offText: offtext});
            $("#mailingOptionSwitches").find(":checkbox").bootstrapSwitch({onText: ontext, offText: offtext});
        });

        $('#header > div.alert').delay(1000).hide('highlight', {color: '#66cc66'}, 1500);


    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <?php echo $this->Html->script("html5shiv"); ?>
    <![endif]-->
</head>
<body>
<div id="container">
    <div id="header">
        <?php
        echo $this->Session->flash();
        echo $this->Nav->main(); ?>
    </div>
    <div id="content" class="content-fluid col-sm-11 center-block">
        <?php echo $this->fetch('content'); ?>
    </div>
    <div id="footer">
        <p>&nbsp;</p>
    </div>
</div>
</body>
</html>