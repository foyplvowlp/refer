<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'รายงาน รหัสโรค', 'url' => ['icd/index']];
//$this->params['breadcrumbs'][] = 'รายงาน 10 อันดับการให้รหัสโรคแพทย์แผนไทย';
//$this->title = 'DHDC-รายงานแพทย์แผนไทย';
?>
<!-- Small boxes (Stat box) -->
<div class="row1">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>
                    1
                </h3>
                <p>
                    อันดับโรคผู้ป่วย Refer IN ทั้งหมด
                </p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
<?= Html::a('รายละเอียดเพิ่มเติม', ['icd/icd10'], ['class' => 'small-box-footer']) ?>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>
                    2
                </h3>
                <p>
                    อันดับโรคผู้ป่วย Refer IN แยกตามโรงพยาบาลชุมชนในจังหวัด
                </p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
<?= Html::a('รายละเอียดเพิ่มเติม', ['icd/icdlist'], ['class' => 'small-box-footer']) ?>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>
                    3
                </h3>
                <p>
                    อันดับโรคผู้ป่วย Refer Back ทั้งหมด
                </p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">
                รายละเอียดเพิ่มเติม <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div><!-- ./col -->
</div>