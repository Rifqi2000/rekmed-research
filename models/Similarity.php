<?php
namespace app\models;

use yii\db\ActiveRecord;

class Similarity extends ActiveRecord
{
    public static function tableName()
    {
        return 'similarity';
    }

    public function rules()
    {
        return [
            [['keyword', 'cosine_similarity', 'id_document'], 'safe'],
        ];
    }
}
