<?php
    $opt = ['class' => 'fw-semibold bg-warning text-end'];
    $attributes = ['id', 'category', ['attribute' => 'message', 'captionOptions' => $opt, 'contentOptions' => $opt]];
    foreach (AR_Lang as $k => $item) {
        if ($k == 'en-US') {continue;}
        $attributes[] = ['label' => '<i class="fad fa-language text-primary me-2"></i>' . $item['text'], 'value' => $model->translat[$k], 'captionOptions' => $opt, 'contentOptions' => $opt];
    }
    array_push($attributes, 'created_at:dateTime', 'updated_at:dateTime');
?>
<div class="table-responsive">
    <?=\yii\widgets\DetailView::widget(['model' => $model, 'attributes' => $attributes]);?>
</div>
<div class="row footer">
    <div class="col-md-12 text-center">
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"><i class="fad fa-times fs-2 me-2"></i><?=Yii::t('system', 'Cancel');?></button>
    </div>
</div>