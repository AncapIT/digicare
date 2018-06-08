<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\AppAsset;
use yii\helpers\Url;
use app\models\User; 
 

$user_id =  Yii::$app->user->identity->user_id;	
$user_role =  Yii::$app->user->identity->user_role; 
$provider_id =  Yii::$app->user->identity->provider_id;  

$request = Yii::$app->request;



$dc =  $request->get('dc');  
if( $dc ) { 
    
   $sql =  " DELETE  FROM `cl_messages` WHERE  patient_id = '".$dc."'  ";
   $res = Yii::$app->db->createCommand( $sql )->execute();
   Yii::$app->getResponse()->redirect('/messages/index');
}
$view = $request->get('view');
$this->title = $view != 'new'? Yii::t('app','Messages: Messages History') : Yii::t('app','Messages: New Messages');
$this->params['breadcrumbs'][] = $this->title;


$groupFilter= $request->get('group_id');
$patientFfilter= $request->get('patient_id');
$userCond = isset($groupFilter)? " AND m.user_id in (".\app\models\Groups::getUserFilter($groupFilter).") " : '';
$patientCond = isset($patientFilter)? " AND m.patient_id = ".$patientFfilter:"";


if ( $view != 'new' ) { 
	$action = 'index?';
	// ----------------------------------------------------------------------------------- // 
    // ------------------------------ MESSAGES ALL CHATS
    // ----------------------------------------------------------------------------------- //  
  
?>
<div class="messages-index">
 
     <div class="row top_btn_line">
<!--		<div class="col-md-2 text-left">  <?/*= Html::a('New Chat', ['messages/create' ], ['class' => 'btn btn-primary orange_button plus_icon']) */?> </div>
-->		<div class="col-md-8 text-center"> <h1><?= Html::encode($this->title)  ?>  </h1> </div>

	 </div>	
	<div class="row col-md-12"><?= $this->render('_messageFilter',['view' => $view]); ?></div>
	
	<?php  $chat_code = '';

   // select first user from chat		
   $sql =  " SELECT cl_messages.id, cl_messages.user_id, cl_messages.created ,cl_messages.read_by_admin ,
 cl_messages.attachment, cl_messages.message ,cl_messages.patient_id ,cl_group_members.group_id as group_id FROM `cl_messages` 
     LEFT JOIN `cl_group_members` on cl_messages.patient_id = cl_group_members.user_id 
      RIGHT JOIN (SELECT max(id) as mid FROM `cl_messages` GROUP BY patient_id) as maxid on maxid.mid = cl_messages.id  
     WHERE cl_messages.user_id > 0 ".$userCond ." ".$patientCond." 
 GROUP BY patient_id ORDER BY id ASC  ";
   $res = Yii::$app->db->createCommand( $sql )->queryAll();
   foreach ( $res as $row ) {    $first_user =  $row['user_id'];   $chat_group =  $row['patient_id'];
	     		    
	   $patient_1 = User::find()->where(['user_id' => $row['patient_id']])->one();
       $user_1 = User::find()->where(['user_id' => $row['user_id']])->one();
	   if(isset($user_1) && isset($patient_1)){


	   $last_message = $row['message'];   
	   ?>
           <div class="row message_row mess_group_<?= $chat_group?> group_<?= $row['group_id']?>" data-link="<?=  \Yii::$app->request->BaseUrl; ?>/messages/create?&chat_group=<?= $chat_group ?>">
	   		<div class="col-md-2 text-center">
                <div class="row"><img src="<?=  \Yii::$app->request->BaseUrl. '/web/uploads/users/'. $patient_1->photo  ?>" class="round_image chat_imgs"></div>
                <div class="row"><span><?= $patient_1->first_name .'&nbsp'.$patient_1->last_name?></span>  </div>
                </div>
	   		<div class="col-md-10 text-left">
		   		<span> <?=  $row['created']  ?></span> - <b>Last message:</b> <br>  <b><?=  $user_1->first_name .' '. $user_1->last_name ?></b> <br/>  <i><?= substr( $last_message, 0, 250 ). '...';  ?></i>
		   	</div>
	   		<div class="col-md-1 text-right"> 
		   		<!-- <a href="<?/*=  \Yii::$app->request->BaseUrl; */?>/messages/index?&dc=<?/*= $chat_group */?>" class="chat_delete_btn"> <i class="icon ion-trash-a"></i> </a>-->
		    </div>
	</div>	
	<?php  } }  ?>
	
	 
</div>

<?php }  else {

    $action = 'index?view=new&';
   
   
   
   
   
    // ----------------------------------------------------------------------------------- // 
    // ------------------------------ LAST 30 MESSAGES 
    // ----------------------------------------------------------------------------------- //  
  
 ?> 
 
 <div class="row top_btn_line">
		 <div class="col-md-12 text-center"> <h1><?= Yii::t('app','New Messages')?> </h1> </div>
     <?= $this->render('_messageFilter',['view' => $view]); ?>
 </div>	

	 <?php

  $sql =  " SELECT max(m.id) as id, m.user_id, m.created, m.read_by_admin, m.attachment, m.message, m.patient_id, cl_group_members.group_id as group_id  
 FROM `cl_messages`  m
     LEFT JOIN `cl_group_members` on m.patient_id = cl_group_members.user_id   
LEFT JOIN `cl_users`  u  on   m.user_id = u.user_id 
 RIGHT JOIN (SELECT max(id) as mid FROM `cl_messages` where read_by_admin = 0 GROUP BY patient_id) as maxid on maxid.mid = m.id  
 where m.read_by_admin = 0 ".$userCond ." ".$patientCond." 
 AND u.provider_id = '".$provider_id."' GROUP BY m.patient_id ORDER BY m.id DESC LIMIT 20";
  $res = Yii::$app->db->createCommand( $sql )->queryAll();
  foreach ( $res as $row  ) {  
      
  $user_data = User::find()->where(['user_id' => $row['user_id']  ])->one();
      $patient_data = User::find()->where(['user_id' => $row['patient_id']  ])->one();
      if(isset($user_data) && isset($patient_data)){
?> 

<div class="row message_row mess_group_<?= $row['patient_id']?> group_<?= $row['group_id']?>" data-link="<?=  \Yii::$app->request->BaseUrl; ?>/messages/create?&view=new&chat_group=<?= $row['patient_id']  ?>">
	   		<div class="col-md-2 text-center">
                <div class="row"><img src="<?=  \Yii::$app->request->BaseUrl. '/web/uploads/users/'. $patient_data->photo  ?>" class="round_image chat_imgs"></div>
                <div class="row"> <span><?= $patient_data->first_name .'&nbsp'.$patient_data->last_name?></span></div>
            </div>
	   		<div class="col-md-10 text-left">
		   		<span> <b><?=  $user_data->first_name .' '. $user_data->last_name ?></b> <br/> <?=  $row['created']?></span> <br> <i><?= $row['message'];  ?></i>
		   	</div>
	   		 
	</div>


<?php } } } ?>
