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
        $table_data = $product->getDataForReport();
    }
?>

<div class="row">
    <h4><?= Yii::t('app','Summary')?>:</h4><br>
    <table class="table table-striped">
        <?php foreach ($table_data as $item=>$item_data){

          //  var_dump($item_data);
            ?>
        <tr>
            <td><h4><?= Yii::t('app',Yii::t('app',$item))?></h4></td><td></td><td></td></tr>
            <?php if(isset($item_data['items']) && is_array($item_data['items']) && count($item_data['items']) > 0){
                foreach ($item_data['items'] as $key=>$val) {
                    if($val['count']){
                      ?>
                    <tr><td></td><td><?= Yii::t('app',Yii::t('app',$key))?></td><td><?= $val['count'] ?></td></tr>
                    <?php }
                }}
                ?>

        <?php } ?>
    </table>
</div>
<div class="row">
    <h4><?= Yii::t('app','Details')?>:</h4><br>
    <table class="table table-striped">
        <?php foreach ($table_data as $item=>$item_data){ ?>
            <tr>
                <td><h4><?= Yii::t('app',Yii::t('app',$item))?></h4></td><td></td><td></td></tr>

            <?php if(isset($item_data['items']) && is_array($item_data['items']) && count($item_data['items']) > 0){
                 $users = \app\models\ProductItemsChoices::getReportDetaisData($item_data['prod_item_id']);
                foreach ($item_data['items'] as $key=>$val) {
                    ?>
                    <tr><td></td><td><?= Yii::t('app',Yii::t('app',$key))?>
                       <ul> <?php
                           if(isset($users[$val["pic_id"]]))
                           foreach ($users[$val["pic_id"]] as $key=>$u){
                           echo "<li>".$u['name']." ( ".$u['cnt']." )</li>";
                           } ?></ul>
                        </td><td><?= $val['count']? $val['count']:''?></td></tr>
                    <?php
                }}
            ?>

        <?php } ?>
    </table>
</div>
<?php

