<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title                   = 'Search Result';
$this->params['breadcrumbs'][] = $this->title;
?>

<h3>Hasil pencarian untuk: <?= $searchKeyword ?></h3>
<div class="site-about">


    <p>
        This is the Search page. You may modify the following file to customize its content
    </p>

    <table>
        <tr>
            <th>RM ID</th>
            <th>Nama Pasien</th>
            <th>Diagnosis Nama</th>
            <th>Nama Dokter</th>
            <th>Cosine</th>
        </tr>

        <?php foreach ($responseData as $rmId => $data): ?>
            <tr>
                <td><?= $data['rm_id'] ?></td>
                <td><?= $data['pasien_nama'] ?></td>
                <td><?= $data['diagnosis_nama'] ?></td>
                <td><?= $data['dokter_nama'] ?></td>
                <td><?= $data['cosine'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <code><?= __FILE__ ?></code>
</div>
                                
                            

