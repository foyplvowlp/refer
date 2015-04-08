<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hospcode".
 *
 * @property string $hospcode
 * @property string $hospname
 * @property string $hosptype
 * @property string $tmbpart
 * @property string $amppart
 * @property string $chwpart
 * @property string $hospdesc
 */
class Hospcode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hospcode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hospcode', 'hospname', 'hosptype', 'tmbpart', 'amppart', 'chwpart'], 'required'],
            [['hospcode'], 'string', 'max' => 5],
            [['hospname', 'hospdesc'], 'string', 'max' => 100],
            [['hosptype'], 'string', 'max' => 50],
            [['tmbpart', 'amppart', 'chwpart'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hospcode' => 'Hospcode',
            'hospname' => 'Hospname',
            'hosptype' => 'Hosptype',
            'tmbpart' => 'Tmbpart',
            'amppart' => 'Amppart',
            'chwpart' => 'Chwpart',
            'hospdesc' => 'Hospdesc',
        ];
    }
}
