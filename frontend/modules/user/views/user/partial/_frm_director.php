<div class="col-sm-12">
    <div class="tab-pane" id="tab-option">
        <!-- option Fields -->
        <?= $this->render('_frm_field', [
            'form' => $form,
            'model' => $model,
            'modelUserFields'        => $modelUserFields,
            'modelUserFieldValues'   => $modelUserFieldValues,
            'modelUserProfile'       => $modelUserProfile,
        ]);?>
        <!-- option Fields -->
    </div>
</div>
<div class="col-sm-12">
    <div class="tab-pane" id="tab-profile">
        <?= $this->render('_'.$role, [
            'form' => $form,
            'model' => $model,
            'modelUserFields'        => $modelUserFields,
            'modelUserFieldValues'   => $modelUserFieldValues,
            'modelUserProfile'       => $modelUserProfile,
            'modelUserAddress'       => $modelUserAddress,
        ]);?>
    </div>
</div>