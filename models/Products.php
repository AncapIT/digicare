<?php

namespace app\models;

use app\components\DigiCareHelper;
use DateTime;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/**
 * Class Products
 * @package app\models
 *
 * @property int $prod_id
 * @property boolean $published
 * @property String $created_at
 * @property String $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */

class Products extends \yii\db\ActiveRecord
{


    public $modifier;

    public function beforeSave($insert)
    {
        date_default_timezone_set(Yii::$app->params['timeZone']);
        $user_id = isset($this->modifier)? $this->modifier->user_id : Yii::$app->user->id;
        if($this->isNewRecord) {
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
        return 'cl_'. DigiCareHelper::getProviderId() .'_products';
    }

    public function getItems(){
        return $this->hasMany(ProductItems::className(),['product_id'=>'prod_id']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_title','module' ], 'required','on'=>['create','update']],
            [['product_desc'], 'string'],
            [['product_title','module','product_desc','published','sort_id','icon'],'safe'],
            [['sort_id'], 'integer'],
            [['product_title' ], 'string', 'max' => 500],
            [[ 'icon'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'prod_id' => Yii::t('app','Prod ID'),
            'product_title' => Yii::t('app','Product Title'),
       //     'product_type' => 'Product Type',
      //      'page_link' => Yii::t('app','Page Link'),
      //      'product_desc' => 'Product Desc',
            'module' =>Yii::t('app','Module'),
            'icon' => Yii::t('app','Icon'),
            'sort_id' => Yii::t('app','Sort ID'),
        ];
    }

    
    
    
     /*  ---------------------------- GET ORDER STATUS TITLE -----------------------------------------  */
	
	public function getProduct_type_title( $title )
	{   
		$item_name = '';  
	    foreach ( $GLOBALS["product_type"] as $key => $value) {
	         if ( $title == $key ) { $item_name  =  $value; }
	    }
	     return $item_name;
	}
	

	static public function getListForDD(){
	    $list = [];
	    foreach (Products::find()->orderBy("prod_id DESC")->all() as $product){
            $list[$product->prod_id] = Yii::t('app',$product->product_title);
        }
        return $list;
    }

    static public function getFoodListForDD(){
        $list[''] = ['select'];
        foreach (Products::find()->where(['module'=>'food_menu'])->orderBy("prod_id DESC")->all() as $product){
            $list[$product->prod_id] = Yii::t('app',$product->product_title);
        }
        return $list;
    }
	     
  /*  ---------------------------- GET Y/N STATUS -----------------------------------------  */
	
	public function getStatus_name( $title )
	{    
		$item_name = '';
	    foreach ( $GLOBALS["yn_status"] as $key => $value ) {
	         if ( $title == $key  ) { $item_name  =  $value; }
	    }
	     return $item_name;
	}
	
	/*  ------------- GET DATA FOR REPORT --------------------------------*/

	public function getDataForReport(){
	    $data = [];
        $sql = "SELECT oi.title as oi_title ,pi.prod_item_id, oi.data_text, pic.id as pic_id, pic.title as pic_title, pi.title as pi_title,
count( DISTINCT oi.order_item_id) as coi, count( DISTINCT oi.product_item_choice_id) as coic
        FROM cl_". DigiCareHelper::getProviderId() ."_orders o
        LEFT JOIN cl_". DigiCareHelper::getProviderId() ."_order_items oi on oi.order_id = o.order_id
        LEFT JOIN cl_". DigiCareHelper::getProviderId() ."_prod_item_choices pic on oi.product_item_choice_id = pic.id
        LEFT JOIN cl_". DigiCareHelper::getProviderId() ."_product_items pi on oi.prod_item_id = pi.prod_item_id 
         WHERE o.product_id = ".$this->prod_id." AND pi.prod_item_id IS NOT NULL GROUP by pi.prod_item_id, pic.id, oi.data_text";

        $res = Yii::$app->db->createCommand( $sql )->queryAll();

        foreach ($res as $row){
            $data[$row['pi_title']]['items'][$row['data_text']]["count"] = $row['coic']+$row['coi'];
            $data[$row['pi_title']]['items'][$row['data_text']]["pic_id"] = $row['pic_id'];
            $data[$row['pi_title']]['count'] = $row['coi'];
            $data[$row['pi_title']]['prod_item_id'] = $row['prod_item_id'];
        }
	    return $data;
    }

    public function getDataForMissingReport(){

        $sql = "SELECT user_id, first_name, last_name FROM cl_users WHERE user_id NOT IN
(SELECT patient_id FROM cl_". DigiCareHelper::getProviderId() ."_orders WHERE product_id =".$this->prod_id." ) AND user_role = 4  AND food = 1
order by last_name";

        $res = Yii::$app->db->createCommand( $sql )->queryAll();

        return $res;
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
        $query = Products::find()/*->andWhere(" [[product_type]] <> 'core_services' "  )*/;

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
            'prod_id' => $this->prod_id,
            'sort_id' => $this->sort_id
        ]);

        $query->andFilterWhere(['like', 'product_title', $this->product_title])
            ->andFilterWhere(['like', 'module', $this->module])
            //   ->andFilterWhere(['like', 'page_link', $this->page_link])
            ->andFilterWhere(['like', 'product_desc', $this->product_desc])
            ->andFilterWhere(['like', 'module', $this->module]);

        return $dataProvider;
    }

    public function getCopyLink(){
        $link = '<a href="'.Url::to(['products/duplicate','id'=>$this->prod_id]).'" class="btn btn-primary orange_button plus_icon" style="width: auto;"> '.Yii::t('app','Duplicate').'</a>';
        return $link;
    }

    public function duplicate(){
        $newProduct = new Products();
        $newProduct->setAttributes($this->attributes);
        $newProduct->prod_id = null;
        $newProduct->product_title = 'DUPLICATE OF ' .$this->product_title;
        $newProduct->published = 0;
        $newProduct->save();
        $this->duplicateItems($newProduct->prod_id);
        return $newProduct;
    }

    private function duplicateItems($prod_id){
        foreach ($this->items as $item){
            $newItem = new ProductItems($item->attributes);
            $newItem->prod_item_id = null;
            $newItem->product_id = $prod_id;
            $newItem->save();
            foreach ($item->itemsChoices as $choice){
                $newChoice = new ProductItemsChoices($choice->attributes);
                $newChoice->prod_item_id = $newItem->prod_item_id;
                $newChoice->id = null;
                $newChoice->save();
            }
        }
    }

    public function saveProductItems($request){
        $provider_id =  Yii::$app->user->identity->provider_id;

        // items params

        $item_title = $request->post('item_title');
        $item_description = $request->post('item_description');
        $item_mandatory = $request->post('item_mandatory');
        $item_price = $request->post('item_price',0);
        $item_type = $request->post('item_type');
        $sort_items = $request->post('sort_items');
        $new_item = $request->post('new_item');
        $del_item = $request->post('del_item');

        // item choices
        $ic_sort = $request->post('ic_sort');
        $ic_title = $request->post('ic_title');
        $ic_desc = $request->post('ic_desc');
        $ic_price = $request->post('ic_price',0);

        //echo '<pre>' . var_dump(  $ic_title ) . '</pre><br/><br/>'; // die();

        if ( isset( $item_title )) {
            foreach ( $item_title as $key => $value ) { $new = 0;  $del = 0;

                if (  isset( $new_item[ $key ] ) == 1 ) {   $new = 1; } else { $new = 0;  }
                if (  isset( $del_item[ $key ] ) == 1 ) {   $del = 1; } else { $del = 0;  }
                if (  isset( $item_title[ $key ] ) == 1 ) {   $title = $item_title[ $key ]; } else { $title = '';  }
                if (  isset( $item_description[ $key ] ) == 1 ) {   $description = $item_description[ $key ]; } else { $description = '';  }
                if (  isset( $item_price[ $key ] ) == 1 ) {   $price = $item_price[ $key ]; } else { $price = '0';  }
                if (  isset( $item_mandatory[ $key ] ) == 1 ) {   $mandatory = 'y'; } else { $mandatory = 'n';  }
                if (  isset( $item_type[ $key ] ) == 1 ) {   $type = $item_type[ $key ]; } else { $type = 'text';  }
                if (  isset( $sort_items[ $key ] ) == 1 ) {   $sort = $sort_items[ $key ]; } else { $sort = '0';  }

                //echo '<br>--->' . $title . ':' . $new;

                if(  $title != '' && $del != 1 ) {

                    //============================ update exist items

                    if( $key > 0 && $new != 1 ) {

                        Yii::$app->db->createCommand()
                            ->update('cl_' .$provider_id. '_product_items', [
                                'title' => $title , 'description' => $description, 'mandatory' => $mandatory,
                                'product_item_type' => $type, 'sort_id' => $sort, 'price' => $price
                            ], 'prod_item_id = ' . $key )
                            ->execute();

                        // ---------- save and update item choices
                        if ( isset( $ic_title[ $key ]  )) {

                            $sql = " DELETE FROM  cl_" .$provider_id. "_prod_item_choices  WHERE prod_item_id =  " . $key ;
                            Yii::$app->db->createCommand( $sql )->execute();

                            foreach ( $ic_title[ $key ] as $ic_key => $value  ) {

                                $res = Yii::$app->db->createCommand()->insert('cl_' .$provider_id. '_prod_item_choices', [
                                    'prod_item_id' => $key, 'sort_id' => $ic_sort[ $key ][ $ic_key ],  'title' => $ic_title[ $key ][ $ic_key ],
                                    'description' => $ic_desc[ $key ][ $ic_key ], 'price' => isset($ic_price[ $key ][ $ic_key ]) && is_numeric($ic_price[ $key ][ $ic_key ])? $ic_price[ $key ][ $ic_key ] : 0
                                ])->execute();
                            }
                        }  // end - save item choises


                    } else {   // ========================== create new product items

                        $res = Yii::$app->db->createCommand()->insert('cl_' .$provider_id. '_product_items', [ 'product_id' => $this->prod_id,
                            'title' => $title , 'description' => $description, 'mandatory' => $mandatory,
                            'product_item_type' => $type, 'sort_id' => $sort, 'price' => $price
                        ])->execute();

                        $last_id = Yii::$app->db->getLastInsertID();

                        // ---------- save and update item choices
                        if ( isset( $ic_title[ $key ]  )) {

                            foreach ( $ic_title[ $key ] as $ic_key => $value  ) {

                                $res = Yii::$app->db->createCommand()->insert('cl_' .$provider_id. '_prod_item_choices', [
                                    'prod_item_id' => $last_id, 'sort_id' => $ic_sort[ $key ][ $ic_key ],  'title' => $ic_title[ $key ][ $ic_key ],
                                    'description' => $ic_desc[ $key ][ $ic_key ], 'price' => isset($ic_price[ $key ][ $ic_key ]) && is_numeric($ic_price[ $key ][ $ic_key ])? $ic_price[ $key ][ $ic_key ] : 0
                                ])->execute();
                            }
                        }  // end - save item choises

                    }
                }

                // delete items
                if ( $del == 1  && $key > 0 ) {
                    $sql = " DELETE FROM  cl_" .$provider_id. "_product_items  WHERE prod_item_id =  " . $key ;
                    Yii::$app->db->createCommand( $sql )->execute();
                }

            } // end foreach
        }

        //die();
    }
}
