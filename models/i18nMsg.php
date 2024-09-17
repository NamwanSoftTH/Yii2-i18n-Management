<?php

namespace namwansoft\i18nManagement\models;

use Yii;

class i18nMsg extends \yii\db\ActiveRecord
{

    private static $db = 'db';
    private static $table = 'app_i18n_msg';

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
            [['language'], 'string', 'max' => 16],
            [['translation'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('system', 'Id.'),
            'language'    => Yii::t('system', 'Language'),
            'translation' => Yii::t('system', 'Translation'),
        ];
    }

    public function getMsg()
    {
        return $this->hasOne(i18n::className(), ['id' => 'id']);
    }

}
