<?php

namespace namwansoft\i18nManagement\models;

use Yii;

class i18n extends \yii\db\ActiveRecord
{

    private static $db = 'db';
    private static $table = 'app_i18n';

    public static function getDb()
    {
        return Yii::$app->get(self::$db);
    }

    public static function tableName()
    {
        return '{{%' . self::$table . '}}';
    }

    public function rules()
    {
        return [
            [['category'], 'string', 'max' => 255],
            [['message'], 'string'],
            [['message2'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('system', 'Id.'),
            'category' => Yii::t('system', 'Category'),
            'message'  => Yii::t('system', 'Message'),
        ];
    }

    public function getTrans()
    {
        return $this->hasMany(i18nMsg::className(), ['id' => 'id']);
    }

    public function getTranslat()
    {
        return \yii\helpers\ArrayHelper::map($this->trans, 'language', 'translation');
    }
}
