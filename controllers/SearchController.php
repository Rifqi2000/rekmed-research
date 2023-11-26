<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Pasien;
use app\models\Dokter;
use app\models\RekamMedis;

class SearchController extends Controller
{
    public function actionIndex()
    {
        $searchKeyword = Yii::$app->request->get('q', '');
    
        // Prepare the URL of your Flask endpoint
        $flaskEndpoint = 'http://127.0.0.1:5000';
    
        // For both GET and POST requests, encode the 'q' parameter
        $postData = json_encode(['q' => $searchKeyword]);
    
        // Set up cURL for POST request
        $ch = curl_init($flaskEndpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Execute cURL and get the response
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        // Close cURL session
        curl_close($ch);
    
        if ($statusCode == 200) {
            // Access data from Flask
            $responseData = json_decode($response, true);    
            // Sort the array based on 'cosine' in descending order
            uasort($responseData, function ($a, $b) {
            return $b['cosine'] <=> $a['cosine'];
            });
    
            return $this->render('index', ['searchKeyword' => $searchKeyword, 'responseData' => $responseData]);
        } else {
            return "Hidupkan flask";
        }
    }

    public function actionPasien($mr)
    {
        // Assuming Pasien is the ActiveRecord model for the pasien table
        $pasienData = Pasien::find()
        ->where(['mr' => $mr])
        ->joinWith(['klinik'])
        ->one();
        // $rekamMedis = RekamMedis::find()->where(['mr' => $mr])->one();
        $rekamMedis = RekamMedis::find()
        ->where(['mr' => $mr])
        ->joinWith(['rmObats', 'rmDiagnoses', 'rmTindakans'])
        ->one();

        return $this->render('pasien', ['pasienData' => $pasienData, 'rekamMedis' => $rekamMedis]);
    }

    public function actionDokter($user_id)
    {
        // Assuming Dokter is the ActiveRecord model for the dokter table
        $dokterData = Dokter::find()->where(['user_id' => $user_id])->all();
        $dokterOther = Dokter::find()
        ->where(['user_id' => $user_id])
        ->joinWith(['spesialisasi', 'kota'])
        ->one();

        return $this->render('dokter', ['dokterData' => $dokterData, 'dokterOther' => $dokterOther]);
    }
}
