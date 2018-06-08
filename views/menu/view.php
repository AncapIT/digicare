<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */

$this->title = $model->menu_title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Modules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$request = Yii::$app->request; 
$pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 

?>
<div class="menu-view"> 
    
    
    <div class="row top_btn_line">
		<div class="col-md-4 text-left"> 
			
        <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $model->mid, 'pid' => $pid  ], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->mid, 'pid' => $pid  ], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app','Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
         </div>
        <div class="col-md-6 text-center"> <h1><?= Html::encode($this->title)  ?>  </h1> </div>
	</div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'mid',
            'menu_title',
            'parent_page',
            'home_flag',
            'menu_icon',
            'menu_link',
            'menu_type', 
             [   
            'label' => Yii::t('app','Status'),
            'value' => $model->getMenu_Status_name( ), 
             ],  
            'level',
            'page_desc:html',
            'sort_id',
        ],
    ]) ?>

</div>
