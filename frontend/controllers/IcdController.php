<?php

namespace frontend\controllers;
use yii;

class IcdController extends \yii\web\Controller
{
   public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function  actionIcd10()
    {
        $date1 = "2014-10-01";
        $date2 = date('Y-m-d');
        if (Yii::$app->request->isPost) {
            $date1 = $_POST['date1'];
            $date2 = $_POST['date2'];
        }
        
        $sql="SELECT rd.icd10, icd10.name AS diag_name, COUNT(*) AS amt 
FROM (referout_reply r INNER JOIN referout_reply_diag rd ON r.referout_no=rd.referout_no)
LEFT OUTER JOIN icd10 ON rd.icd10=icd10.code
WHERE r.receive_no IS NOT NULL
AND (icd10.code <> '' or icd10.code IS NOT NULL)
AND (r.referout_date BETWEEN '$date1' AND '$date2')
GROUP BY rd.icd10, icd10.name
ORDER BY amt DESC
limit 10";
        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);
       
        return $this->render('icd10', [
                   
                    'dataProvider' => $dataProvider,
                    'sql' => $sql,
                    'date1' => $date1,
                    'date2' => $date2
        ]);
    }
    
        public function actionIcdlist() {
        $date1 = "2014-10-01";
        $date2 = date('Y-m-d');
        $hospcode='';
        if (Yii::$app->request->isPost) {
            $date1 = $_POST['date1'];
            $date2 = $_POST['date2'];
            $hospcode=$_POST['hospcode'];
            
            //print_r($hospcode);
        }
        $sql = "SELECT rd.icd10, icd10.name AS diag_name, COUNT(*) AS amt 
FROM (referout_reply r INNER JOIN referout_reply_diag rd ON r.referout_no=rd.referout_no)
LEFT OUTER JOIN icd10 ON rd.icd10=icd10.code
WHERE r.receive_no IS NOT NULL
AND (icd10.code <> '' or icd10.code IS NOT NULL)
AND (r.referout_date BETWEEN '$date1' AND '$date2')
GROUP BY rd.icd10, icd10.name
ORDER BY amt DESC
limit 10";
        
        if($hospcode !=''){
            $sql = "SELECT rd.icd10, icd10.name AS diag_name, COUNT(*) AS amt 
FROM (referout_reply r INNER JOIN referout_reply_diag rd ON r.referout_no=rd.referout_no)
LEFT OUTER JOIN icd10 ON rd.icd10=icd10.code
WHERE r.receive_no IS NOT NULL
AND (icd10.code <> '' or icd10.code IS NOT NULL)
AND (r.referout_date BETWEEN '$date1' AND '$date2')
AND (r.hcode = '$hospcode')
GROUP BY rd.icd10, icd10.name
ORDER BY amt DESC
limit 10";
        }

        try {
            $rawData = \Yii::$app->db->createCommand($sql)->queryAll();
        } catch (\yii\db\Exception $e) {
            throw new \yii\web\ConflictHttpException('sql error');
        }
        $dataProvider = new \yii\data\ArrayDataProvider([
            //'key' => 'hoscode',
            'allModels' => $rawData,
            'pagination' => FALSE,
        ]);
        return $this->render('icdlist', [
                    'dataProvider' => $dataProvider,
                    'sql' => $sql,
                    'date1'=>$date1,
                    'date2'=>$date2,
                    'hospcode'=>$hospcode
        ]);
    }


    
    
}