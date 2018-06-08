<?php

namespace app\models;

use app\components\DigiCareHelper;
use DateTime;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "cl_1_modules".
 *
 * @property integer $module_id
 * @property string $module_name
 * @property string $sub_module
 * @property integer $sort_order
 * @property string $comment
 * @property string $parent_page
 * @property string $module_icon
 * @property string $link
 * @property string $status
 * @property integer $module_role_id
 * @property boolean $published
 * @property String $created_at
 * @property String $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 */
class Modules extends \yii\db\ActiveRecord
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
        return 'cl_'. DigiCareHelper::getProviderId() .'_modules';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['module_name', 'sort_order', 'comment', 'parent_page', 'module_icon', 'link'], 'required','on'=>['create','update']],
            [['sort_order', 'module_role_id'], 'integer'],
            [['module_name', 'module_icon', 'link'], 'string', 'max' => 255],
            [['sub_module', 'status'], 'string', 'max' => 1],
            [['comment'], 'string', 'max' => 500],
            [['parent_page'], 'string', 'max' => 155],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'module_id' => Yii::t('app','Module ID'),
            'module_name' => Yii::t('app','Module Name'),
            'sub_module' => Yii::t('app','Sub Module'),
            'sort_order' => Yii::t('app','Sort Order'),
            'comment' => Yii::t('app','Comment'),
            'parent_page' => Yii::t('app','Parent Page'),
            'module_icon' => Yii::t('app','Module Icon'),
            'link' => Yii::t('app','Link'),
            'status' => Yii::t('app','Status'),
            'module_role_id' => Yii::t('app','Module Role ID'),
        ];
    }


    public static function getModulesForUser($user_id){
        $user = User::findOne($user_id);
        if(isset($user)){
            $modules = Modules::find()->where(['like','module_role_id',$user->user_role])->asArray()->all();
            return $modules;
        }else{
            return false;
        }
    }

    static public function getForProductsDD(){
        $list = ['food_menu'=>Yii::t('app',' Food Menu'),
            'additional_services'=>Yii::t('app','Services')];
        /*foreach (Modules::find()->where(['module_type'=>'product'])->all() as $module){
            $list[$module->module_id] = Yii::t('app',$module->module_name);
        }*/


        return $list;
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
        $query = Modules::find();

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
            'module_id' => $this->module_id,
            'sort_order' => $this->sort_order,
            'module_role_id' => $this->module_role_id,
        ]);

        $query->andFilterWhere(['like', 'module_name', $this->module_name])
            ->andFilterWhere(['like', 'sub_module', $this->sub_module])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'parent_page', $this->parent_page])
            ->andFilterWhere(['like', 'module_icon', $this->module_icon])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
