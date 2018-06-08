<?php


use yii\helpers\Html;
use yii\widgets\DetailView;

$request = Yii::$app->request; 
$pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 

$this->title = $model->product_title;
$this->params['breadcrumbs'][] = isset($_SESSION['breadcrumbs'][1]) ? $_SESSION['breadcrumbs'][1] : $model->module == 'food_menu' ? ['label' => Yii::t('app','Products : Food Menu'), 'url' =>  ['food_menu']]:[ 'label' => Yii::t('app','Products : Additional Service'), 'url' =>['additional_service']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view">
 
     <div class="row top_btn_line">
		<div class="col-md-4 text-left"> 
			
        <?= Html::a('Update', ['update', 'id' => $model->prod_id, 'pid' => $pid  ], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->prod_id, 'pid' => $pid  ], [
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
            //'prod_id',
            'product_title',
            //'product_type',
             'product_desc:ntext',
            'published',
            //'icon',
            //'options',
            //'food_menu:ntext',
            'sort_id',
        ],
    ]) ?>
    <?=$model->getCreatedUpdated(); ?>
</div>
