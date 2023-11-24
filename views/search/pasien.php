<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title                   = 'Data Pasien';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="profile-container">
    <h3>Data Pasien</h3>

    <?php if ($pasienData !== null): ?>
        <div class="profile-details">

            <div class="profile-item">
                <div class="profile-label">Nama Pasien</div>
                <div class="profile-value"><?= $pasienData->nama ?></div>
            </div>

            <div class="profile-item">
                <div class="profile-label">Pasien MR</div>
                <div class="profile-value"><?= $pasienData->mr ?></div>
            </div>

            <div class="profile-item">
                <div class="profile-label">Klinik ID</div>
                <div class="profile-value"><?= $pasienData->klinik_id ?></div>
            </div>

            <div class="profile-item">
                <div class="profile-label">Tanggal Lahir</div>
                <div class="profile-value"><?= $pasienData->tanggal_lahir ?></div>
            </div>
            
            <div class="profile-item">
                <div class="profile-label">Jenis Kelamin</div>
                <div class="profile-value"><?= $pasienData->jk ?></div>
            </div>

            <div class="profile-item">
                <div class="profile-label">Alamat</div>
                <div class="profile-value"><?= $pasienData->alamat ?></div>
            </div>
            
            <div class="profile-item">
                <div class="profile-label">No Telepon</div>
                <div class="profile-value"><?= $pasienData->no_telp ?></div>
            </div>

        </div>
    <?php else: ?>
        <p>No data found</p>
    <?php endif; ?>
</div>

<div class="profile-container">
    <h3>Rekam Medis</h3>

    <?php if ($rekamMedis !== null): ?>
        <div class="profile-details">

            <div class="profile-item">
                <div class="profile-label">Tekanan Darah</div>
                <div class="profile-value"><?= $rekamMedis->tekanan_darah ?></div>
            </div>

            <div class="profile-item">
                <div class="profile-label">Nadi</div>
                <div class="profile-value"><?= $rekamMedis->nadi ?></div>
            </div>

            <div class="profile-item">
                <div class="profile-label">Respirasi Rate</div>
                <div class="profile-value"><?= $rekamMedis->respirasi_rate ?></div>
            </div>

            <div class="profile-item">
                <div class="profile-label">Suhu</div>
                <div class="profile-value"><?= $rekamMedis->suhu ?></div>
            </div>
            
            <div class="profile-item">
                <div class="profile-label">Berat Badan</div>
                <div class="profile-value"><?= $rekamMedis->berat_badan ?></div>
            </div>

            <div class="profile-item">
                <div class="profile-label">Tinggi Badan</div>
                <div class="profile-value"><?= $rekamMedis->tinggi_badan ?></div>
            </div>
            
            <div class="profile-item">
                <div class="profile-label">BMI</div>
                <div class="profile-value"><?= $rekamMedis->bmi ?></div>
            </div>
            <div class="profile-item">
                <div class="profile-label">Keluhan Utama</div>
                <div class="profile-value"><?= nl2br($rekamMedis->keluhan_utama) ?></div>
            </div>
            <div class="profile-item">
                <div class="profile-label">Anamnesis</div>
                <div class="profile-value"><?= nl2br($rekamMedis->anamnesis) ?></div>
            </div>
            <div class="profile-item">
                <div class="profile-label">Hasil Penunjang</div>
                <div class="profile-value"><?= nl2br($rekamMedis->hasil_penunjang) ?></div>
            </div>

        </div>
    <?php else: ?>
        <p>No data found</p>
    <?php endif; ?>
</div>

<style>
    .profile-container {
        /* max-width: 600px; */
        margin: auto;
    }

    .profile-details {
        /* background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
        margin-top: 20px;
    }

    .profile-item {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .profile-label {
        font-weight: bold;
        margin-right: 10px;
        width: 150px; /* Adjust the width as needed */
    }

    .profile-value {
        /* Add your styling for the value */
    }
</style>
