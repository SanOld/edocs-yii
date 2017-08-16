<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;


NavBar::begin([
    'brandLabel' => 'EDOCS',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => ['class' => 'navbar-inverse navbar-fixed-top'],
    'innerContainerOptions' => ['class' => 'contaner-fluid'],
    
]);
$menuItems = [
    ['label' => 'Пробная', 'url' => ['/site/example']],
    ['label' => 'Главная', 'url' => ['/site/index']],
    ['label' => 'Справка', 'url' => ['/site/about']],
    ['label' => 'Контакты', 'url' => ['/site/contact']],
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
    $menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
} else {
    $menuItems[] = [
        'label' => 'Выход (' . Yii::$app->user->identity->username . ')',
        'url' => ['/site/logout'],
//        'template' => '<a href="{url}" data-method="post">{label}</a>',
        'linkOptions' => ['data-method' => 'post']
    ];
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right '],
    'items' => $menuItems,
]);
NavBar::end();



