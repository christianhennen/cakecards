<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title"><?php echo __('Media Gallery') ?></h3>
            </div>
            <div class="modal-body row">
                <div class="col-sm-12 thumbnail" id="cardPreview" style="display: none"><img id="cardPreviewImg" src=""></div>
                <div class="col-sm-12" id="textSelection" style="display: none"><img class="col-sm-12" id="textSelectionImg" style="padding:0" src="
                <?php if (isset($cardtype)) {
                        echo $this->webroot . "files/" . $cardtype['Image']['id'] . "/" . $cardtype['Image']['name'];
                    }?>
                    "></div>
                <div class="col-sm-5" id="mediaGalleryNav">
                    <p><a href="#" id="fromFileSystem"><? echo __('Choose from file system') ?></a></p>

                    <p><a href="#" id="fromGallery"><? echo __('Choose from image gallery') ?></a></p>
                </div>
                <div class="col-sm-7" id="mediaGallery"></div>
                <div class="col-sm-7" id="mediaGalleryFilesystem" style="display: none">
                    <div class="row">
                        <form id="fileupload" action="<? echo $this->webroot ?>uploads.json" method="POST"
                              enctype="multipart/form-data">
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
                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0"
                                         aria-valuemax="100">
                                        <div class="progress-bar progress-bar-success" style="width:0;"></div>
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
                            <table role="presentation" class="table table-striped">
                                <tbody class="files"></tbody>
                            </table>
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