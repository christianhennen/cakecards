<div class="row">
    <div class="col-lg-2 col-sm-12 col-xs-12">
        <?php echo "<input id=\"search_input\" placeholder=\"" . __('Search') . "\">"; ?>
    </div>
    <div class="col-lg-4 col-sm-5 col-xs-12"><span id="letterSelector"></span></div>
    <div id="peopleToolbar" class="btn-toolbar col-lg-6 col-sm-7 col-xs-12"
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
            $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-envelope'))
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
        $('a[href="#section' + letter + '"]').click(function () {
            event.preventDefault();
            scrollToLetter(letter);
        });
    }

    $(function () {
        var inputfield = $('#search_input');
        var letterSelector = $('#letterSelector');
        inputfield.fastLiveFilter('#people .person_name', {
            timeout: 200,
            callback: function () {
                var text = inputfield.val();
                if (text == '') {
                    letterSelector.show();
                    $('.person_row').show();
                } else {
                    var person_rows = $('.person_row');
                    person_rows.show();
                    letterSelector.hide();
                    person_rows.has('.person_name p:hidden').hide();
                    $('.sectionHeading').hide();
                }
            }
        });
    });
</script>

<?php

$this->assign('title', __('Recipients'));
$currentSectionLetter = '';
$time = time();
echo "<div id=\"people\">";
foreach ($people as $person):

    $thumbnail_path = $this->webroot . "images/thumbnails/" . $person['Person']['id'] . ".png";

    $currentSurnameLetter = String::truncate($person['Person']['surname'], 1, array('ellipsis' => '', 'exact' => true, 'html' => false));
    if ($currentSurnameLetter != $currentSectionLetter) {
        $currentSectionLetter = $currentSurnameLetter;
        echo "<div class=\"row sectionHeading\" style=\"margin-top: 20px; margin-bottom:10px;\"><div class=\"col-sm-12 col-xs-12\"><a name=\"section" . $currentSectionLetter . "\">" . $currentSectionLetter . "</a></div></div>";
        echo "<script> appendLetter('" . $currentSectionLetter . "'); </script>";
    }

    echo "<div class=\"row person_row\">
	  <div class=\"col-sm-3 col-xs-3\">
	    <div class=\"row\">
	        <div class=\"col-sm-2 col-xs-2\">
		    <input type=\"checkbox\" name=\"person\" id=\"" . $person['Person']['id'] . "\">
		    </div>
		    <div class=\"col-sm-10 col-xs-10 person_name\"><p>" . $person['Person']['surname'] . ", " . $person['Person']['prename'] . "</p></div>
		</div>
	  </div>

	  <div class=\"col-sm-3 col-xs-12\"><p>" . $person['Person']['salutation'] . "</p></div>
	  <div class=\"col-sm-3 col-xs-12\"><p>" . $person['Person']['email'] . "</p></div>
	  <div class=\"col-sm-1 col-xs-4\"><a href=\"#\" class=\"thumbnail\" style=\"margin-bottom:10px;\"><img src=\"" . $thumbnail_path . "?" . $time . "\"><span class=\"hidden\">" . $person['Person']['id'] . "</span></a>
	  </div>
	  <div class=\"col-sm-2 col-xs-4\">
		<div class=\"btn-group\">";
    echo $this->Html->link(
        __('Edit'),
        array('action' => 'edit', $person['Person']['id']),
        array('class' => 'btn btn-default', 'escape' => false)
    );
    echo "<button type=\"button\" class=\"btn btn-default dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
				<span class=\"caret\"></span>
				<span class=\"sr-only\">" . __('Toggle dropdown') . "</span>
			</button>
			<ul class=\"dropdown-menu\">
			<li>";
    echo $this->Form->postLink(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-envelope')) . ' ' . __('Send'),
        array('action' => 'sendEmails', $person['Person']['id']),
        array('class' => '', 'escape' => false),
        __('Do you really want to send this card?')
    );
    echo "</li>
			<li role=\"separator\" class=\"divider\"></li>
			<li>";
    echo $this->Form->postLink(
        $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-trash')) . ' ' . __('Delete'),
        array('action' => 'delete', $person['Person']['id']),
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
<?php unset($person); ?>
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
    $(document).on('click', '.thumbnail', function () {
        event.preventDefault();
        var title = $(this).parent('a').attr("title");
        $('.modal-title').html(title);
        var person_id = $(this).children('span').html();
        var seconds = new Date().getTime() / 1000;
        var img_src = '<?php echo $this->webroot."images/"?>' + person_id + '.png?'+seconds;
        $('.modal-body a img').attr('src', img_src);
        $('#myModal').modal({show: true});
    });
    $(document).on('click', '[name="person"]', function () {
        var checked = $(':checked');
        var sendEmailsButton = $('#sendEmailsButton');
        var sendEmailsInput = $('#sendEmailsInput');
        var deleteMultipleButton = $('#deleteMultipleButton');
        var deleteMultipleInput = $('#deleteMultipleInput');
        var ids = '';
        if (checked.length == 0) {
            sendEmailsInput.remove();
            deleteMultipleButton.hide();
            <? echo "var buttonMessage = '<span class=\"glyphicon glyphicon-envelope\"></span> ".__('<span class="hidden-xs">Send</span> all')."';" ?>
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
            <? echo "var buttonMessage = '<span class=\"glyphicon glyphicon-envelope\"></span> ".__('<span class="hidden-xs">Send</span> selected')."';" ?>
            sendEmailsButton.html(buttonMessage);
            deleteMultipleButton.show();

        }
    });

</script>
