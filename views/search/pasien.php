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
                <div class="profile-label">Pasien MR</div>
                <div class="profile-value"><?= $pasienData->mr ?></div>
            </div>

            <div class="profile-item">
                <div class="profile-label">Klinik ID</div>
                <div class="profile-value"><?= $pasienData->klinik_id ?></div>
            </div>

            <div class="profile-item">
                <div class="profile-label">Nama Pasien</div>
                <div class="profile-value"><?= $pasienData->nama ?></div>
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
