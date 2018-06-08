<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        $request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 
        
        $provider_id =  Yii::$app->user->identity->provider_id;	
		$user_role =  Yii::$app->user->identity->user_role;  
		
		if( $user_role > 0 ) { $pid = $provider_id;  }
		
        return 'cl_'.$pid.'_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_title','menu_icon', 'menu_link', 'menu_type'], 'required','on'=>['create','update']],
            [['page_desc'], 'string'],
            [['sort_id'], 'integer'],
            [['menu_title'], 'string', 'max' => 500],
            [['parent_page', 'menu_icon', 'menu_link'], 'string', 'max' => 100],
            [['home_flag', 'status'], 'string', 'max' => 1],
            [['menu_type', 'level'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mid' => Yii::t('app','id'),
            'menu_title' => Yii::t('app','Menu Title'),
            'parent_page' => Yii::t('app','Parent Page'),
            'home_flag' => Yii::t('app','App Home Page'),
            'menu_icon' => Yii::t('app','Menu Icon'),
            'menu_link' => Yii::t('app','Menu Link'),
            'menu_type' => Yii::t('app','Menu Type'),
            'status' => Yii::t('app','Status'),
            'level' => Yii::t('app','Level'),
            'page_desc' => Yii::t('app','Page Desc'),
            'sort_id' => Yii::t('app','Sort ID'),
        ];
    }


    
     /*  ---------------------------- GET MENU STATUS TITLE -----------------------------------------  */
	
	public function getMenu_Status_name()
	{    
	    foreach ( $GLOBALS["menu_status"] as $key => $value) {
	         if ( $this->status == $key ) { $item_name   =  $value; }
	    }
	     return $item_name;
	}
	
	
	  
     /*  ---------------------------- GET MENU ICON TITLE -----------------------------------------  */
	
	public function getMenu_Icon_name( $icon )
	{    
		$item_name = ''; 	
	    foreach ( $GLOBALS["big_menu_icons"] as $key => $value) {
	         if ( $icon == $key ) { $item_name   =  $value; }
	    }
	     return $item_name;
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
        $query = Menu::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Providers::getNumUiItems(),
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'mid' => $this->mid,
            'sort_id' => $this->sort_id,
        ]);

        $query->andFilterWhere(['like', 'menu_title', $this->menu_title])
            ->andFilterWhere(['like', 'parent_page', $this->parent_page])
            ->andFilterWhere(['like', 'home_flag', $this->home_flag])
            ->andFilterWhere(['like', 'menu_icon', $this->menu_icon])
            ->andFilterWhere(['like', 'menu_link', $this->menu_link])
            ->andFilterWhere(['like', 'menu_type', $this->menu_type])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'page_desc', $this->page_desc]);

        return $dataProvider;
    }
    
}
