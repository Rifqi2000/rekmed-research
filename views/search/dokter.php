<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title                   = 'Data Dokter';
$this->params['breadcrumbs'][] = $this->title;
?>

<h3>Data Dokter</h3>

<table>
    <tr>
        <th>Dokter User ID</th>
        <th>Nama Dokter</th>
        <!-- Add other columns as needed -->
    </tr>

    <?php foreach ($dokterData as $dokter): ?>
        <tr>
            <td><?= $dokter->user_id ?></td>
            <td><?= $dokter->nama ?></td>
        </tr>
    <?php endforeach; ?>
</table>