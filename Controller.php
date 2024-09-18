<?php

namespace namwansoft\i18nManagement;

use namwansoft\i18nManagement\models\i18n;
use namwansoft\i18nManagement\models\i18nMsg;
use namwansoft\i18nManagement\models\i18nSearch;
use Yii;
use yii\web\Response;

class Controller extends \yii\web\Controller
{

    private $modelClass = i18n::class;
    private $modelMsgClass = i18nMsg::class;

    public function actionIndex()
    {
        $arList = [];
        foreach (Yii::$app->i18n->translations as $k => $v) {
            $arList[$k] = $k;
        }
        $searchModel = new i18nSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('@vendor/namwansoft/yii2-i18n-management/view/index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'arList'       => $this->getGroup(),
        ]);
    }

    public function actionView($id)
    {
        return $this->renderAjax('@vendor/namwansoft/yii2-i18n-management/view/view', ['model' => $this->modelClass::findOne($id)]);
    }

    public function actionValidation($id = null)
    {
        $model = $id === null ? new $this->modelClass : $this->modelClass::findOne($id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return \yii\bootstrap5\ActiveForm::validate($model);
        }
    }

    public function actionCreate()
    {
        $model = new $this->modelClass();
        if ($model->load(Yii::$app->request->post())) {
            $msgSub = $model->message2 ? $model->message2 : AR_Lang;
            $model->message2 = null;
            if ($status = $model->save()) {
                foreach ($msgSub as $k => $v) {
                    $modelS = $this->modelMsgClass::findOne(['id' => $model->id, 'language' => $k]);
                    if (!$modelS) {
                        $modelS = new $this->modelMsgClass;
                        $modelS->id = $model->id;
                        $modelS->language = $k;
                    }
                    if ($modelS && $v) {
                        $modelS->translation = $v;
                        $lng['save'] = [$k => $modelS->save()];
                    } else if ($modelS) {
                        $lng['delete'] = [$k => $modelS->delete()];
                    }
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => $status, 'lng' => $lng];
        }
        $model->category = 'app';
        return $this->renderAjax('@vendor/namwansoft/yii2-i18n-management/view/_form', ['model' => $model, 'arList' => $this->getGroup()]);
    }

    public function actionUpdate($id)
    {
        $lng = [];
        $model = $this->modelClass::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            $msgSub = $model->message2 ? $model->message2 : AR_Lang;
            $model->message2 = null;
            if ($status = $model->save()) {
                foreach ($msgSub as $k => $v) {
                    $modelS = $this->modelMsgClass::findOne(['id' => $model->id, 'language' => $k]);
                    if (!$modelS) {
                        $modelS = new $this->modelMsgClass;
                        $modelS->id = $model->id;
                        $modelS->language = $k;
                    }
                    if ($modelS && $v) {
                        $modelS->translation = $v;
                        $lng['save'] = [$k => $modelS->save()];
                    } else if ($modelS) {
                        $lng['delete'] = [$k => $modelS->delete()];
                    }
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => $status, 'lng' => $lng];
        }
        return $this->renderAjax('@vendor/namwansoft/yii2-i18n-management/view/_form', ['model' => $model, 'arList' => $this->getGroup()]);
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status' => $this->modelClass::findOne($id)->delete()];
    }

    private function getGroup()
    {
        $arList = [];
        foreach (Yii::$app->i18n->translations as $k => $v) {
            $arList[$k] = $k;
        }
        return $arList;
    }
}
