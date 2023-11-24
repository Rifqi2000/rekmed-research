<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\SearchForm;

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
            // Handle the response from Flask as needed
            $responseData = json_decode($response, true);
    
            // Access data from Flask
            // $searchKeywordFromYii = $responseData['status'];
            // $dokterData = $responseData['dokter'];
            // Sort the array based on 'cosine' in descending order
            uasort($responseData, function ($a, $b) {
            return $b['cosine'] <=> $a['cosine'];
            });
    
            return $this->render('index', ['searchKeyword' => $searchKeyword, 'responseData' => $responseData]);
        } else {
            return "Hidupkan flask";
        }
    }
    
    
    

    public function actionResult()
    {
        
        $request = Yii::$app->request;
        // var_dump($request->get('q'));
        $searchKeyword = $request->get('q');
        

        if ($searchKeyword !== null) {
            $this->keyword = $searchKeyword;
            $this->jaccard();
            $this->cosine();

            $cos = $this->cos;
            $jac = $this->jac;
            $totalCos = $this->total_cos;
            $totalJac = $this->total_jac;
            $timeCosine = $this->time_cosine;
            $timeJaccard = $this->time_jaccard;
            $keywords = $this->similarity->preprocessingQuery($searchKeyword);

            $this->results->input($searchKeyword);

            return $this->render('result', [
                'cos' => $cos,
                'jac' => $jac,
                'total_cos' => $totalCos,
                'total_jac' => $totalJac,
                'time_cosine' => $timeCosine,
                'time_jaccard' => $timeJaccard,
                'keywords' => $keywords,
            ]);
        } else {
            return 'Masukan Keyword';
        }
    }
}
