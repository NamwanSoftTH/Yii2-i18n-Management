<?php
    use namwansoft\i18nManagement\models\i18nMsg;
    $form = \yii\bootstrap5\ActiveForm::begin([
        'id'                     => 'form-action',
        'enableClientValidation' => true,
        'enableAjaxValidation'   => true,
        'validationUrl'          => ['validation', 'id' => (!$model->isNewRecord) ? $model->id : null],
        'fieldClass'             => 'common\components\YiiExt\MyActiveField',
        'fieldConfig'            => ['template' => Yii::$app->MyClass::$fieldFloating],
]);?>
<div class="row">
    <div class="col-md-6">
        <?=$form->field($model, 'category')->textInput(['maxlength' => true])?>
    </div>
    <div class="col-md-6">
        <?=$form->field($model, 'message')->textInput(['maxlength' => true])?>
    </div>
</div>
<div class="separator border-bottom-dashed my-3"></div>
<div class="row">
    <?php
        foreach (AR_Lang as $k => $item) {
            if ($k == 'en-US') {continue;}
            $modelS = i18nMsg::findOne(['id' => $model->id, 'language' => $k]);
        ?>
    <div class="col-md-6">
        <?=$form->field($model, "message2[$k]")->textInput(['value' => $modelS->translation])->label($item['text']);?>
    </div>
    <?php
    }?>
</div>
<div class="row footer">
    <div class="col-md-12 text-center">
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-lg fa-save"></i> <?=Yii::t('app', 'Save');?></button>
        <button type="reset" class="btn btn-warning btn-sm"><i class="fa fa-lg fa-history"></i> <?=Yii::t('app', 'Reset');?></button>
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="fa fa-lg fa-times"></i> <?=Yii::t('app', 'Cancel');?></button>
    </div>
</div>
<?php $form::end();?>