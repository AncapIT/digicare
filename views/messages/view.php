<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Messages */

$this->title = $model->id;
$this->params['breadcrumbs'][] = isset($_SESSION['breadcrumbs']) ? $_SESSION['breadcrumbs'] : ['label' => Yii::t('app','Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$request = Yii::$app->request; $chat_code = $request->get('chat') ; 
 
// Redirect to chat log
Yii::$app->getResponse()->redirect('/messages/create?&chat=' . $chat_code );
  
?>
<div class="messages-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app','Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app','Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id', 
            'created',
            'status',
            'attachment',
            'message',
        ],
    ]) ?>

    <?=$model->getCreatedUpdated(); ?>

</div>
