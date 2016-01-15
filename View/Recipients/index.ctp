<div class="row">
    <div class="col-lg-2 col-sm-12 col-xs-12">
        <?php echo "<input id=\"search_input\" placeholder=\"" . __('Search') . "\">"; ?>
    </div>
    <div class="col-lg-4 col-sm-5 col-xs-12"><span id="letterSelector"></span></div>
    <div id="recipientsToolbar" class="btn-toolbar col-lg-6 col-sm-7 col-xs-12"
         role="toolbar">
        <?php
        echo $this->Html->link(
            $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-plus'))
            . ' ' . __('<span class="hidden-xs">New</span> recipient'),
            array('action' => 'add'),
            array('class' => 'btn btn-primary', 'escape' => false)
        );
        echo $this->Html->link(
            $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-list-alt'))
            . ' ' . __('<span class="hidden-xs">Export to</span> Excel'),
            array('action' => 'exportExcel'),
            array('class' => 'btn btn-default', 'escape' => false)
        );
        echo $this->Form->postLink(
            $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-send'))
            . ' ' . __('<span class="hidden-xs">Send</span> all'),
            array('action' => 'sendEmails'),
            array('id' => 'sendEmailsButton', 'class' => 'btn btn-warning', 'escape' => false),
            __('Do you really want to send all cards at once?')
        );
        echo $this->Form->postLink(
            $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash'))
            . ' ' . __('<span class="hidden-xs">Delete</span> selected'),
            array('action' => 'delete'),
            array('id' => 'deleteMultipleButton', 'class' => 'btn btn-danger', 'style' => 'display:none', 'escape' => false),
            __('Do you really want to delete the specified recipients?')
        ); ?>
    </div>
</div>

<script type="text/javascript">

    function scrollToLetter(letter) {
        $('html, body').animate({
            scrollTop: $("a[name='section" + letter + "']").offset().top - 70
        }, 500);
    }

    function appendLetter(letter) {
        $('#letterSelector').append('<a href="#section' + letter + '">' + letter + '</a> ');
        $('a[href="#section' + letter + '"]').click(function (event) {
            event.preventDefault();
            scrollToLetter(letter);
        });
    }

    $(function () {
        var inputfield = $('#search_input');
        var letterSelector = $('#letterSelector');
        inputfield.fastLiveFilter('#recipients .recipient_name', {
            timeout: 200,
            callback: function (total) {
                var text = inputfield.val();
                if (text != '') {
                    var recipient_rows = $('.recipient_row');
                    recipient_rows.show();
                    letterSelector.hide();
                    recipient_rows.has('.recipient_name p:hidden').hide();
                    $('.sectionHeading').hide();
                }
            }
        });
        inputfield.on('input', function(event) {
            // Listen to the input event in case the user clicks the clear button in MSIE,
            // since it only fires the input event and the fastLiveFilter callback therefore isn't called
            if (event.target.value == '') {
                letterSelector.show();
                $('.recipient_row').show();
                $('.recipient_name p:hidden').show();
            }
        });
    });
</script>

<?php

$this->assign('title', __('Recipients'));
$currentSectionLetter = '';
$time = time();
echo "<div id=\"recipients\">";
//TODO: Add a placeholder when there is no recipient in the DB. Link to Card Type Creation first, then to Card Text Creation.
foreach ($recipients as $recipient):

    $thumbnail_path = $this->webroot . "images/thumbnails/" . $recipient['Recipient']['id'] . ".png";

    $currentSurnameLetter = CakeText::truncate($recipient['Recipient']['surname'], 1, array('ellipsis' => '', 'exact' => true, 'html' => false));
    if ($currentSurnameLetter != $currentSectionLetter) {
        $currentSectionLetter = $currentSurnameLetter;
        echo "<div class=\"row sectionHeading\" style=\"margin-top: 20px; margin-bottom:10px;\"><div class=\"col-sm-12 col-xs-12\"><a name=\"section" . $currentSectionLetter . "\">" . $currentSectionLetter . "</a></div></div>";
        echo "<script> appendLetter('" . $currentSectionLetter . "'); </script>";
    }

    echo "<div class=\"row recipient_row\">
	  <div class=\"col-sm-3 col-xs-3\">
	    <div class=\"row\">
	        <div class=\"col-sm-2 col-xs-2\">
		    <input type=\"checkbox\" name=\"recipient\" id=\"" . $recipient['Recipient']['id'] . "\">
		    </div>
		    <div class=\"col-sm-10 col-xs-10 recipient_name\"><p>" . $recipient['Recipient']['surname'] . ", " . $recipient['Recipient']['prename'] . "</p></div>
		</div>
	  </div>

	  <div class=\"col-sm-3 col-xs-12\"><p>" . $recipient['Recipient']['salutation'] . "</p></div>
	  <div class=\"col-sm-3 col-xs-12\"><p>" . $recipient['Recipient']['email'] . "</p></div>
	  <div class=\"col-sm-1 col-xs-4\"><a href=\"#\" class=\"thumbnail\" style=\"margin-bottom:10px;\"><img src=\"" . $thumbnail_path . "?" . $time . "\"><span class=\"hidden\">" . $recipient['Recipient']['id'] . "</span></a>
	  </div>
	  <div class=\"col-sm-2 col-xs-4\">
		<div class=\"btn-group\">";
    echo $this->Html->link(
        __('Edit'),
        array('action' => 'edit', $recipient['Recipient']['id']),
        array('class' => 'btn btn-default', 'escape' => false)
    );
    echo "<button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
				<span class=\"caret\"></span>
				<span class=\"sr-only\">" . __('Toggle dropdown') . "</span>
			</button>
			<ul class=\"dropdown-menu\">
			<li>";
    echo $this->Form->postLink(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-send')) . ' ' . __('Send'),
        array('action' => 'sendEmails', $recipient['Recipient']['id']),
        array('class' => '', 'escape' => false),
        __('Do you really want to send this card?')
    );
    echo "</li>
			<li role=\"separator\" class=\"divider\"></li>
			<li>";
    echo $this->Form->postLink(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')) . ' ' . __('Delete'),
        array('action' => 'delete', $recipient['Recipient']['id']),
        array('class' => '', 'escape' => false),
        __('Do you really want to delete this recipient?')
    );
    echo "</li>
			</ul>
		</div>
	   </div>
	  </div>";
    ?>
<?php endforeach; ?>
<?php unset($recipient); ?>
<a href="#" class="top"></a>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title"><?php echo __('Detail view') ?></h3>
            </div>
            <div class="modal-body">
                <a href="#" class="thumbnail"><img src=""></a>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?php echo __('Close') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '.thumbnail', function (event) {
        event.preventDefault();
        var title = $(this).parent('a').attr("title");
        $('.modal-title').html(title);
        var recipient_id = $(this).children('span').html();
        var seconds = new Date().getTime() / 1000;
        var img_src = '<?php echo $this->webroot."images/"?>' + recipient_id + '.png?'+seconds;
        $('.modal-body a img').attr('src', img_src);
        $('#myModal').modal({show: true});
    });
    $(document).on('click', '[name="recipient"]', function () {
        var checked = $(':checked');
        var sendEmailsButton = $('#sendEmailsButton');
        var sendEmailsInput = $('#sendEmailsInput');
        var deleteMultipleButton = $('#deleteMultipleButton');
        var deleteMultipleInput = $('#deleteMultipleInput');
        var ids = '';
        if (checked.length == 0) {
            sendEmailsInput.remove();
            deleteMultipleButton.hide();
            <?php echo "var buttonMessage = '<span class=\"glyphicon glyphicon-envelope\"></span> ".__('<span class="hidden-xs">Send</span> all')."';" ?>
            sendEmailsButton.html(buttonMessage);
        } else {
            for (var i = 0; i < checked.length; i++) {
                ids += $(checked[i]).attr('id');
                if (i != checked.length - 1) {
                    ids += ',';
                }
            }
            var sendText = '<input type="hidden" id="sendEmailsInput" name="data[ids]" value="' + ids + '"/>';
            var deleteText = '<input type="hidden" id="deleteMultipleInput" name="data[ids]" value="' + ids + '"/>';
            if (sendEmailsInput.length == 0) {
                sendEmailsButton.prev().append(sendText);
                deleteMultipleButton.prev().append(deleteText);
            } else {
                sendEmailsInput.attr('value', ids);
                deleteMultipleInput.attr('value', ids);

            }
            <?php echo "var buttonMessage = '<span class=\"glyphicon glyphicon-envelope\"></span> ".__('<span class="hidden-xs">Send</span> selected')."';" ?>
            sendEmailsButton.html(buttonMessage);
            deleteMultipleButton.show();

        }
    });

</script>
