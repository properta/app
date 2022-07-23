<nav class="navbar navbar-expand-lg main-navbar" style="z-index:unset">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>
        <div class="form-group col-6">
            <select class="form-control select2 get-projects">
                <?php if ($project = Yii::$app->helper->activeProject(true)) : ?>
                <option selected value="<?= $project->id; ?>">
                    <?= $project->title; ?>
                </option>
                <?php else : ?>
                <option>--Choose Projects--</option>
                <?php endif; ?>
            </select>
        </div>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image"
                    src="<?= Yii::$app->user->identity->image ?? Yii::$app->homeUrl . "theme/stisla/assets/img/avatar/avatar-1.png" ?>"
                    class="rounded-circle profile-widget-picture mt-n3" style="width:32px; height:32px">
                <div class="d-sm-none d-lg-inline-block">Hi,
                    <?= Yii::$app->user->identity->full_name ?? "Annonym" ?></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="<?= \yii\helpers\Url::to('administrator/profiles/me', true) ?>" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <!--                            </a>-->
                <div class="dropdown-divider"></div>
                <a href="<?= \yii\helpers\Url::to('site/logout', true) ?>" data-method="post"
                    class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>