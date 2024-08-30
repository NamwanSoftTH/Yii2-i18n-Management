<?php

namespace namwansoft\i18nManagement\models;

class i18nSearch extends i18n
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
        $query = get_class($this)::find();

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query'      => $query,
            'sort'       => ['defaultOrder' => ['id' => SORT_DESC]],
            'pagination' => [],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        if ($this->q['category']) {
            $query->andFilterWhere(['category' => $this->q['category']]);
        }
        $query->andFilterWhere(['OR',
            ['like', 'category', $this->q['search']],
            ['like', 'message', $this->q['search']],
        ]);

        return $dataProvider;
    }

}
