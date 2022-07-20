<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<?php Pjax::begin(); ?>
<?= $this->render('@app/views/message/alert') ?>
<div class="row mt-sm-4">
    <div class="col-12 col-md-12 col-lg-5">
        <div class="card profile-widget">
            <div class="profile-widget-header">
                <img alt="image" src="<?= $model->image ?? Yii::$app->homeUrl . "theme/stisla/assets/img/avatar/avatar-1.png" ?>" class="rounded-circle profile-widget-picture" style="width:100px; height:100px">
                <div class="profile-widget-items">
                    <div class="profile-widget-item">
                        <div class="profile-widget-item-label">
                            <span><i class="fas fa-at"></i> Username: <?= $model->username ?? "-" ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-widget-description">
                <div class="profile-widget-name"> <?= $model->full_name ?? "-" ?> <div class="text-muted d-inline font-weight-normal">
                        <div class="slash"></div> <?= ucfirst($model->role->value ?? "-") ?>
                    </div> <i class="fas fa-check-circle"></i></div>
                <?= $model->user_bio ?? "Belum ada bio" ?>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-7">
        <div class="card">
            <div class="needs-validation">
                <div class="card-header">
                    <h4>Your Data</h4>
                </div>
                <div class="card-body" style="margin-top:20px">
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12" style="margin-top:-30px">
                            <label><i class="fas fa-envelope-open"></i> &nbsp;Email</label>
                            <p><?= $model->email ?? "-" ?></p>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12" style="margin-top:-30px">
                            <label><i class="fas fa-phone"></i> &nbsp;Phone</label>
                            <p><?= $model->phone ?? "-" ?></p>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12" style="margin-top:-30px">
                            <label><i class="fas fa-check"></i> &nbsp;Status</label>
                            <p><?= $model->status == 10 ? "Active" : ($model->status == 9 ? "Unvalidate" : ($model->status == 0 ? "Banned" : "Deleted")) ?>
                            </p>
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12" style="margin-top:-30px">
                            <label><i class="fas fa-calendar-alt"></i> &nbsp;Registered At</label>
                            <p><?= date("d/m/Y h:m:s", $model->created_at) ?></p>
                        </div>
                        <div class="form-group col-12" style="margin-top:-30px">
                            <label><i class="fas fa-map-marker-alt"></i> &nbsp;Address</label>
                            <p><?= $model->address ?? "-" ?></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right" style="margin-top:-40px">
                    <?= Html::a('<i class="fa fa-key"></i> Password', Url::to(Yii::$app->homeUrl . 'administrator/profiles/change-password'), ['data-pjax' => 1, 'class' => 'btn btn-sm btn-primary m-1']); ?>
                    <?= Html::a('<i class="fa fa-camera"></i> Photo Profile', Url::to(Yii::$app->homeUrl . 'administrator/profiles/upload-photo'), ['data-pjax' => 1, 'class' => 'btn btn-sm btn-warning m-1']); ?>
                    <?= Html::a('<i class="fa fa-edit"></i> Ubah Data', Url::to(Yii::$app->homeUrl . 'administrator/profiles/update'), ['data-pjax' => 1, 'class' => 'btn btn-sm btn-success m-1']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>