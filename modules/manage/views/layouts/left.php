<aside class="main-sidebar">

    <section class="sidebar">

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
//                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => Yii::t('app', 'Предметы'), 'icon' => 'archive', 'url' => ['items/index']],
                    ['label' => Yii::t('app', 'Настройки'), 'icon' => 'cog', 'url' => ['settings/index']],
                    [
                        'label' => 'Some tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
