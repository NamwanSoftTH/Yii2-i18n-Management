<?php
    use namwansoft\i18nManagement\models\i18n;
    $arType_L = \yii\helpers\ArrayHelper::map(i18n::find()->groupBy('category')->all(), 'category', 'category');

    $form = \yii\widgets\ActiveForm::begin([
        'action'  => ['index'],
        'method'  => 'get',
        'options' => ['data-pjax' => true],
    ]);
?>
<div class="input-group input-group-sm">
    <?=\yii\helpers\Html::activeDropDownList($model, 'q[category]', ['' => ''] + $arType_L, [
    'class'            => "form-select form-select-sm rounded-end-0",
    'data-control'     => "select2",
    'data-placeholder' => "-" . Yii::t('app', 'Category') . "-",
    'data-allow-clear' => "true",
    'data-hide-search' => "true",
    'data-width'       => "150px",
]);?>
    <?=\yii\helpers\Html::activeTextInput($model, 'q[search]', ['class' => 'form-control', 'placeholder' => Yii::t('system', 'Search') . '...']);?>
    <button class="btn btn-info" type="submit"><i class="fa fa-search"></i> <?=Yii::t('system', 'Search');?></button>
    <?=(Yii::$app->user->identity->role == 'developer')?\yii\helpers\Html::button('<i class="fad fa-plus-square"></i> ' . Yii::t('system', 'Create'), ['class' => 'btn btn-primary action-create']) : null;?>
</div>
<?php $form::end();?>