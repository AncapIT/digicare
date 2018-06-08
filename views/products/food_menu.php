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
 
if ( $user_role > 0 ) { $pid = $provider_id ;  }

$this->title = Yii::t('app','Products : Food Menu');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">
     
       <div class="row top_btn_line">
		<div class="col-md-2 text-left">  <?= Html::a(Yii::t('app','Add Product'), ['products/create/?&pid=' . $pid ], ['class' => 'btn btn-primary orange_button plus_icon']) ?> </div>
		<div class="col-md-8 text-center"> <h1><?= Html::encode($this->title)  ?>  </h1> </div>
		<div class="col-md-2 text-right"> 
			<?php if ( $user_role == 0 ) { ?>
			<select class="provider_select form-control">
				   <?  
						
				   $sql =  "SELECT * FROM  cl_providers WHERE status <> 1   ";
				   $res = Yii::$app->db->createCommand( $sql )->queryAll();
				   foreach ( $res as $row ) { 	?> 
				    	<option value="<?=  $row['provider_id'] ?>"  <?php if( $row['provider_id'] == $pid ) { ?> selected="selected" <?php } ?>>
						<?=  $row['provider_title'] ?></option>
				   <? } ?>
			</select>
			<?php } ?>
		</div>
	</div>	
    
    <?= GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
           
        'rowOptions' => function ($model, $key, $index, $grid  ) {
	        $request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 
		 	return ['id' => $model['prod_id'], 'style' => "cursor: pointer", 'onclick' => 
		 	"  window.location.href = '" . Url::to(['products/update']) . "?&id=". $model['prod_id'] ."&pid=".$pid."' ;"];  },
 
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'prod_id',
            'product_title',
           'product_desc:ntext',
            'module',
            'sort_id',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
