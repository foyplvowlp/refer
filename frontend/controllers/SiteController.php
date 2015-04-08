<?php

namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {
        $date_m = date("Y-m");
        //$date_m = date("2015-01");
        $date_d = date("Y-m-d");
        //$date_d = date("2015-01-31");
        //Query spclty ID
        $sql_spclty_sum = "select t1.*,t2.*,t3.OPD_total,t4.ER_total,t5.LR_total,t6.NICU_total,t7.PCU_total,t8.spclty_total from (select hospcode,hospname from hospcode) t1 ";
        $sql_spclty_sum .= "inner join ";
        $sql_spclty_sum .= "(select hcode from referout_reply where referout_date between '" . $date_m . "-01' and '" . $date_m . "-31' group by hcode ) t2 on t2.hcode = t1.hospcode ";
        $sql_spclty_sum .= "left outer join ";
        $sql_spclty_sum .= "(select hcode,count(referout_no) as OPD_total from referout_reply where receive_spclty_id = '01'  and referout_date between '" . $date_m . "-01' and '" . $date_m . "-31' group by hcode ) t3 on t3.hcode = t2.hcode ";
        $sql_spclty_sum .= "left outer join ";
        $sql_spclty_sum .= "(select hcode,count(referout_no) as ER_total from referout_reply where receive_spclty_id = '02'  and referout_date between '" . $date_m . "-01' and '" . $date_m . "-31' group by hcode ) t4 on t4.hcode = t2.hcode ";
        $sql_spclty_sum .= "left outer join ";
        $sql_spclty_sum .= "(select hcode,count(referout_no) as LR_total from referout_reply where receive_spclty_id = '03'  and referout_date between '" . $date_m . "-01' and '" . $date_m . "-31' group by hcode ) t5 on t5.hcode = t2.hcode ";
        $sql_spclty_sum .= "left outer join ";
        $sql_spclty_sum .= "(select hcode,count(referout_no) as NICU_total from referout_reply where receive_spclty_id = '04'  and referout_date between '" . $date_m . "-01' and '" . $date_m . "-31' group by hcode ) t6 on t6.hcode = t2.hcode ";
        $sql_spclty_sum .= "left outer join ";
        $sql_spclty_sum .= "(select hcode,count(referout_no) as PCU_total from referout_reply where receive_spclty_id = '05'  and referout_date between '" . $date_m . "-01' and '" . $date_m . "-31' group by hcode ) t7 on t7.hcode = t2.hcode ";
        $sql_spclty_sum .= "left outer join ";
        $sql_spclty_sum .= "(select hcode,count(referout_no) as spclty_total from referout_reply where receive_spclty_id is not null and referout_date between '" . $date_m . "-01' and '" . $date_m . "-31' group by hcode ) t8 on t8.hcode = t1.hospcode";

        $rawdata_spclty_sum = \Yii::$app->db->createCommand($sql_spclty_sum)->queryAll();

        //echo $sql_spclty_sum;
        //Query Station ID
        $sql_station_sum = "select t1.*,t2.*,t3.OPD_total,t4.ER_total,t5.WARD_total,t6.LR_total,t7.PCU_total,t8.station_total from (select hospcode,hospname from hospcode) t1 ";
        $sql_station_sum .= "inner join ";
        $sql_station_sum .= "(select hcode from referout_reply where referout_date between '" . $date_m . "-01' and '" . $date_m . "-31' group by hcode ) t2 on t2.hcode = t1.hospcode ";
        $sql_station_sum .= "left outer join ";
        $sql_station_sum .= "(select hcode,count(referout_no) as OPD_total from referout_reply where station_id = '1' and referout_date between '" . $date_m . "-01' and '" . $date_m . "-31' group by hcode ) t3 on t3.hcode = t2.hcode ";
        $sql_station_sum .= "left outer join ";
        $sql_station_sum .= "(select hcode,count(referout_no) as ER_total from referout_reply where station_id = '2'  and referout_date between '" . $date_m . "-01' and '" . $date_m . "-31' group by hcode ) t4 on t4.hcode = t2.hcode ";
        $sql_station_sum .= "left outer join ";
        $sql_station_sum .= "(select hcode,count(referout_no) as WARD_total from referout_reply where station_id = '3' and referout_date between '" . $date_m . "-01' and '" . $date_m . "-31' group by hcode ) t5 on t5.hcode = t2.hcode ";
        $sql_station_sum .= "left outer join ";
        $sql_station_sum .= "(select hcode,count(referout_no) as LR_total from referout_reply where station_id = '4' and referout_date between '" . $date_m . "-01' and '" . $date_m . "-31' group by hcode ) t6 on t6.hcode = t2.hcode ";
        $sql_station_sum .= "left outer join ";
        $sql_station_sum .= "(select hcode,count(referout_no) as PCU_total from referout_reply where station_id = '5' and referout_date between '" . $date_m . "-01' and '" . $date_m . "-31' group by hcode ) t7 on t7.hcode = t2.hcode ";
        $sql_station_sum .= "left outer join ";
        $sql_station_sum .= "(select hcode,count(referout_no) as station_total from referout_reply where referout_date between '" . $date_m . "-01' and '" . $date_m . "-31' group by hcode ) t8 on t8.hcode = t1.hospcode";
        $rawdata_station_sum = \Yii::$app->db->createCommand($sql_station_sum)->queryAll();

        // Query Refer HOSxP + Thairefer
        $sql = "
select b1.*,b2.*,b3.hosxp_total,b4.thairefer_total 
from (select hospcode,hospname from hospcode) b1 
inner join 
(select hcode from referout_reply where referout_date between '$date_m-01' and '$date_d' group by hcode ) b2 on b2.hcode = b1.hospcode
left outer join 
(select refer_hospcode,count(vn) as hosxp_total from referin where date_in between '$date_m-01' and '$date_d' group by refer_hospcode) b3 on b3.refer_hospcode = b2.hcode
left outer join 
(select hcode,count(referout_no) as thairefer_total from referout_reply where receive_spclty_id is not null and referout_date between '$date_m-01' and '$date_d' group by hcode ) b4 on b4.hcode = b1.hospcode
";
        $refer_hos_thairefer = \Yii::$app->db->createCommand($sql)->queryAll();

        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',
            'allModels' => $rawdata_spclty_sum,
            'allModels' => $rawdata_station_sum,
            'allModels' => $refer_hos_thairefer,
            'pagination' => FALSE,
        ]);

        $sql = "SELECT refer_no AS 'เลข Refer',refer_date AS 'เวลาที่ Refer',station_name AS 'แผนก',"
                . "HN, concat(pname,'',fname,' ',lname) AS 'ชื่อ สกุล',"
                . "memoDiag AS 'โรค',doctor_name AS 'แพทย์' FROM referout WHERE refer_date BETWEEN '2015-01-01' AND '2015-12-31' ORDER BY refer_date DESC limit 5";

        $rawData = Yii::$app->db->createCommand($sql)->queryAll();
        $dataProvider = new \yii\data\ArrayDataProvider([
            'allModels' => $rawData,
            'pagination' => [
                'pagesize' => 5,
            ]
        ]);


        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'sql' => $sql
        ]);
        //return $this->render('index');
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    public function actionAbout() {
        return $this->render('about');
    }

    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

}
