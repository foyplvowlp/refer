<?php
$this->params['breadcrumbs'][] = ['label' => 'แพทย์แผนไทย', 'url' => ['knott/index']];
$this->params['breadcrumbs'][] = 'รายงาน 10 อันดับการให้รหัสโรคแพทย์แผนไทย';
$this->title = 'DHDC-รายงานแพทย์แผนไทย';
?>
<div class='well'>
    <form method="POST">
        สถานบริการ:
        <?php
        $list = yii\helpers\ArrayHelper::map(frontend\models\Hospcode::find()->all(), 'hoscode', 'hosname');
        echo yii\helpers\Html::dropDownList('hospcode', $hospcode, $list, [
            'prompt' => 'ทุกสถานบริการ',
        ]);
        ?>
    </form>
</div>