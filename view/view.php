<?php
    $opt1 = ['class' => 'fw-semibold text-end'];
    $opt2 = ['class' => 'fw-semibold'];
    $attributes = ['id', 'category', ['attribute' => 'message', 'captionOptions' => $opt1, 'contentOptions' => $opt2]];
    foreach (AR_Lang as $k => $item) {
        if ($k == 'en-US') {continue;}
        $attributes[] = ['label' => $item['text'] . '<img class="ms-1 mh-15px" src="https://space.cashauto.dev/metronic8/assets/media/flags/' . $item['long'] . '.svg">', 'value' => $model->translat[$k], 'captionOptions' => $opt1, 'contentOptions' => $opt2];
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