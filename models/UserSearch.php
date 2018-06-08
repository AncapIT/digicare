<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form about `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */ 

    public function rules()
    {
        return [
            [['user_id', 'login_allowed', 'provider_id' ], 'integer'],
            [['login', 'password', 'auth_key',  'user_role' ], 'safe'],
            [[ 'email', 'address', 'first_name', 'last_name', 'phone' ], 'string', 'max' => 200 ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {	
	    $provider_id =  Yii::$app->user->identity->provider_id;	
		$user_role =  Yii::$app->user->identity->user_role; 

        $query = User::find()->with('relations');
        
        $query->joinWith(['relations']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Providers::getNumUiItems(),
            ],
        ]);
  
        $dataProvider = new ActiveDataProvider([
            'query' => $query->andFilterWhere(['<>', 'login', 'admin' ]) ,
            'pagination' => [
                'pageSize' => Providers::getNumUiItems(),
            ],
        ]); 
        
        if( $user_role != 0 ) { 
	         $dataProvider = new ActiveDataProvider([
            'query' => $query->andFilterWhere(['=', 'provider_id', $provider_id  ]) ,
                 'pagination' => [
                     'pageSize' => Providers::getNumUiItems(),
                 ],
			]);
        }
 

        $this->load($params);

        if (!$this->validate()) {
           
            $query->joinWith(['relations']); 
            return $dataProvider;
        }

  
        // grid filtering conditions
        $query->andFilterWhere([
            'user_id' => $this->user_id,  
            'login_allowed' => $this->login_allowed,
            'user_role' => $this->user_role, 
            'provider_id' => $this->provider_id,
            'relations.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'login', $this->login ])
            ->andFilterWhere(['<>', 'login', 'admin' ])  
            ->andFilterWhere(['like', 'phone', $this->phone ])
            ->andFilterWhere(['like', 'first_name', $this->first_name ])
            ->andFilterWhere(['like', 'last_name', $this->last_name ])
            ->andFilterWhere(['like', 'address', $this->address ]);
            

        return $dataProvider;
    }
}
