<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Documents */

$this->title = Yii::t('app',"View").": " . $model->doc_title;

$this->params['breadcrumbs'][] = isset($_SESSION['breadcrumbs']) ? $_SESSION['breadcrumbs'] : ['label' => Yii::t('app','Documents List'), 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;

 // -------- check access level ---------
$provider_id =  Yii::$app->user->identity->provider_id;	
$user_role =  Yii::$app->user->identity->user_role;   
// --- end - check access level

$request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 

if ( $user_role > 0 && ( $pid != $provider_id )  ) {  echo '<h1>'.Yii::t('app','Access is denied').'!</h1>'; die();  }
if ( $user_role > 0 ) { $pid = $provider_id ;  }


$request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 
?>
<div class="documents-view">

    <div class="row top_btn_line">
		<div class="col-md-4 text-left"> 
			
        <?= Html::a('Update', ['update', 'id' => $model->doc_id, 'pid' => $pid  ], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->doc_id, 'pid' => $pid  ], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        
         </div>
        <div class="col-md-8 text-center"> <h1><?= Html::encode($this->title)  ?>  </h1> </div>
	 </div>
     

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'doc_id',
            'doc_title',
            //'user_id',
            [   
            'label' => 'User',
            'value' => $model->getUser_name( $model->user_id  ), 
             ],
            'doc_header',
            'doc_type',
            'doc_date',
            'doc_content:html',
             // 'doc_options',
            //'doc_image',
             'published',
            'pdf_link',
            [
			    'attribute'=>'doc_image',
			    'value'=> \Yii::$app->request->BaseUrl. '/web/uploads/news/'.  $model->doc_image,
			    'format' => [ 'image',[ 'width'=> '320']],
			],
			'category_desc',
        ],
    ]) ?>

    <?=$model->getCreatedUpdated(); ?>
</div>
