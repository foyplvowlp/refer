<?php

use miloschuman\highcharts\Highcharts;
use kartik\grid\GridView;

/* @var $this yii\web\View */
$this->title = 'ThaiRefer Chiangkhan Hospital';
$date_m = date("Y-m");
$date_d = date("Y-m-d");
$date_my = date("m-Y");
?>

<div class="site-index">
    <div class="body-content">
        <section class="content">
            <div class="row">

                <div class="col-lg-3 col-xs-6">
                    <div class="alert alert-success" role="alert">
                        <!-- small box -->
                        <div class="inner">
                            <center>
                                <p class="text-success">
                                    ข้อมูลการรับ ประจำเดือน </br><?php echo $date_my; ?>
                                </p><hr>
                            </center>
                            <center>
                                <h3>
                                    <?php
                                    $command = Yii::$app->db->createCommand("select count(referout_no) as referout_total from referout_reply where referout_date BETWEEN '" . $date_m . "-01' and '" . $date_m . "-31'");
                                    $target = $command->queryScalar();

                                    echo $target;
                                    ?>
                                    ราย</h3>
                            </center>
                        </div>
                        <center>
                            <a href="#" class="small-box-footer">
                                รายละเอียดเพิ่มเติม <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </center>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="alert alert-danger" role="alert">
                        <div class="inner">
                            <center>
                                <p class="text-danger">
                                    ข้อมูลการส่งต่อ ประจำเดือน </br><?php echo $date_my; ?>
                                </p><hr>
                            </center>
                            <center>
                                <h3>
                                    <?php
                                    $command = Yii::$app->db->createCommand("select count(refer_no) as refer_total from referout where refer_date BETWEEN '" . $date_m . "-01' and '" . $date_m . "-31'");
                                    $target = $command->queryScalar();

                                    echo $target;
                                    ?>
                                    ราย
                                </h3>
                            </center>
                        </div>
                        <center>
                            <a href="#" class="small-box-footer">
                                รายละเอียดเพิ่มเติม <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </center>
                    </div>
                </div><!-- ./col -->

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="alert alert-info" role="alert">
                        <div class="inner">
                            <center>
                                <p class="text-info">
                                    ข้อมูลการส่งกลับ ประจำเดือน </br><?php echo $date_my; ?>
                                </p><hr>
                            </center>
                            <h3>
                                <center>
                                    <?php
                                    $command = Yii::$app->db->createCommand("SELECT count(refer_no) as referback_total FROM referback WHERE refer_date BETWEEN '" . $date_m . "-01' and '" . $date_m . "-31'");
                                    $target = $command->queryScalar();

                                    echo $target;
                                    ?>
                                    ราย
                            </h3>
                            </center>
                        </div>
                        <center>
                            <a href="#" class="small-box-footer">
                                รายละเอียดเพิ่มเติม <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </center>
                    </div>
                </div><!-- ./col -->

                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="alert alert-warning" role="alert">
                        <div class="inner">
                            <center>
                                <p class="text-warning">
                                    ข้อมูลการรับส่งต่อ ประจำเดือน </br><?php echo $date_my; ?>
                                </p><hr>
                            </center>
                            <center>
                                <h3>
                                    <?php
                                    $command = Yii::$app->db->createCommand("SELECT count(referback_no) as referback_reply FROM referback_reply WHERE referback_date BETWEEN '" . $date_m . "-01' and '" . $date_m . "-31'");
                                    $target = $command->queryScalar();

                                    echo $target;
                                    ?>
                                    ราย
                                </h3>
                            </center>
                        </div>
                        <center>
                            <a href="#" class="small-box-footer">
                                รายละเอียดเพิ่มเติม <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </center>
                    </div>
                </div><!-- ./col -->
            </div><!-- ./div row -->
            
            <!-- chart -->
            <div class="row">
                <div class="panel-body">
                    <div style="display: none">
                        <?php
                        echo Highcharts::widget([
                            'scripts' => [
                                'highcharts-more', // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                                //'modules/exporting', // adds Exporting button/menu to chart
                                //'themes/grid', // applies global 'grid' theme to all charts
                                //'highcharts-3d',
                                'modules/drilldown'
                            ]
                        ]);
                        ?>
                    </div>
                    <div id="chart1"></div>

                    <?php
                    $sql = "SELECT icd10,count(icd10) as total from referout_diag GROUP BY icd10 ORDER BY total DESC limit 10";

                    $rawData = Yii::$app->db->createCommand($sql)->queryAll();
                    $main_data = [];
                    foreach ($rawData as $data) {
                        //echo $data['icd10'];
                        $main_data[] = [
                            'name' => $data['icd10'],
                            'y' => $data['total'] * 1,
                                //'drilldown' => $data['hospcode']
                        ];
                    }
                    $main = json_encode($main_data);
                    ?>


                    <?php
                    $this->registerJs("$(function () {
                        $('#chart1').highcharts({
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: '10 อันดับส่งต่อ REFER'
                            },
                            xAxis: {
                                type: 'category'
                            },
                            yAxis: {
                                title: {
                                    text: '<b>คน</b>'
                                },
                            },
                            legend: {
                                enabled: true
                            },
                            plotOptions: {
                                series: {
                                    borderWidth: 0,
                                    dataLabels: {
                                        enabled: true
                                    }
                                }
                            },
                            series: [
                            {
                                name: 'โรงพยาบาลเชียงคาน',
                                colorByPoint: true,
                                data:$main
                            }
                            ],
                        });
                    });", yii\web\View::POS_END
                    );
                    ?>   

                </div>

            </div>


            <!-- GridView -->
            <center>
                <div class="grid">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 class="panel-title">ทะเบียนส่งต่อผู้ป่วย รพ.เชียงคาน ล่าสุด</h1>
                        </div>
                        <div class="panel-body">
                            <?php
                            echo GridView::widget([
                                'dataProvider' => $dataProvider,
                                'panel' => [
                                    'before' => '',
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </center>



            


        </section>
    </div>
</div>
