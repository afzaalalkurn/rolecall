<?php
$this->registerJsFile('https://code.jquery.com/jquery-3.1.1.slim.min.js');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js');
$this->registerJsFile('@web/cropper/dist/cropper.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/cropper/dist/cropper.css');
?>
<!-- Modal -->
<div class="modal fade" id="modal" aria-labelledby="modalLabel" role="dialog" tabindex="-1" data-image-id="" data-refresh="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crop Picture</h5>
            </div>
            <div class="modal-body">
                    <img id="croping-image" src="/uploads/loading.gif" alt="Picture">
            </div>
            <div class="modal-footer">

                <button type="button" id="btn-crop" class="btn btn-default" data-dismiss="modal">Crop</button>
                <button type="button" id="btn-close" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->