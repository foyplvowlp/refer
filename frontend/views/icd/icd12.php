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
        ระหว่าง:
        <?php
        echo yii\jui\DatePicker::widget([
            'name' => 'date1',
            'value' => $date1,
            'language' => 'th',
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
            ]
        ]);
        ?>
        ถึง:
        <?php
        echo yii\jui\DatePicker::widget([
            'name' => 'date2',
            'value' => $date2,
            'language' => 'th',
            'dateFormat' => 'yyyy-MM-dd',
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
            ]
        ]);
        ?>
        <button class='btn btn-danger'>ประมวลผล</button>
    </form>
</div>