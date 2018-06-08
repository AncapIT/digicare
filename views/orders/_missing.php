<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 07.03.18
 * Time: 19:04
 */

$product = \app\models\Products::find()->where(['prod_id'=>$prod_id])->one();
$table_data = [];
if(isset($product)){
    $table_data = $product->getDataForMissingReport();
}
?>

    <div class="row">
        <h4 style="display: inline-block"><?= Yii::t('app','Food menu order missing')?>:</h4> <span style="display: inline-block">&nbsp;<?= count($table_data)?></span><br>
        <ul>
            <?php foreach ($table_data as $user) {
                echo "<li>".$user["first_name"]." ".$user['last_name']."</li>";
            }?>

        </ul>
    </div>

<?php

