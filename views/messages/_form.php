<?php

use app\models\Providers;
use app\models\User;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$user_id = Yii::$app->user->identity->user_id;
$user_role = Yii::$app->user->identity->user_role;
$provider_id = Yii::$app->user->identity->provider_id;

if ($user_role > 3) {
    exit();
}

$request = Yii::$app->request;
$chat_group = $request->get('chat_group');


$providers = new Providers();
$users = new User();
$users = new User();
$users_list = $users->getRelations_list($provider_id);
?>
<br/>
<div id="messages_block">

    <?php

    if ($chat_group > 0) {

        $sql = " SELECT * FROM `cl_messages` WHERE patient_id = " . $chat_group . "  ORDER BY id ASC  ";
        $res = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($res as $row) {

            if ($row['user_id'] > 0) {
                $user_data = $users->find()->where(['user_id' => $row['user_id']])->one();

                if ($row['read_by_admin']) {
                    $color_class = '';
                } else {
                    $color_class = 'grey_message_row';
                }
                ?>

                <div class="row chat_row <?= @$color_class ?>">
                    <div class="col-md-2 text-center">
                        <img src="<?= \Yii::$app->request->BaseUrl . '/web/uploads/users/' . @$user_data["photo"] ?>"
                             class="round_image chat_imgs">
                    </div>
                    <div class="col-md-8 text-left">
                        <span> <?= @$row['created'] ?></span> -
                        <b><?= @$user_data["first_name"] . ' ' . @$user_data["last_name"] ?>:</b>
                        <br> <i><?= @$row['message']; ?></i>
                        <?php if (@$row['attachment']) { ?> <br/> <img
                            src="<?= \Yii::$app->request->BaseUrl . '/web/uploads/chat/' . $row["attachment"] ?>"
                            class="chat_attachment"><?php } ?>
                    </div>

                </div>

            <?php }
        }
    }

    ?> </div>

<div class="messages-form" id="new-mess-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php /*  ---------------------------- GET USER STATUS TITLE -----------------------------------------  */


    function getUser_role_name($user_role)
    {
        $item_name = '';
        foreach ($GLOBALS["user_role"] as $key => $value) {
            if ($user_role == $key) {
                $item_name = $value;
            }
        }
        return $item_name;
    }

    ?>


    <?php //--------------------------- FIELD USER TO
    if (!$chat_group) {


        // SELECT LIST -  TYPE
        echo $form->field($model, 'user_id')->widget(Select2::classname(), [
            'data' => $users_list,
            'language' => 'en',
            'options' => ['placeholder' => 'Select a sender...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); // END - SELECT LIST

    } else { ?>
        <input type="hidden" name="Messages[user_id]" value="<?= $user_id ?>">
    <?php } ?>







    <?php //--------------------------- FIELD GROUP ID
    if (!$chat_group) {

        ?> <b> <?=Yii::t('app','Users') ?> </b>  <?php
        $sql = " SELECT * from `cl_users` WHERE user_role = 4  ORDER BY first_name   ";
        $res = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($res as $row) {
            $groups_list[$row['user_id']] = $row['first_name']." ".$row['last_name'];
        }

        // Multiple select without model
        echo Select2::widget([
            'name' => 'patient_id',
            'value' => '',
            'data' => $groups_list,
            'options' => ['multiple' => true, 'placeholder' => 'Select the Users Group ...']
        ]); ?>
        <br/>
    <?php } else { ?>
        <input type="hidden" name="saved_group_id" value="<?= $chat_group ?>">
    <?php } ?>

    <input type="hidden" name="Messages[created]" value="<?= date("Y-m-d H:i:s"); ?>">


    <?php // ----------------------- Attachment

    echo $form->field($model, 'attachment')->widget(FileInput::classname(), [
        'name' => 'attachment',
        'options' => [
            'multiple' => false, 'accept' => 'image/*', 'resizeImages' => true
        ],
        'pluginOptions' => [
            'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
            'browseLabel' => Yii::t('app','Select Photo')
        ],
    ]); ?>


    <?php // $form->field($model, 'message')->textarea(['rows' => '6']) ?>
    <?= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>

    <input type="hidden" name="Messages[chat]" value="<?= $request->get('chat') ?>">

    <div class="form-group text-center">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Send message') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Mark as Read and Close'),['messages/index','view'=>$view ,'read_group'=>$chat_group],['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Keep as Unread and Close'),['messages/index','view'=>$view],['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <script type="text/javascript">
        jQuery(document).ready(function () {
            $(window).scrollTop(  jQuery(".grey_message_row:first").offset().top -60);
        })
    </script>
</div>


