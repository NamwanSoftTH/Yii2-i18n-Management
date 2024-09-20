<?php $form = \yii\bootstrap5\ActiveForm::begin(['validationUrl' => ['validation', 'id' => (!$model->isNewRecord) ? $model->id : null]]);?>
<div class="row">
    <div class="col-md-6">
        <?=$form->field($model, 'category')->widget(\kartik\select2\Select2::classname(), array_replace_recursive(\Yii::$app->MyClass::$Select2, ['data' => $arList, 'pluginOptions' => ['allowClear' => false]]));?>
    </div>
    <div class="col-md-6">
        <?=$form->field($model, 'message')->textInput();?>
    </div>
</div>
<div class="separator border-bottom-dashed my-3"></div>
<div class="row">
    <?php
        foreach (AR_Lang as $k => $item) {
            if ($k == 'en-US') {continue;}
        ?>
    <div class="col-md-6">
        <?=$form->field($model, "message2[$k]")->textInput(['value' => $model->translat[$k]])->label($item['text']);?>
    </div>
    <?php
    }?>
</div>
<div class="row footer">
    <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary btn-sm"><i class="fad fa-save fs-2 me-2"></i><?=Yii::t('system', 'Save');?></button>
        <button type="reset" class="btn btn-warning btn-sm"><i class="fad fa-history fs-2 me-2"></i><?=Yii::t('system', 'Reset');?></button>
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="fad fa-times fs-2 me-2"></i><?=Yii::t('system', 'Cancel');?></button>
    </div>
</div>
<?php $form::end();?>