<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Result extends ActiveRecord
{
    public static function tableName()
    {
        return 'result';
    }

    public function rules()
    {
        return [
            [['keyword', 'to_cosine', 'tp_jaccard', 'fp_cosine', 'fp_jaccard', 'fn_cosine', 'fn_jaccard', 'recall_cosine', 'recall_jaccard', 'precision_cosine', 'precision_jaccard', 'total_cosine', 'total_jaccard'], 'required'],
            [['keyword'], 'string', 'max' => 255],
            [['to_cosine', 'tp_jaccard', 'fp_cosine', 'fp_jaccard', 'fn_cosine', 'fn_jaccard', 'recall_cosine', 'recall_jaccard', 'precision_cosine', 'precision_jaccard', 'total_cosine', 'total_jaccard'], 'integer'],
        ];
    }

    // You can define other model behaviors, relations, and methods here.
}
