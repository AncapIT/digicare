<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\AppAsset;
use yii\helpers\Url;

 // -------- check access level ---------
$provider_id =  Yii::$app->user->identity->provider_id;	
$user_role =  Yii::$app->user->identity->user_role;   
// --- end - check access level

$request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 


$this->title = Yii::t('app','Modules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <div class="row top_btn_line">
		<div class="col-md-2 text-left">  <?= Html::a(Yii::t('app','Add Module'), ['create'], ['class' => 'btn btn-primary orange_button plus_icon']) ?> </div>
		<div class="col-md-8 text-center"> <h1><?= Html::encode($this->title)  ?>  </h1> </div>
		<div class="col-md-2 text-right"> 
			
			<? if ( $user_role == 0 ) { ?>
			<select class="provider_select form-control">
				   <?  
						
				   $sql =  "SELECT * FROM  cl_providers WHERE status <> 1   ";
				   $res = Yii::$app->db->createCommand( $sql )->queryAll();
				   foreach ( $res as $row ) { 	?> 
				    	<option value="<?=  $row['provider_id'] ?>"  <? if( $row['provider_id'] == $pid ) { ?> selected="selected" <? } ?>>
						<?=  $row['provider_title'] ?></option>
				   <? } ?>
			</select>
			<? } ?>
		</div>
	</div>	
	
	<?
		
		 $menu_icon = array( 'attribute' => 'menu_icon', 'filter'=> $GLOBALS["big_menu_icons"] , 
	  	 'content' =>  function($data){   return  $data->getMenu_Icon_name( $data['menu_icon']  );  });
	?>
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        
        'rowOptions' => function ($model, $key, $index, $grid  ) {
	        $request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 
		 	return ['id' => $model['mid'], 'style' => "cursor: pointer", 'onclick' => 
		 	"  window.location.href = '" . Url::to(['menu/view']) . "?&id=". $model['mid'] ."&pid=".$pid."' ;"];  },
		 
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'mid',
            'menu_title',
            'parent_page',
            'home_flag',
            $menu_icon,
            //'menu_icon',
            // 'menu_link',
            // 'menu_type',
            // 'status',
            // 'level',
            // 'page_desc:ntext',
            // 'sort_id',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
