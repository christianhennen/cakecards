$(function () {
    var filesList = [];
    $('#fileupload').fileupload({
        dataType: 'json',
        autoUpload: false,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|ttf)$/i,
        fileInput: $('#inputUploadFile'),
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
            $.each(data.files, function (index, file) {
                filesList.push(data.files[index]);
            });
            var text = "file";
            if (filesList.length > 1) text = "files";
            $('.startupload-button span').text(sprintf('Upload %d %s', filesList.length, text));
        },
        done: function (e, data) {
            $('.upload-progress').text('Done!').show();
            var error = data.result.files[0].error;
            if (!error) {
                var id = data.result.files[0].id;
                $.each(filesList, function (index, file) {
                    if (file.name == data.result.files[0].name)
                        filesList.splice(index, 1);
                });
                $.ajax({
                    type: 'GET',
                    url: myBaseUrl + 'uploads/index/' + id,
                    success: function (data, textStatus, xhr) {
                        $('#uploadedFiles').append(data);
                    },
                    error: function (xhr, textStatus, error) {
                        console.log(textStatus);
                    }
                });
            } else {
                $('.upload-progress').text(error).show();
            }

        },
        fail: function (e, data) {
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

$(document).on('click', '#previewButton', function (event) {
    event.preventDefault();
    $('#mediaGalleryFilesystem').hide();
    $('#mediaGallery').hide();
    $('#mediaGalleryNav').hide();
    $('#textSelection').hide();
    var form = $('form').filter(function () {
        return this.id.match(/CardType[A-z]*Form/g);
    });
    $.ajax({
        type: 'POST',
        url: myBaseUrl + 'card_types/preview/',
        data: form.serialize(),
        success: function (data, textStatus, xhr) {
            $('#cardPreview').html(data).show();
        },
        error: function (xhr, textStatus, error) {
            $('#cardPreview').html(textStatus);
        }
    });
    $('#myModal').modal({show: true});
});
$(document).on('click', '#cardThumbnail', function (event) {
    event.preventDefault();
    $('#mediaGalleryFilesystem').hide();
    $('#mediaGallery').hide();
    $('#mediaGalleryNav').hide();
    $('#cardPreview').hide();
    var textSelection = $('#textSelection');
    textSelection.show();
    var myModal = $('#myModal');
    var textSelectionImg = $('#textSelectionImg');
    myModal.on('shown.bs.modal',function(event) {
        var x = $('#x-position');
        var y = $('#y-position');
        var width = $('#width');
        var height = $('#height');
        console.log('x:'+x.val()+' , y: '+y.val()+' , width: '+width.val()+' , height: '+height.val());
        if (x.val()=='' && y.val()=='' && width.val()=='' && height.val()=='') {
            x.val(20); y.val(20); width.val(textSelectionImg[0].naturalWidth/2); height.val(textSelectionImg[0].naturalHeight/2);
        }
        var x2 = Number(x.val())+Number(width.val());
        var y2 = Number(y.val())+Number(height.val());
        textSelectionImg.imgAreaSelect({ x1:Number(x.val()), y1:Number(y.val()), x2:x2, y2:y2, imageHeight:textSelectionImg[0].naturalHeight, imageWidth:textSelectionImg[0].naturalWidth, parent:'.modal-content', handles: true , show: true,
            onSelectEnd: function (img, selection) {
            x.val(selection.x1);
            y.val(selection.y1);
            width.val(selection.width);
            height.val(selection.height);
        }});
        textSelectionImg.imgAreaSelect({remove:false});
    });
    myModal.on('hidden.bs.modal', function() {
        textSelectionImg.imgAreaSelect({remove:true});
    });
    myModal.modal({show: true});
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
    $('#cardPreview').hide();
    $('#textSelection').hide();
    $('#mediaGallery').show();
    $('#mediaGalleryNav').show();
    modal.attr('type', type);

    $.ajax({
        type: 'GET',
        url: myBaseUrl + 'uploads/index?type=' + type,
        success: function (data, textStatus, xhr) {
            $('#mediaGallery').html(data);
        },
        error: function (xhr, textStatus, error) {
            console.log(textStatus);
        }
    });
    modal.modal({show: true});
});
$(document).on('click', '#fromFileSystem', function (event) {
    event.preventDefault();
    $('#mediaGalleryFilesystem').show();
    $('#mediaGallery').hide();
    $('#cardPreview').hide();
    $('#textSelection').hide();
});
$(document).on('click', '#fromGallery', function (event) {
    event.preventDefault();
    $('#mediaGalleryFilesystem').hide();
    $('#mediaGallery').show();
    $('#cardPreview').hide();
    $('#textSelection').hide();
});
$(document).on('click', '#mediaGallery .thumbnail , #mediaGalleryFilesystem .thumbnail', function (event) {
    event.preventDefault();
    var modal = $('#myModal');
    var type = modal.attr('type');
    $('#' + type + 'UploadId').val($(this).attr('upload_id'));
    $('#' + type + 'Thumbnail').attr('src', ($(event.target).attr('src')));
    if (type == 'card') {$('#textSelectionImg').attr('src', ($(event.target).attr('src')));}
    modal.modal('hide');
});