<?php

use app\models\OrderStatus;
use yii\helpers\Html;
use yii\widgets\DetailView;

$request = Yii::$app->request; 
$pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  } 

$this->title = $model->order_title;
$this->params['breadcrumbs'][] = isset($_SESSION['breadcrumbs']) ? $_SESSION['breadcrumbs'] : ['label' => Yii::t('app','Orders - Food : History'), 'url' => ['index2']];
$this->params['breadcrumbs'][] = $this->title;

$provider_id =  Yii::$app->user->identity->provider_id;	
   
?>
<div class="orders-view">
     
     <div class="row top_btn_line">
		<div class="col-md-4 text-left"> 
			
        <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $model->order_id, 'pid' => $pid  ], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->order_id, 'pid' => $pid  ], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app','Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
         </div>
        <div class="col-md-6 text-center"> <h1><?= Html::encode($this->title)  ?>  </h1> </div>
	</div>
  <?php 
	 $orders_html = ''; 
	 $order_items =  $model->getOrder_items_data();
	 foreach ( $order_items as $order ) { 
		 $orders_html .= $order . '<br/>'; 
	 }
  ?>

    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-1"> </div>
        <?php foreach ($GLOBALS["order_status"] as $sid => $status): ?>
            <?php $oStatus = OrderStatus::find()->andWhere(['order_id' => $model->order_id, 'status' => $sid])->one() ?>
            <div class="col-md-2">
                <?php if ($oStatus): ?>
                    <div>
                        <?= Html::button(Html::encode($status), [
                            'class' => 'btn_change_status btn btn-lg btn-block disabled ' . ($sid == 5 ? 'btn-danger' : 'btn-success'),
                        ]) ?>
                    </div>
                    <div>
                        <?= $oStatus->created_at ?><br />
                        <?= Html::encode($oStatus->user->fullname) ?>
                        (<?= $oStatus->user_id ?>)
                    </div>
                <?php elseif (in_array($model->order_status, [4,5])): ?>
                    <?= Html::button(Html::encode($status), [
                        'class' => 'btn_change_status btn btn-lg btn-block disabled btn-default',
                    ]) ?>
                <?php else: ?>
                    <?= Html::button(Html::encode($status), [
                        'class' => 'btn_change_status btn btn-lg btn-block btn-default',
                        'data' => [
                            'status' => $sid,
                            'url' => \yii\helpers\Url::to(['update-status', 'id' => $model->order_id, 'status' => $sid]),
                        ],
                    ]) ?>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_id',
            'order_title',
            [   
            'label' => 'User',
            'value' => $model->getUser_name(   $model->user_id  ), 
             ],
           [ 'label' => 'Patient',
            'value' => $model->getUser_name(   $model->patient_id  ),
             ],
           // 'product_type',
            //'selected_items',
            'create_date',
            'price',
             [   
            'label' => 'Order Items',
            'format' => 'html',
            'value' =>  $orders_html , 
             ],
             [   
            'label' => 'Status',
            'value' => $model->getOrder_status_title(   $model->order_status  ), 
             ],
        ],
    ]) ?>

    <?=$model->getCreatedUpdated(); ?>

</div>

<?php $this->registerJs(<<<'JS'
$(".btn_change_status").click(function() {
    var btn = $(this);
    if (btn.hasClass("disabled")) return;
    //btn.addClass("disabled");
    
    var status = parseInt(btn.data("status"));
    
    $.post(btn.data("url"), function(data) {
        //console.log(data);
    });
    
    // if (status === 5) { // canceled
    //     btn.addClass("btn-danger disabled");
    //     $(".btn_change_status:not(.disabled)").addClass("disabled");
    //     return;
    // }
    //
    // $(".btn_change_status:not(.disabled)").each(function(_, b) {
    //     b = $(b);
    //     var sid = parseInt(b.data("status"));
    //     if (sid <= status) b.addClass("btn-success disabled");
    // });
});
JS
); ?>
