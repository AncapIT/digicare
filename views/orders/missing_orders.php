<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 07.03.18
 * Time: 16:12
 */

use app\models\Products;
use yii\helpers\Html;
$this->title = 'Orders - Food : Missing Orders';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <h1><?= Yii::t('app','Food Report Missing Orders')?></h1>
    <div class="row">
        <form id="report_prod_form">
            <h3><?= Yii::t('app','Food menu')?>:</h3>
            <?= Html::dropDownList('menu',null,Products::getFoodListForDD(),['onchange'=>'ajaxReport()']) ?>
        </form>
    </div>
    <div id="report">

    </div>

    <script type="text/javascript">
        function ajaxReport() {
            $.ajax(
                {   url:'<?= \yii\helpers\Url::to(['orders/ajax_missing_report'])?>',
                    type: "POST",
                    data: $("#report_prod_form").serialize(),
                    success : function (data) {
                        $("#report").html(data);
                    }
                })
        }
    </script>
</div>
