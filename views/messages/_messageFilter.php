<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 07.03.18
 * Time: 12:42
 */


$groups = \app\models\GroupMembers::find()->where(['group_type'=>'group'])->all();
$filter_groups=[];
$filter_users=[];
$patients = \app\models\User::find()->where(['user_role'=>4,'login_allowed'=>1])->all();
foreach ($groups as $group){
    $filter_groups[$group->group->group_id] =  $group->group->name;

}
/*
foreach ($patients as $patient){
    $filter_users[$patient->user_id] = $patient->first_name.' '.$patient->last_name;
}*/


?>
<div class="row col-md-12">
<div class="col-md-6 filter-d">

<h5 style="display:inline-block;"><?= Yii::t('app','Filter by:')?></h5>


        <select id="admin_ui_mess_filter_group_select">
            <option value="0">Select Group</option>
            <?php
            foreach ($filter_groups as $val => $group){
           echo '<option value="'.$val.'">'.$group.'</option>';
            }
            ?>
        </select>
    &nbsp; &nbsp;
        <select id="admin_ui_mess_filter_user_select" >
            <option value="0">Select Patient</option>
            <?php
            foreach ($patients as $patient){
                 echo '<option value="'.$patient->user_id.'">'.$patient->first_name.'&nbsp'.$patient->last_name.'</option>';
            }
            ?>
        </select>
    <br>
</div>
</div>

<script type="text/javascript">


    function setGroupOptions(id) {
        $('#admin_ui_mess_filter_group_select').val(id);
    }

    function setUsersOptions(id) {
        $('#admin_ui_mess_filter_user_select').val(id);
    }

    $(document).ready(function () {
        $('#admin_ui_mess_filter_group_select').change(function () {
            var id = $(this).val();
            setUsersOptions(0);
            $('.message_row').show();
            if(id != 0){

                $('.message_row').hide();
                $('.group_'+id).show();
            }
        });
        $('#admin_ui_mess_filter_user_select').change(function () {

            var id = $(this).val();
            setGroupOptions(0);
            $('.message_row').show();
            if(id != 0){

                $('.message_row').hide();
                $('.mess_group_'+id).show();
            }

        });
    })

</script>