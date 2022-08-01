<?php

use yii\helpers\Html;
?>

<ul class="sidebar-menu">
    <li class="menu-header">
        <Menu></Menu>
    </li>

    <li class="nav-item active">
        <a href="/administrator/dashboard" class="nav-link"><i
                class="fas fa-home"></i><span><?= Yii::t('app', 'Dashboard') ?></span></a>
    </li>

    <li class="menu-header">MAIN</li>
    <li class="nav-item">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-file"></i><span><?= Yii::t('app', 'Projects') ?>
                [done]</span></a>
        <ul class="dropdown-menu">
            <li>
                <a class="nav-link"
                    href=<?= Yii::getAlias('@web/administrator/projects/create') ?>><?= Yii::t('app', 'Add New') ?>
                    [done]</a>
            </li>
            <li>
                <a class="nav-link"
                    href=<?= Yii::getAlias('@web/administrator/projects/index') ?>><?= Yii::t('app', 'List of Projects') ?>
                    [done]</a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-file"></i><span><?= Yii::t('app', 'Users') ?>
                [done]</span></a>
        <ul class="dropdown-menu">
            <li>
                <a class="nav-link"
                    href=<?= Yii::getAlias('@web/administrator/users/create') ?>><?= Yii::t('app', 'Add New') ?>
                    [done]</a>
            </li>
            <li>
                <a class="nav-link"
                    href=<?= Yii::getAlias('@web/administrator/users/index') ?>><?= Yii::t('app', 'List of Users') ?>
                    [done]</a>
            </li>
        </ul>
    </li>
    <li class="menu-header"><?= Yii::t('app', 'Data Masters') ?></li>
    <li class="nav-item">
        <a href="#" class="nav-link has-dropdown"><i
                class="fas fa-file"></i><span><?= Yii::t('app', 'Generals') ?></span></a>
        <ul class="dropdown-menu">
            <li>
                <a class="nav-link"
                    href=<?= Yii::getAlias('@web/administrator/currencies') ?>><?= Yii::t('app', 'Currencies') ?>
                    [done]
                    *imr</a>
            </li>
            <li>
                <a class="nav-link"
                    href=<?= Yii::getAlias('@web/administrator/materials') ?>><?= Yii::t('app', 'Materials') ?>
                    [done] *eko</a>
            </li>
            <li>
                <a class="nav-link"
                    href=<?= Yii::getAlias('@web/administrator/occupations') ?>><?= Yii::t('app', 'Occupations') ?>
                    [done] *eko</a>
            </li>
            <li>
                <a class="nav-link"
                    href=<?= Yii::getAlias('@web/administrator/proficiencies') ?>><?= Yii::t('app', 'Proficiencies') ?>
                    [done] *eko</a>
            </li>
            <li>
                <a class="nav-link"
                    href=<?= Yii::getAlias('@web/administrator/unit-codes') ?>><?= Yii::t('app', 'Unit Codes') ?>
                    [done] *eko</a>
            </li>
            <li>
                <a class="nav-link"
                    href=<?= Yii::getAlias('@web/administrator/wind-directions/index') ?>><?= Yii::t('app', 'Wind Directions') ?>
                    [done] *eko</a>
            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a href="#" class="nav-link has-dropdown"><i
                class="fas fa-file"></i><span><?= Yii::t('app', 'Civils') ?></span></a>
        <ul class="dropdown-menu">
            <li>
                <a class="nav-link" href=<?= Yii::getAlias('@web/administrator/building-types/index') ?>>Building
                    Type</a>
            </li>
            <li>
                <?= Html::a(Yii::t('app', 'Wupa Categories'), Yii::getAlias('@web/administrator/wupa-categories/index'), ['class' => 'nav-link']) ?>
            </li>
            <li>
                <?= Html::a(Yii::t('app', 'Wupa Items'), Yii::getAlias('@web/administrator/wupa-items/index'), ['class' => 'nav-link']) ?>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-file"></i><span>RAB</span></a>
        <ul class="dropdown-menu">
            <li>
                <a class="nav-link" href=<?= Yii::getAlias('@web/administrator/articles/create') ?>>A</a>
            </li>
            <li>
                <a class="nav-link" href=<?= Yii::getAlias('@web/administrator/articles/index') ?>>B</a>
            </li>
        </ul>
    </li>
    <li class="menu-header">General</li>
    <li class="nav-item dropdown">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cogs"></i>
            <span>Setting</span></a>
        <ul class="dropdown-menu">
            <li><a class="nav-link" href="/administrator/masters/index?type=inspection-methods">General Setting</a>
            </li>
            <li><a class="nav-link"
                    href=<?= Yii::getAlias('@web/administrator/contractors/index') ?>><?= Yii::t('app', 'Contractor') ?>
                    [done] *imr</a>
            </li>
        </ul>
    </li>
    <li class="menu-header">Logs</li>
    <li class="nav-item">
        <a href="#" class="nav-link"><i class="fas fa-file"></i><span>User Activity</span></a>
    </li>
</ul>