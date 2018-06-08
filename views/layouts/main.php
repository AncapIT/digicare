<?php
  
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
$this->registerJsFile('//code.jquery.com/jquery-1.10.2.js');
$this->registerJsFile('@web/js/ckeditor-standart/ckeditor.js',[],'cke');
$this->registerJsFile('//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js');
$this->registerJsFile('@web/js/scripts.js',[],'scr');
$this->registerCssFile('@web/css/ionicons/ionicons.css');
$this->registerCssFile('@web/css/carelink.css');
$this->registerCssFile('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css');
$this->registerJsFile('//code.jquery.com/ui/1.11.4/jquery-ui.js');

if ( !Yii::$app->user->isGuest ) {
    // -------- check access level ---------
    $user_role = Yii::$app->user->identity->user_role;

}
  
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php $this->head() ?>
    <?php $request = Yii::$app->request;  ?>
	   
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
	
	$user_role = '';  $user_id = ''; 
	if ( !Yii::$app->user->isGuest ) {  $user_role =  Yii::$app->user->identity->user_role;  $user_id =  Yii::$app->user->identity->user_id;    }
	else { 
		// redirect to login form   
		if ( Yii::$app->controller->action->id != 'login' && Yii::$app->user->isGuest ) {  
		       Yii::$app->getResponse()->redirect('/site/login');
		 }
	}
         
    NavBar::begin([
        'brandLabel' => '<b> '.Yii::t('app','DigiCare').' </b>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top top_logo',
        ],
    ]);
   
    /*   
    if ( $user_role > 0  ) {
	      $menu_items[] = [ 'label' => 'Home', 'url' => ['/site/index']]; 
    } */
             
    // ----------------------------------------------------------------------------------- // 
    // ------------------------------ ADMIN MENU ITEMS 
    // ----------------------------------------------------------------------------------- //  
  
    
    if ( !Yii::$app->user->isGuest && $user_role == 0 ) {   // only for SuperAdmin
	           
	    $menu_items[] = [
	            'label' => Yii::t('app','Providers'),
	            'items' => [
	                /* ['label' => Yii::t('app','Providers List'), 'url' => ['/providers/index']],
	                 '<li class="divider"></li>',*/
	                 ['label' => Yii::t('app','Add new Provider'), 'url' => ['/providers/create']],
	                 '<li class="divider"></li>',
	                ],
	            ];  
	         
    } // for Admin 
    
    
    
    
    
    
    
    
    if ( $user_role == 1 ) {  
	    
	    
	$provider_id =  Yii::$app->user->identity->provider_id;
	
	$menu_items[] = [
	    'label' => Yii::t('app','Orders'),
        'items' => [
            [ // sublevel items ---------
                'label' => Yii::t('app','Orders - Services'),

                'items' => [
                    ['label' => Yii::t('app','New Orders'), 'url' => ['/orders/new_orders']],
                    ['label' => Yii::t('app','In Progress'), 'url' => ['/orders/in_progress']],
                    ['label' => Yii::t('app','Orders History'), 'url' => ['/orders/index']],
                ],
            ], // end - sublevel

            '<li class="divider"></li>',

            [ // sublevel items ---------
                'label' => Yii::t('app','Orders - Food'),
                'items' => [
                    ['label' => Yii::t('app','Report'), 'url' => ['/orders/report']],
                    ['label' => Yii::t('app','Missing Orders'), 'url' => ['/orders/missing_orders']],
                    ['label' => Yii::t('app','All Orders'), 'url' => ['/orders/index2']],
                ],
            ], // end - sublevel

//            '<li class="divider"></li>',

        ],
//            'items' => [
//
//                 //'<li class="divider"></li>',
//                 ['label' => 'All Orders', 'url' => ['/orders/index']],
//                 //'<li class="divider"></li>',
//                ],
            ]; 
                
  
          
    $menu_items[] = [
            'label' => Yii::t('app','Documents'),
            'items' => [
	            
	              ['label' => Yii::t('app','Documents List'), 'url' => ['/documents/index'] ],
                 '<li class="divider"></li>',
	              
                  [ // sublevel items ---------
                    'label' => Yii::t('app','Patients'),
                    
                    'items' => [
                         ['label' => Yii::t('app','About Patient'), 'url' => ['/documents/index?Documents[doc_type]=about_patient']],
		                 ['label' => Yii::t('app','Implementation'), 'url' => ['/documents/index?Documents[doc_type]=implementation']],
		                 ['label' => Yii::t('app','Diary'), 'url' => ['/documents/index?Documents[doc_type]=diary']],
		            ],
                  ], // end - sublevel
                 
                 '<li class="divider"></li>', 
                 
                  [ // sublevel items ---------
                    'label' => Yii::t('app','All and Groups'),
                    'items' => [
                         ['label' => Yii::t('app','Billboard'), 'url' => ['/documents/index?Documents[doc_type]=billboard']],
		                 ['label' => Yii::t('app','Calendar'), 'url' => ['/documents/index?Documents[doc_type]=calendar']],
		                 ['label' => Yii::t('app','Newsletter'), 'url' => ['/documents/index?Documents[doc_type]=newsletter']],
                    ],
                  ], // end - sublevel
                  
                  '<li class="divider"></li>', 
                
                ],
            ]; 
            
      $menu_items[] = [
            'label' => Yii::t('app','Messages'),
            'items' => [
                 ['label' => Yii::t('app','New Messages'), 'url' => ['/messages/index?view=new']],
                 '<li class="divider"></li>',
                 ['label' => Yii::t('app','Messages History'), 'url' => ['/messages/index']],
                ],
            ]; 
            
                      
    $menu_items[] = [
            'label' => Yii::t('app','Products'),
            'items' => [
                /* ['label' => 'Products List', 'url' => ['/products/index']],
                 '<li class="divider"></li>',*/
                ['label' => Yii::t('app','Additional Services'), 'url' => ['/products/additional_service']],
                '<li class="divider"></li>',
                ['label' => Yii::t('app','Food Menu'), 'url' => ['/products/food_menu']],
                '<li class="divider"></li>',
                ],
			];
			 
	// -------
	
	 /* $menu_items[] = [
            'label' => Yii::t('app','Reports'),
            'items' => [
                 ['label' => Yii::t('app','Reports Log'), 'url' => ['#']],
                 '<li class="divider"></li>', 
                ],
            ]; */
            		
      $menu_items[] = [
            'label' => Yii::t('app','Users'),
            'items' => [
                 ['label' => Yii::t('app','Users List'), 'url' => ['/user/index']],
                 '<li class="divider"></li>',
                 ['label' => Yii::t('app','Groups'), 'url' => ['/user/groups']],
                 '<li class="divider"></li>',
                ],
            ];  
            
     
    $menu_items[] = [
            'label' => Yii::t('app','Settings'),
            'items' => [
                 ['label' => Yii::t('app','Provider info'), 'url' => ['providers/view?&id=' . $provider_id ]],
                 '<li class="divider"></li>',
                 ['label' => Yii::t('app','Modules'), 'url' => ['/modules/index']],
                ],
            ];
            
          
         
            
            
    }   // end admin access  
                
    
    $menu_items[] =  (Yii::$app->user->isGuest ) ? (
                ['label' => Yii::t('app','Login'), 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    Yii::t('app','Logout'),
                    ['class' => 'btn btn-link', 'id' => 'logout_btn' ]
                )
                . Html::endForm()
                . '</li>'
            );  
            
    
       echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right', 'id' => 'topmenu'],
        'items' =>   $menu_items,
    ]);  
    
    
    
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]); ?>
        <?php if ( $user_role > 1 ) {  echo '<h1>'.Yii::t('app','Sorry, you are not authorized to access this system').'</h1>';   }
        // --- end - check access level
         else {echo $content;} ?>
     </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; DigiCare <?= date('Y') ?></p>

        <p class="pull-right"> DigiCare Admin CMS </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();  ?>

<?php  // $password = ''; echo $hash = Yii::$app->getSecurity()->generatePasswordHash($password); die();  //  <---- delete ?>
