<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title                   = 'Data Dokter';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php foreach ($dokterData as $index => $dokter): ?>
<div class="profile-container">
    <h3>Profil Dokter</h3>

    <?php if ($dokterData !== null): ?>
        <div class="profile-details">

            <div class="profile-item">
                <div class="profile-label">Nama Dokter</div>
                <div class="profile-value"><?= $dokter->nama ?></div>
            </div>

            <div class="profile-item">
                <div class="profile-label">Tanggal Lahir</div>
                <div class="profile-value"><?= $dokter->tanggal_lahir ?></div>
            </div>
            
            <div class="profile-item">
                <div class="profile-label">Jenis Kelamin</div>
                <div class="profile-value"><?= $dokter->jenis_kelamin ?></div>
            </div>

            <div class="profile-item">
                <div class="profile-label">Waktu Praktik</div>
                <div class="profile-value"><?= $dokter->waktu_praktek ?></div>
            </div>

            <div class="profile-item">
                <div class="profile-label">Spesialis</div>
                <?php if ($dokterOther !== null): ?>
                    <div class="profile-value">
                        <?= $dokterOther->spesialisasi->nama ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="profile-item">
                <div class="profile-label">Alamat</div>
                <?php if ($dokterOther !== null): ?>
                    <div class="profile-value">
                    <?= $dokter->alamat ?>, <?= $dokterOther->kota->kokab_nama ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="profile-item">
                <div class="profile-label">No Telepon</div>
                <div class="profile-value"><?= $dokter->no_telp ?></div>
            </div>

            <div class="profile-item">
                <div class="profile-label">Alumni</div>
                <div class="profile-value"><?= $dokter->alumni ?></div>
            </div>

        </div>
    <?php else: ?>
        <p>No data found</p>
    <?php endif; ?>
</div>
<?php endforeach; ?>

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