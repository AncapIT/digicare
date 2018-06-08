<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

class Items extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
	    $request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 
        return 'cl_'.$pid.'_items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['doc_id', 'doc_type',  'item_title' ], 'required','on'=>['create','update']],
            [['doc_id'], 'integer'],
            [['item_date'], 'safe'],
            [['item_content'], 'string'],
            [['doc_type'], 'string', 'max' => 100],
            [['item_title', 'item_header', 'pdf_link'], 'string', 'max' => 500],
            
            [[ 'image' ], 'safe'],
            [[ 'image' ], 'file', 'extensions' => 'png, jpg, jpeg, gif', 'skipOnEmpty' => true, 'maxFiles' => 1 ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => Yii::t('app','Item ID'),
            'doc_id' => '',
            'doc_type' => Yii::t('app','Doc Type'),
            'item_date' => Yii::t('app','Item Date'),
            'item_title' => Yii::t('app','Item Title'),
            'item_header' => Yii::t('app','Item Header'),
            'item_content' => Yii::t('app','Item Content'),
            'image' => Yii::t('app','Image'),
            'pdf_link' => Yii::t('app','Pdf Link'),
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
	 
	  
	 /*  ---------------------------- GET DOCUMENT TITLE  -----------------------------------------  */
	
	 public function getDocument_name( $pid, $doc_id ) {  
	   
	   $output  = ''; 
	   $sql =  "SELECT * FROM  cl_". $pid ."_documents WHERE doc_id = '". $doc_id ."'  ";
	   
	   $res = Yii::$app->db->createCommand( $sql )->queryAll();
	   foreach ( $res as $row ) { 	  $output  = $output .  $row['doc_title'];     }
	    
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
        $request = Yii::$app->request; $doc =  $request->get('doc'); if( !$doc ) { $doc = 0;  }
        $query = Items::find()->andWhere('[[doc_id]]=' . $doc );

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
            'item_id' => $this->item_id,
            'doc_id' => $this->doc_id,
            'item_date' => $this->item_date,
        ]);

        $query->andFilterWhere(['like', 'doc_type', $this->doc_type])
            ->andFilterWhere(['like', 'item_title', $this->item_title])
            ->andFilterWhere(['like', 'item_header', $this->item_header])
            ->andFilterWhere(['like', 'item_content', $this->item_content])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'pdf_link', $this->pdf_link]);

        return $dataProvider;
    }

}
