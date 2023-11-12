<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Jaccard extends ActiveRecord
{
    public static function tableName()
    {
        return 'jaccard';
    }

    public function rules()
    {
        return [
            [['keyword', 'jaccard_similarity', 'id_document'], 'required'],
            [['keyword'], 'string', 'max' => 255],
            [['jaccard_similarity'], 'number'],
            [['id_document'], 'integer'],
        ];
    }

    // You can define other model behaviors, relations, and methods here.
}
