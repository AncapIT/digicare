<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);  $user_role =  Yii::$app->user->identity->user_role;  
if (  $user_role  > 3  ) {  exit();  } 

$request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  }  
 $doc =  $request->get('doc'); if( !$doc ) { $doc = 0;  } 

$this->title = Yii::t('app','Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="items-index"> 
    
     <div class="row top_btn_line">
		<div class="col-md-3 text-left">   
			<? if( $doc > 0 ) { echo Html::a(Yii::t('app','Add Item'), ['items/create/?&pid=' . $pid . '&doc=' .  $doc ], ['class' => 'btn btn-primary orange_button plus_icon']); }  ?>
		</div>
		<div class="col-md-9 text-center"> <h1><?= Html::encode($this->title)  ?>  </h1> </div>
	 </div>	
	
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        
        'rowOptions' => function ($model, $key, $index, $grid  ) {
	        $request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 
	        $doc =  $request->get('doc'); if( !$doc ) { $doc = 0;  } 
		 	return ['id' => $model['item_id'], 'style' => "cursor: pointer", 'onclick' => 
		 	"  window.location.href = '" . Url::to(['items/view']) . "?&id=". $model['item_id'] ."&pid=".$pid."&doc=".$doc."' ;"];  },
		 	
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'item_id',
            'item_title',
            //'doc_id',
            'item_date',
            //'item_header',
            'doc_type',
            // 'item_content:ntext',
            // 'image',
            // 'pdf_link',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
