<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Hadits extends ActiveRecord
{
    public static function tableName()
    {
        return 'hadits';
    }

    public function rules()
    {
        return [
            [['nama_hadits', 'index', 'hadits_translate'], 'required'],
            [['nama_hadits', 'index', 'hadits_translate'], 'string', 'max' => 255],
        ];
    }

    // You can define other model behaviors, relations, and methods here.
}
