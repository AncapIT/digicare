<?php

namespace app\models;

namespace app\models;
use Yii;
use yii\base\NotSupportedException;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/***
 * Class User
 * @package app\models
 *
 * @property int $provider_id
 * @property boolean $login_username
 * @property boolean $login_bankid
 * @property boolean $consent
 * @property string $consent_time
 * @property integer $consent_user_id
 * * @property String $created_at
 * @property String $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 */

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
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

        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->generateAuthKey();
            }

            $password =  $this->new_password;
            if( $password ) {
                $this->setPassword($password);
            }

            return true;
        }
        return false;
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

    const ROLE_SUPER_ADMIN = 0;
    const ROLE_ADMIN = 1;
    const ROLE_STAFF = 2;
    const ROLE_RELATIVE = 3;
    const ROLE_PATIENT = 4;

    public $new_password;

    public function save($runValidation = true, $attributeNames = null)
    {

        if($this->consent and !$this->consent_user_id){
            date_default_timezone_set(Yii::$app->params['timeZone']);
            $this->consent_time = date('Y-m-d H:i:s');
            $this->consent_user_id = Yii::$app->user->identity->user_id;
        }
        return parent::save($runValidation, $attributeNames); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cl_users';
    }
 
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 2;
  
 
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusesArray(), $this->login_allowed);
    }

    public function getFullname()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
 
    public static function getStatusesArray()
    {
        return [  ];
    }

    public function getProvider(){
        return $this->hasOne(Providers::className(),['provider_id'=>'provider_id']);
    }

     public function rules()
    {
        return [
            [['login','login_allowed', 'user_role'],'required'],
            ['login', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['login', 'unique', 'targetClass' => self::className(), 'message' => 'This login has already been taken.'],
            ['login', 'string', 'min' => 2, 'max' => 255],
            [['login','login_allowed','password', 'new_password','address', 'first_name', 'last_name','email', 'user_role', 'login_bankid','login_username'],'safe'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::className(), 'message' => 'This email address has already been taken.'],
            ['email', 'string', 'max' => 255],
            array('new_password', 'string', 'min' => isset($this->provider->password_min_length) ? $this->provider->password_min_length : 8, 'message' => Yii::t('app', 'New password must contain at least { n } characters.',['n'=>isset($this->provider->password_min_length) ? $this->provider->password_min_length : 8])),
            array('new_password', 'match', 'pattern' => isset($this->provider->password_hard) && $this->provider->password_hard ? '/^.*(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/' : "/.*/", 'message'        => Yii::t('app', 'New password must contain at least one lower and upper case character and a digit.')),

            [['login_allowed','food','consent'], 'integer'],

            [[ 'login_allowed', 'user_role', 'provider_id' ], 'integer'],
            [[ 'phone' ], 'string', 'max' => 50],
            [[ 'password', 'address', 'first_name', 'last_name'], 'string', 'max' => 500],
            [[ 'auth_key'], 'string', 'max' => 32],
            [[ 'login_bankid'], 'string', 'max' => 100],
            
            //[[ 'photo' ], 'safe'],
            [[ 'photo' ], 'file', 'extensions' => 'png, jpg, jpeg, gif', 'skipOnEmpty' => true, 'maxFiles' => 1 ],

            [['authToken', 'login_bankid', 'city', 'lang'], 'default', 'value' => '']
        ];
    }
 
  /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'ID'),
            'login' => Yii::t('app', 'Login'), 
            'auth_key' => Yii::t('app', 'Key'),
            'first_name' => Yii::t('app', 'First Name'), 
            'last_name' => Yii::t('app', 'Last Name'), 
            'user_role' => Yii::t('app', 'Role'), 
            'user_role_name' => Yii::t('app', 'Level'), 
            'password' => Yii::t('app', 'Password'), 
            'email' => Yii::t('app', 'E-mail'),
            'address' => Yii::t('app', 'Address'), 
            'login_allowed' => Yii::t('app', 'User allowed to login'),
            'provider_id' => Yii::t('app', 'Provider'), 
            'user_status_name' => Yii::t('app', 'Status'),
            'providers_list' => Yii::t('app', 'Provider'),
            'relations.parent_id'  => Yii::t('app', 'Patient Connection'),
             'food'=> Yii::t('app', 'Should order food'),
            'consent' => Yii::t('app', 'Consent Document Received'),
            'login_bankid' => Yii::t('app', 'Bankid'),
            'login_username' => Yii::t('app', 'Username/password'),
        ];
    }


	/* Relative with Users links -------------  */
	
	public function getRelations()
	{
	    return $this->hasOne( Relations::className(), ['user_id' => 'user_id']);
	}
     
     public function behaviors()
    {
        return [
            //TimestampBehavior::className(),
        ];
    }

   public static function findIdentity($id)
    {
        return static::findOne(['user_id' => $id, 'login_allowed' => self::STATUS_ACTIVE]);
    }
 
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('findIdentityByAccessToken is not implemented.');
    }
 
    public function getId()
    {
        return $this->getPrimaryKey();
    }
 
    public function getAuthKey()
    {
        return $this->auth_key;
    }
 
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


      public static function findBylogin($login)
    {
        return static::findOne(['login' => $login]);
    }
 
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password );
    }

     public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
 
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
 


    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'login_allowed' => self::STATUS_ACTIVE,
        ]);
    }
 
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }
 
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
 
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


  
// public function afterSave($insert, $changedAttributes)
//{
//    $request = Yii::$app->request; $password =  $request->post('new_password');
//    // $password = $this->password;
//    if( $password ) {
//	    $password = Yii::$app->security->generatePasswordHash($password);
//	    $auth_key  = Yii::$app->security->generateRandomString();
//
//	    $query = " UPDATE `cl_users`  SET    `password` = '".$password."', `auth_key` =  '".$auth_key."'  WHERE `user_id` =  " . $this->id  ;
//	    Yii::$app->db->createCommand( $query )->execute();
//	}
//    return true;
//}



 /*  ---------------------------- GET USER STATUS TITLE -----------------------------------------  */
	
	public function getUser_Status_name()
	{    
	    foreach ( $GLOBALS["user_status"] as $key => $value) {
	         if ( $this->login_allowed == $key ) { $item_name   =  $value; }
	    }
	     return @$item_name;
	}
	
/*  ---------------------------- GET USER LEVEL TITLE-----------------------------------------  */
	

public function getUser_role_name()
{    $item_name = '';
    foreach ( $GLOBALS["user_role"] as $key => $value) {
         if ( $this->user_role == $key ) { $item_name   =  $value; }
    }
    if ( $this->user_role == 0 ) { $item_name   =  'super_admin'; }
     return  $item_name;
}

 /*  ---------------------------- GET PROVIDER TITLE-----------------------------------------  */

 public function getProvider_name( $provider_id ) {  
   
   $provider_title = ''; 
   $sql =  "SELECT * FROM  cl_providers WHERE status <> 1  AND provider_id = '". $provider_id ."'  ";
   $res = Yii::$app->db->createCommand( $sql )->queryAll();
   foreach ( $res as $row ) { 	  $provider_title  =  $row['provider_title']. " [ #".  $row['provider_id'] . " ] "   ;   }
    
   return $provider_title; 
} 

  
 
 
 /*  ---------------------------- GET  USER TITLE IN ROW -----------------------------------------  */

 public function getRelation_name( $user_id ) {  
   
   $output  = ''; 
   $sql =  "SELECT * FROM  cl_users WHERE user_id = '". $user_id ."'  ";
   $res = Yii::$app->db->createCommand( $sql )->queryAll();
   foreach ( $res as $row ) { 	  $output  = $output .  $row['first_name'] ." ". $row['last_name'] . '; ';     }
    
   return $output; 
} 

 
 
 /*  ---------------------------- GET LIST USERS FOR PROVIDER -----------------------------------------  */ 
	
   public	function getRelations_list( $provider_id, $user_role = null ) {

       if(!isset($user_role))
           $user_role = Yii::$app->user->identity->user_role;
	$output_list = array(); 
	$sql =  "SELECT * FROM cl_users   WHERE  user_role >= 1  AND  provider_id = " . $provider_id;
	if ( $user_role == 4 && $user_role != 'all' ) {  $sql .=  " AND user_role <> '4' " ;  }
	if ( $user_role != 4 && $user_role != 'all'  ) {  $sql .=  " AND user_role = '4' " ;  }
	//if ( $user_role == 'all' ) {  $sql .=  " OR user_role > 1 " ;  }
	
    $res = Yii::$app->db->createCommand( $sql )->queryAll();
    foreach ( $res as $row ) { 	  
	    
	    $role_name = ''; 
	    foreach ( $GLOBALS["user_role"] as $key => $value) {
	         if ( $row['user_role'] == $key ) { $role_name   =  $value; }
	    }
	    
	    $output_list[ $row['user_id'] ]  =  $row['first_name'] ." ". $row['last_name'] . ' - [ ' . $role_name . ' ]' ;   }
		    
	return $output_list; 
   } 



 /*  ---------------------------- GET ALL USERS BINDED FOR THIS USER -----------------------------------------  */ 


   public function getBinded_users( $user_id ) {   
	   
	   	$relation_users = ''; 
			 
		    $sql=  "SELECT * FROM  cl_group_members as gm, cl_users as u  WHERE   u.user_id =  gm.user_id AND gm.user_id = '". $user_id ."'    ";  //  AND gm.group_type = 'patient' 
		 	$res = Yii::$app->db->createCommand( $sql )->queryAll();
		    foreach ( $res as $row ) {
			     	  
			    $sql2 =  "SELECT * FROM  cl_users   WHERE  user_id =   '". $row['parent_id'] ."'  "; 
				$res2 = Yii::$app->db->createCommand( $sql2 )->queryAll();
			    foreach ( $res2 as $row2 ) {
				     	  
			    $role_name = ''; 
			    foreach ( $GLOBALS["user_role"] as $key => $value) {
			         if ( $row2['user_role'] == $key ) { $role_name   =  $value; }
			    }
			    $relation_users  .=  $row2['last_name'] .' '. $row2['first_name'] . ' - [ ' . $role_name . ' ]; ' ;    
			      }
			    }
	   
	   return  $relation_users;
	   
    } // end - getBinded_users
  
    public function isAdmin(){
       return $this->user_role == 1;
    }

    public function isSuperAdmin(){
        return $this->user_role == 0;
    }
 
    public function getConsentInfo(){
        if($this->user_role == 4){
            $cons_user = User::findOne($this->consent_user_id);
            return $this->consent? 'yes' . ' ('. $this->consent_time .' by '.$cons_user->first_name .' '.  $cons_user->last_name.')':'no';
        }else{
            return '';
        }
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
        $query = User::find()->with('relations')->where(['!=','user_role',0]);
        $this->load($params);

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


            $dataProvider = new ActiveDataProvider([
                'query' => $query->andFilterWhere(['=', 'provider_id', $provider_id  ]) ,
                'pagination' => [
                    'pageSize' => Providers::getNumUiItems(),
                ],
            ]);

        return $dataProvider;
    }
   
}