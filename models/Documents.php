<?php

namespace app\models;

use app\components\DigiCareHelper;
use Faker\Provider\DateTime;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class Documents
 * @package app\models
 *
 * @property boolean $published
 * @property String $created_at
 * @property String $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
 
class Documents extends \yii\db\ActiveRecord
{

    public $modifier;

    public function beforeSave($insert)
    {
        date_default_timezone_set(Yii::$app->params['timeZone']);
        $user_id = isset($this->modifier)? $this->modifier->user_id : Yii::$app->user->id;
        if($this->isNewRecord){
            $this->created_at = date('Y-m-d H:i:s');
            $this->created_by = $user_id;
        }

            $this->updated_at = date('Y-m-d H:i:s');
            $this->updated_by = $user_id;


        return parent::beforeSave($insert);
    }

    public function getCreatedUpdated(){
        $html = '';
        if(isset($this->created_at)){
            $crUser = User::findOne($this->created_by);
            if(isset($crUser))
            $html .= " <p>Created by ".$crUser->getFullname()." at ". $this->created_at."</p>";
        }
        if(isset($this->updated_at)){
            $upUser = User::findOne($this->updated_by);
            if(isset($upUser))
                $html .= " <p>Updated by ".$upUser->getFullname()." at ". $this->updated_at."</p>";
        }
        return $html;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {   
        return 'cl_'. DigiCareHelper::getProviderId() .'_documents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['doc_title', 'doc_type' ], 'required','on'=>['create','update']],
            [['user_id'], 'integer'],
            [['doc_content'], 'string'],
            [['doc_title', 'doc_header', 'doc_options', 'pdf_link'], 'string', 'max' => 500],
            [['doc_type', 'category_desc' ], 'string', 'max' => 100],
            
            [[ 'doc_image','published','doc_header','doc_date','doc_type','user_id','doc_title' ], 'safe'],
            [[ 'doc_image' ], 'file', 'extensions' => 'png, jpg, jpeg, gif', 'skipOnEmpty' => true, 'maxFiles' => 1 ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'doc_id' => Yii::t('app','Doc ID'),
            'doc_title' => Yii::t('app','Title'),
            'user_id' => Yii::t('app','User'),
            'doc_header' => Yii::t('app','Header'),
            'doc_type' => Yii::t('app','Type'),
            'doc_date' => Yii::t('app','Date'),
            'doc_content' => Yii::t('app','Content'),
            'doc_options' => Yii::t('app','Options'),
            'doc_image' => Yii::t('app','Image'),
            'pdf_link' => Yii::t('app','Pdf Link'),
            'category_desc' => Yii::t('app','Category description'),
        ];
    }

 
  /*  ---------------------------- GET DOCUMENT TYPE TITLE -----------------------------------------  */
	
	public function getDoc_type_title( $title )
	{    
		$item_name = ''; 	
	    foreach ( $GLOBALS["document_types"] as $value) {
	         if ( $title == $value ) { $item_name  =  $value; }
	    }
	     return $item_name;
	}
	   
  
 /*  ---------------------------- GET  USER TITLE IN ROW -----------------------------------------  */

 public function getUser_name( $user_id ) {  
   
   $output  = ''; 
   $sql =  "SELECT * FROM  cl_users WHERE user_id = '". $user_id ."'  ";
   $res = Yii::$app->db->createCommand( $sql )->queryAll();
   foreach ( $res as $row ) { 	  $output  = $output .  $row['first_name'] ." ". $row['last_name'] . '; ';     }
    
   return $output; 
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
        $query = Documents::find();

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
            'doc_id' => $this->doc_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'doc_title', $this->doc_title ])
            ->andFilterWhere(['like', 'doc_header', $this->doc_header ])
            ->andFilterWhere(['like', 'doc_type', $this->doc_type ])
            ->andFilterWhere(['like', 'doc_content', $this->doc_content ])
            ->andFilterWhere(['like', 'doc_options', $this->doc_options ])
            ->andFilterWhere(['like', 'doc_image', $this->doc_image ])
            ->andFilterWhere(['like', 'pdf_link', $this->pdf_link ]);

        return $dataProvider;
    }
    
}
