<?php

namespace namwansoft\i18nManagement\models;

class i18nMsgSearch extends i18nMsg
{

    public $q;

    public function rules()
    {
        return [[['q'], 'safe']];
    }

    public function scenarios()
    {
        return \yii\base\Model::scenarios();
    }

    public function search($params)
    {
        $query = get_class($this)::find()
            ->joinWith('i18n i18n');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query'      => $query,
            'sort'       => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->q['language']) {
            $query->andFilterWhere(['language' => $this->q['language']]);
        }
        $query->andFilterWhere(['OR',
            ['like', 'change_attributes', $this->q['search']],
            ['like', 'object', $this->q['search']],
        ]);

        return $dataProvider;
    }

}
