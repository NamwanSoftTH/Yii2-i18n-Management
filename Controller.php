<?php

namespace namwansoft\i18nManagement;

use namwansoft\i18nManagement\models\i18n;
use namwansoft\i18nManagement\models\i18nMsg;
use namwansoft\i18nManagement\models\i18nSearch;
use Yii;
use yii\web\Response;

class Controller extends \yii\web\Controller
{
    public function actionIndex()
    {
        $arList = [];
        foreach (\Yii::$app->i18n->translations as $k => $v) {
            $arList[$k] = $k;
        }
        $searchModel = new i18nSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('@vendor/namwansoft/yii2-i18n-Management/view/index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'arList'       => $this->getGroup(),
        ]);
    }

    public function actionValidation($id = null)
    {
        $model = $id === null ? new i18n : i18n::findOne($id);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return \yii\bootstrap5\ActiveForm::validate($model);
        }
    }

    public function actionCreate()
    {
        $model = new i18n();
        if ($model->load(Yii::$app->request->post())) {
            $msgSub = $model->message2;
            $model->message2 = null;
            if ($status = $model->save()) {
                foreach ($msgSub as $k => $v) {
                    if (!$v) {continue;}
                    $modelS = i18nMsg::findOne(['id' => $model->id, 'language' => $k]);
                    if (!$modelS) {
                        $modelS = new i18nMsg;
                        $modelS->id = $model->id;
                        $modelS->language = $k;
                    }
                    $modelS->translation = $v;
                    $modelS->save();
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => $status];
        }
        $model->category = 'app';
        return $this->renderAjax('@vendor/namwansoft/yii2-i18n-Management/view/_form', ['model' => $model, 'arList' => $this->getGroup()]);
    }

    public function actionUpdate($id)
    {
        $model = i18n::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            $msgSub = $model->message2;
            $model->message2 = null;
            if ($status = $model->save()) {
                foreach ($msgSub as $k => $v) {
                    if (!$v) {continue;}
                    $modelS = i18nMsg::findOne(['id' => $model->id, 'language' => $k]);
                    if (!$modelS) {
                        $modelS = new i18nMsg;
                        $modelS->id = $model->id;
                        $modelS->language = $k;
                    }
                    $modelS->translation = $v;
                    $modelS->save();
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['status' => $status];
        }
        return $this->renderAjax('@vendor/namwansoft/yii2-i18n-Management/view/_form', ['model' => $model, 'arList' => $this->getGroup()]);
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['status' => i18n::findOne($id)->delete()];
    }

    private function getGroup()
    {
        $arList = [];
        foreach (\Yii::$app->i18n->translations as $k => $v) {
            $arList[$k] = $k;
        }
        return $arList;
    }
}
