<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title                   = 'Data Pasien';
$this->params['breadcrumbs'][] = $this->title;
?>

<h3>Data Pasien</h3>

<table>
    <tr>
        <th>Pasien MR</th>
        <th>Nama Pasien</th>
        <!-- Add other columns as needed -->
    </tr>

    <?php if ($pasienData !== null): ?>
        <tr>
            <td><?= $pasienData->mr ?></td>
            <td><?= $pasienData->nama ?></td>
            <!-- Add other columns as needed -->
        </tr>
    <?php else: ?>
        <tr>
            <td colspan="2">No data found</td>
        </tr>
    <?php endif; ?>
</table>