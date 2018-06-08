<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

  
$this->title =   $model->item_title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app','Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$request = Yii::$app->request; 
$pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 
$doc =  $request->get('doc'); if( !$doc ) { $doc = 0;  }

?>
<div class="items-view">
 
    <div class="row top_btn_line">
		<div class="col-md-4 text-left"> 
			
        <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $model->item_id, 'pid' => $pid, 'doc' => $doc  ], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->item_id, 'pid' => $pid, 'doc' => $doc  ], [
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
            'item_id',
            //'doc_id',
            [   
            'label' => Yii::t('app','Document'),
            'value' => $model->getDocument_name( $pid, $model->doc_id  ), 
             ],
            'doc_type',
            'item_date',
            'item_title',
            'item_header',
            'item_content:html',
            'pdf_link',
            [
			    'attribute'=>'image',
			    'value'=> \Yii::$app->request->BaseUrl. '/web/uploads/news/'.  $model->image,
			    'format' => [ 'image',[ 'width'=> '320']],
			],
        ],
    ]) ?>


</div>
