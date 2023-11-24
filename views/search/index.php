<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title                   = 'Search Result';
$this->params['breadcrumbs'][] = $this->title;
?>

<h3>Hasil pencarian untuk: <?= $searchKeyword ?></h3>
    <table class="table table-hover table-light">
        <thead>
            <th>Nama Pasien</th>
            <th>Diagnosis Nama</th>
            <th>Nama Dokter</th>
            <th>Tanggal Periksa</th>
        </thead>
        <tbody>
            <?php foreach ($responseData as $rmId => $data): ?>
                <tr>
                    <td><?= Html::a($data['pasien_nama'], ['pasien', 'mr' => $data['pasien_mr']]) ?></td>
                    <td><?= $data['diagnosis_nama'] ?></td>
                    <td><?= Html::a($data['dokter_nama'], ['dokter', 'user_id' => $data['dokter_user_id']]) ?></td>
                    <td><?= date('l, j F Y', strtotime($data['tanggal_periksa'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <code><?= __FILE__ ?></code>
</div>
                                
                            

