<?php

namespace app\models;

use Yii;

use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/***
 * Class Providers
 * @package app\models
 *
 * @property integer $password_min_length
 * @property boolean $password_hard
 * @property int $ui_rows
 * @property string $email_alerts_messages
 * @property string $email_alerts_orders
 * * @property String $created_at
 * @property String $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 */

class Providers extends \yii\db\ActiveRecord
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
     
    public $admin_user;
     
    public static function tableName()
    {
        return 'cl_providers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provider_title', 'provider_info', 'status', 'currency', 'currency_place', 'stripe_currency'], 'required','on'=>['create','update']],
            [['status','password_min_length'], 'integer'],
            [['provider_title', 'currency', 'currency_place', 'stripe_currency' ], 'string', 'max' => 255],
            [[ 'provider_logo', 'provider_menu_logo', 'ui_rows',
                'email_alerts_messages','email_alerts_orders','password_hard','password_min_length'], 'safe'],
            [[ 'provider_logo', 'provider_menu_logo'], 'file', 'extensions' => 'png, jpg, jpeg, gif', 'skipOnEmpty' => true, 'maxFiles' => 1 ],
            [[ 'color_model', 'provider_info'], 'string', 'max' => 500],
            [['provider_title'],'security_admin_asccess','on'=>['update']],
            [['provider_title'],'security_super_asccess','on'=>['create']]
        ];
    }

    public function security_admin_asccess(){
        if(Yii::$app->user->identity->isAdmin()){
            $this->addError('provider_title','You do not permitted to this action');
        }
    }

    public function security_super_asccess(){
        if(Yii::$app->user->identity->isSuperAdmin()){
            $this->addError('provider_title','You do not permitted to this action');
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'provider_id' => Yii::t('app','Provider ID'),
            'provider_title' => Yii::t('app','Provider Name'),
            'provider_logo' => Yii::t('app','Provider Logo'),
            'provider_menu_logo' => Yii::t('app','Provider Menu Logo'),
            'color_model' => Yii::t('app','Color Model'),
            'provider_info' => Yii::t('app','Provider Info'),
            'status' => Yii::t('app','Status'),
            'currency' => Yii::t('app','Currency'),
            'currency_place' => Yii::t('app','Currency place' ),
            'stripe_currency' => Yii::t('app','Stripe Currency'),
            'ui_rows'=>Yii::t('app','Number of rows to show in tables'),
            'email_alerts_orders'=>Yii::t('app','Email alerts for new orders to (comma separated):'),
            'email_alerts_messages'=>Yii::t('app','Email alerts for new messages to (comma separated):'),
            'password_min_length'=>Yii::t('app','Users password minimum length'),
            'password_hard'=>Yii::t('app','Require special hard password'),
        ];
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
        $query = Providers::find();


        $provider_id =  Yii::$app->user->identity->provider_id;
        $user_role =  Yii::$app->user->identity->user_role;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Providers::getNumUiItems(),
            ],
        ]);

        if( $user_role == 1 ) {
            $dataProvider = new ActiveDataProvider([
                'query' => $query->andFilterWhere(['=', 'provider_id', $provider_id  ]) ,
                'pagination' => [
                    'pageSize' => Providers::getNumUiItems(),
                ],
            ]);
        }

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'provider_id' => $this->provider_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'provider_title', $this->provider_title])
            ->andFilterWhere(['like', 'provider_info', $this->provider_info]);

        return $dataProvider;
    }
    
    
    /*  ---------------------------- GET Provider STATUS TITLE -----------------------------------------  */
	
	public function getProvider_status_name()
	{    
	    foreach ( $GLOBALS["provider_status"] as $key => $value) {
	         if ( $this->status == $key ) { $item_name   =  $value; }
	    }
	     return $item_name;
	}


	public static function getNumUiItems($id = null){
        if ( !Yii::$app->user->isGuest ){
            if(!isset($id)) $id = Yii::$app->user->identity->provider_id;
            if(!isset($id)){
                return 20;
            }
            $provider = Providers::findOne($id);
            if(isset($provider)){
                return $provider->ui_rows;
            }
        }else{
            return 20;
        }

    }
	
}
