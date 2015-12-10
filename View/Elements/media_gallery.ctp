<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title"><?php echo __('Media Gallery') ?></h3>
            </div>
            <div class="modal-body row">
                <div class="col-sm-12" id="cardPreview" style="display: none"></div>
                <div class="col-sm-5" id="mediaGalleryNav">
                    <p><a href="#" id="fromFileSystem"><? echo __('Choose from file system') ?></a></p>
                    <p><a href="#" id="fromGallery"><? echo __('Choose from image gallery') ?></a></p>
                </div>
                <div class="col-sm-7" id="mediaGallery"></div>
                <div class="col-sm-7" id="mediaGalleryFilesystem" style="display: none">
                    <div class="row">
                        <form id="fileupload" action="<? echo $this->webroot ?>uploads.json" method="POST" enctype="multipart/form-data">
                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                            <div class="row fileupload-buttonbar">
                                <div class="col-xs-12">
                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                    <span class="btn btn-success fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span><? echo __('Add files...') ?></span>
                                        <input type="file" id="inputUploadFile" name="data[files]" multiple>
                                        <input type="hidden" id="inputUploadType" name="data[type]" value="">
                                    </span>
                                    <span class="btn btn-primary startupload-button" style="display: none">
                                        <i class="glyphicon glyphicon-upload"></i>
                                        <span><? echo __('Upload %d files') ?></span>
                                    </span>
                                    <span class="btn btn-primary startupload-button2" style="display: none">
                                        <i class="glyphicon glyphicon-upload"></i>
                                        <span><? echo __('Upload %d files') ?></span>
                                    </span>
                                    <!-- The global file processing state -->
                                    <span class="fileupload-process"></span>
                                </div>
                                <!-- The global progress state -->
                                <div class="col-xs-12 fileupload-progress fade">
                                    <!-- The global progress bar -->
                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                    </div>
                                    <!-- The extended global progress state -->
                                    <div class="progress-extended">&nbsp;</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <p class="upload-progress"></p>
                                </div>
                            </div>
                            <div class="row" id="uploadedFiles">

                            </div>
                            <!-- The table listing the files available for upload/download -->
                            <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                        </form>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal"><?php echo __('Close') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(function () {
        var filesList = new Array();
        $('#fileupload').fileupload({
            dataType: 'json',
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png|ttf)$/i,
            fileInput:$('#inputUploadFile'),
            add: function (e, data) {
                var startButton = $('.startupload-button');
                if (!startButton.length) {
                    $('.startupload-button2').clone().insertAfter('.fileinput-button:last').removeClass('startupload-button2').addClass('startupload-button').show();
                }
                data.context = $('.startupload-button')
                    .click(function () {
                        data.context = $('.upload-progress').text('Uploading...').replaceAll($(this)).show();
                        data.submit();
                    }).show();
                $.each(data.files, function(index, file) {
                    filesList.push(data.files[index]);
                })
                var text = "file";
                if (filesList.length > 1) text = "files";
                $('.startupload-button span').text(sprintf('Upload %d %s',filesList.length,text));
            },
            done: function (e, data) {
                $('.upload-progress').text('Done!').show();
                var error = data.result.files[0].error;
                if (!error) {
                    var id = data.result.files[0].id;
                    $.each(filesList, function(index,file) {
                        if(file.name == data.result.files[0].name)
                            filesList.splice(index,1);
                    });
                    $.ajax({
                        type: 'GET',
                        url: myBaseUrl+'uploads/index/'+id,
                        success: function(data,textStatus,xhr){
                            $('#uploadedFiles').append(data);
                        },
                        error: function(xhr,textStatus,error){
                            console.log(textStatus);
                        }});
                } else {
                    $('.upload-progress').text(error).show();
                }

            },
            fail: function(e,data) {
                console.log("Request failed: " + data.textStatus + " " + data.errorThrown);
                $('.upload-progress').html(data._response.jqXHR.responseText).show();
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .bar').css(
                    'width',
                    progress + '%'
                );
            }
        });
    });

    $(document).on('click', '#previewButton', function () {
        event.preventDefault();
        $('#cardPreview').html('');
        $('#mediaGalleryFilesystem').hide();
        $('#mediaGallery').hide();
        $('#mediaGalleryNav').hide();
        var id = $('#CardTypeId').val();
        var form = $('form').filter(function() {
            return this.id.match(/CardType[A-z]*Form/g);
        });
        $.ajax({
            type: 'POST',
            url: myBaseUrl+'cardtypes/preview/'+id,
            data: form.serialize(),
            success: function(data,textStatus,xhr){
                $('#cardPreview').html(data).show();
            },
            error: function(xhr,textStatus,error){
                $('#cardPreview').html(textStatus);
            }});
        $('#myModal').modal({show: true});
    });
    $(document).on('click', '#mediaGalleryButton', function (event) {
        event.preventDefault();
        var modal = $('#myModal');
        var type = $(event.target).attr('data-type');
        $('#inputUploadType').val(type);
        $('#inputUploadFile').val('');
        $('#uploadedFiles').html('');
        $('.upload-progress').hide();
        $('#mediaGalleryFilesystem').hide();
        $('#mediaGallery').show();
        $('#cardPreview').hide();
        $('#mediaGalleryNav').show();
        modal.attr('type',type);

        $.ajax({
            type: 'GET',
            url: myBaseUrl+'uploads/index?type='+type,
            success: function(data,textStatus,xhr){
                $('#mediaGallery').html(data);
            },
            error: function(xhr,textStatus,error){
                alert(textStatus);
            }});
        modal.modal({show: true});
    });
    $(document).on('click', '#fromFileSystem', function () {
        event.preventDefault();
        $('#mediaGalleryFilesystem').show();
        $('#mediaGallery').hide();
        $('#cardPreview').hide();
        //resetFileUpload();
    });
    $(document).on('click', '#fromGallery', function () {
        event.preventDefault();
        $('#mediaGalleryFilesystem').hide();
        $('#mediaGallery').show();
        $('#cardPreview').hide();
    });
    $(document).on('click', '#myModal .thumbnail', function (event) {
        event.preventDefault();
        var modal = $('#myModal');
        var type = modal.attr('type');
        $('#'+type+'UploadId').val($(this).attr('upload_id'));
        $('#'+type+'Thumbnail').attr('src',($(event.target).attr('src')));
        modal.modal('hide');
    });
</script>