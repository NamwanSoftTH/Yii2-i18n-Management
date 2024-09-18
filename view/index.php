<?php

    use Yii;
    use yii\bootstrap5\Modal;
    use yii\helpers\Html;
    use yii\widgets\Pjax;

    $this->title = Yii::t('system', 'i18n Management') . ' : ' . Yii::$app->name;

    Modal::begin();
    Modal::end();
    $this->registerJsFile('@themesAsset/js/form-all.js' . CDNV, ['depends' => [yii\web\JqueryAsset::className()]]);

    $deptColumns = [];
    foreach (AR_Lang as $k => $item) {
        if ($k == 'en-US') {continue;}
        $deptColumns[] = [
            'label'   => $item['text'],
            'options' => ['style' => 'min-width:250px;width:250px;'],
            'value'   => fn($model)   => $model->translat[$k],
        ];
    }
?>
<?php Pjax::begin(['id' => 'grid_pjax', 'timeout' => false]);?>
<div class="card h-md-100">
    <div class="card-header px-3">
        <h3 class="card-title"><i class="fad fa-file-medical-alt me-2"></i><?=Yii::t('system', 'i18n Management');?></h3>
        <div class="card-toolbar"><?=$this->render('_search', ['model' => $searchModel, 'arList' => $arList]);?></div>
    </div>
    <div class="card-body p-3">
        <?=
\yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns'      => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'class'          => 'yii\grid\ActionColumn',
            'header'         => Yii::t('system', 'Manage'),
            'contentOptions' => ['class' => 'text-center p-1', 'style' => 'min-width:110px;width:110px;'],
            'template'       => '<a href="javascript:;" class="btn btn-outline btn-outline-dashed btn-outline-info btn-active-light-info btn-sm w-100" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">' . Yii::t('system', 'Manage') . '<i class="fad fa-angle-down ms-2"></i></a><div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fs-7 w-175px" data-kt-menu="true">{view}{update}{delete}</div>',
            'buttons'        => [
                'view'   => function ($url, $model, $key) {
                    return '<div class="menu-item">' . Html::a(
                        '<span class="menu-icon"><i class="fad fa-eye"></i></span><span class="menu-title">' . Yii::t('system', 'Detail') . '</span>', 'javascript:;', ['data-key' => $key, 'class' => 'menu-link action-view']
                    ) . '</div>';
                },
                'update' => function ($url, $model, $key) {
                    return '<div class="menu-item">' . Html::a(
                        '<span class="menu-icon"><i class="fad fa-edit"></i></span><span class="menu-title">' . Yii::t('system', 'Update') . '</span>', 'javascript:;', ['data-key' => $key, 'class' => 'menu-link action-update']
                    ) . '</div>';
                },
                'delete' => function ($url, $model, $key) {
                    return '<div class="menu-item">' . Html::a(
                        '<span class="menu-icon"><i class="fad fa-trash-alt"></i></span><span class="menu-title">' . Yii::t('system', 'Delete') . '</span>', 'javascript:;', ['data-key' => $key, 'class' => 'menu-link action-delete']
                    ) . '</div>';
                },
            ],
        ],
        [
            'attribute'      => 'category',
            'contentOptions' => ['class' => 'text-center'],
            'options'        => ['style' => 'min-width:100px;width:100px;'],
        ],
        [
            'attribute' => 'message',
            // 'contentOptions' => ['class' => 'text-center'],
            'options'   => ['style' => 'min-width:250px;'],
        ],
        ...$deptColumns,
    ],
]);
?>
    </div>
</div>
<?php Pjax::end();?>