<?php
$this->params['breadcrumbs'][] = ['label' => 'ICD', 'url' => ['icd/index']];
$this->params['breadcrumbs'][] = 'รายงาน 10 อันดับโรค Refer IN';
?>

<div class='well'>
    <form method="POST">
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
            ],
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
<div id="sql" style="display: none"><?= $sql ?></div>
<?php
if (isset($dataProvider))
    $dev = \yii\helpers\Html::a('คุณศรศักดิ์ สีหะวงษ์ ปรับปรุงเมื่อ:2015-02-17', 'https://fb.com/sosplk', ['target' => '_blank']);
$date_between = '"' . $date1 . '" - "' . $date2 . '"';


//echo yii\grid\GridView::widget([
echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'responsive' => TRUE,
    'hover' => true,
    'floatHeader' => true,
    'panel' => [
        'before' => 'ระหว่างวันที่ ' . $date_between,
        'type' => \kartik\grid\GridView::TYPE_SUCCESS,
    //'after' => 'โดย ' . $dev
    ],
    'columns' => [
        [
            'attribute' => 'icd10',
            'header' => 'ICD10'
        ],
        [
            'attribute' => 'diag_name',
            'header' => 'ชื่อโรค'
        ],
        [
            'attribute' => 'amt',
            'header' => 'จำนวน'
        ],
    ]
]);
?>

<?php
$script = <<< JS
$('#btn_sql').on('click', function(e) {
    
   $('#sql').toggle();
});
JS;
$this->registerJs($script);
?>



