<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Result; // Adjust the namespace and model names
use app\models\Hadits; // to match your Yii application.
use app\models\Similarity; // Create models for other dependencies if needed.

class RecallPrecisionController extends Controller
{
    
    private $TP_cos;
    private $FP_cos;
    private $FN_cos;
    private $recall_cos;
    private $precision_cos;
    private $TP_jac;
    private $FP_jac;
    private $FN_jac;
    private $recall_jac;
    private $precision_jac;
    private $totalRelevanCos;
    private $totalRelevanJac;
    private $cosArr;
    private $jacArr;
    private $rank_cosine = [];
    private $rank_jaccard = [];
    private $total_cos;
    private $total_jac;
    public $time_cos;
    public $time_jac;
    private $similarity;
    public $results;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    
        $this->similarity = new MainController($id, $module, $config);
        $this->results = new Result();
    }

    // public function init()
    // {
    //     $this->similarity = new MainController();
    //     $this->result = new Result;
    // }
    

    public function actionResultCosine($keyword, $total, $time, $rank)
    {
        $this->time_cos = $time;
        $this->total_cos = $total;
        $keywords = $keyword;
        $this->rank_cosine = $rank;
        $this->total_cos = count($this->rank_cosine);

        if ($keywords === "idul" || $keywords === "fitri" || $keywords === "idul fitri") {
            $this->tpCosine("idul fitri");
            $this->totalRelevanCosine("idul fitri");
        } elseif ($keywords === "jual" || $keywords === "beli" || $keywords === "jual beli") {
            $this->tpCosine("jual beli");
            $this->totalRelevanCosine("jual beli");
        } elseif ($keywords === "fitnah") {
            $this->tpCosine("fitnah");
            $this->totalRelevanCosine("fitnah");
        } elseif ($keywords === "peperangan") {
            $this->tpCosine("peperangan");
            $this->totalRelevanCosine("peperangan");
        } else {
            $this->TP_cos = 0;
        }

        $this->fnCosine();
        $this->fpCosine();
        $this->RecallCosine();
        $this->PrecisionCosine();
    }

    public function actionResultJaccard($keyword, $total, $time, $rank)
    {
        $this->time_jac = $time;
        $this->total_jac = $total;
        $keywords = $keyword;
        $this->rank_jaccard = $rank;
        $this->total_jac = count($this->rank_jaccard);

        if ($keywords === "idul" || $keywords === "fitri" || $keywords === "idul fitri") {
            $this->tpJaccard("idul fitri");
            $this->totalRelevanJaccard("idul fitri");
        } elseif ($keywords === "jual" || $keywords === "beli" || $keywords === "jual beli") {
            $this->tpJaccard("jual beli");
            $this->totalRelevanJaccard("jual beli");
        } elseif ($keywords === "fitnah") {
            $this->tpJaccard("fitnah");
            $this->totalRelevanJaccard("fitnah");
        } elseif ($keywords === "peperangan") {
            $this->tpJaccard("peperangan");
            $this->totalRelevanJaccard("peperangan");
        } else {
            $this->TP_jac = 0;
        }

        $this->fnJaccard();
        $this->fpJaccard();
        $this->RecallJaccard();
        $this->PrecisionJaccard();
    }

    private function tpCosine($index)
    {
        $this->TP_cos = $this->similarity->hadits->where(['index' => $index])->andWhere(['id' => $this->rank_cosine])->count();
    }

    private function tpJaccard($index)
    {
        $this->TP_jac = $this->similarity->hadits->where(['index' => $index])->andWhere(['id' => $this->rank_jaccard])->count();
    }

    private function totalRelevanCosine($index)
    {
        $this->totalRelevanCos = $this->similarity->hadits->where(['index' => $index])->count();
    }

    private function totalRelevanJaccard($index)
    {
        $this->totalRelevanJac = $this->similarity->hadits->where(['index' => $index])->count();
    }

    private function fnCosine()
    {
        $this->FN_cos = $this->totalRelevanCos - $this->TP_cos;
    }

    private function fnJaccard()
    {
        $this->FN_jac = $this->totalRelevanJac - $this->TP_jac;
    }

    private function fpCosine()
    {
        $this->FP_cos = $this->total_cos - $this->TP_cos;
    }

    private function fpJaccard()
    {
        $this->FP_jac = $this->total_jac - $this->TP_jac;
    }

    private function RecallCosine()
    {
        if ($this->TP_cos != 0) {
            $this->recall_cos = ($this->TP_cos / ($this->TP_cos + $this->FN_cos)) * 100;
        } else {
            $this->recall_cos = 0;
        }
    }

    private function RecallJaccard()
    {
        if ($this->TP_jac != 0) {
            $this->recall_jac = ($this->TP_jac / ($this->TP_jac + $this->FN_jac)) * 100;
        } else {
            $this->recall_jac = 0;
        }
    }

    private function PrecisionCosine()
    {
        if ($this->TP_cos != 0) {
            $this->precision_cos = ($this->TP_cos / ($this->TP_cos + $this->FP_cos)) * 100;
        } else {
            $this->precision_cos = 0;
        }
    }

    private function PrecisionJaccard()
    {
        if ($this->TP_jac != 0) {
            $this->precision_jac = ($this->TP_jac / ($this->TP_jac + $this->FP_jac)) * 100;
        } else {
            $this->precision_jac = 0;
        }
    }

    public function input($keyword)
    {
        $results = $this->result->find()->where(['keyword' => $keyword])->all();

        if (!count($results)) {
            $this->result->keyword = $keyword;
            $this->result->tp_cosine = $this->TP_cos;
            $this->result->tp_jaccard = $this->TP_jac;
            $this->result->fp_cosine = $this->FP_cos;
            $this->result->fp_jaccard = $this->FP_jac;
            $this->result->fn_cosine = $this->FN_cos;
            $this->result->fn_jaccard = $this->FN_jac;
            $this->result->recall_cosine = $this->recall_cos;
            $this->result->recall_jaccard = $this->recall_jac;
            $this->result->precision_cosine = $this->precision_cos;
            $this->result->precision_jaccard = $this->precision_jac;
            $this->result->total_cosine = $this->total_cos;
            $this->result->total_jaccard = $this->total_jac;
            $this->result->time_cosine = $this->time_cos;
            $this->result->time_jaccard = $this->time_jac;
            $this->result->save();
        }
    }
}
