<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $avatar;?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= $fullName;?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- /.search form -->
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Навигация', 'options' => ['class' => 'header']],
                    ['label' => 'Главная страница', 'icon' => 'fa fa-cog', 'url' => ['/main-page/update?id=1']],
                    ['label' => 'Создание страниц', 'icon' => 'file-code-o', 'url' => ['/pages']],
                    ['label' => 'Меню', 'icon' => 'dashboard', 'url' => ['/menu']],
                    [
                        'label' => 'Рубрики',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Новости и Акции', 'icon' => 'newspaper-o', 'url' => ['/sale-news'],],
                            ['label' => 'Блог', 'icon' => 'paper-plane', 'url' => ['/blog'],],
//                            [
//                                'label' => 'Level One',
//                                'icon' => 'circle-o',
//                                'url' => '#',
//                                'items' => [
//                                    ['label' => 'Архив акции', 'icon' => 'circle-o', 'url' => '#',],
//                                    [
//                                        'label' => 'Level Two',
//                                        'icon' => 'circle-o',
//                                        'url' => '#',
//                                        'items' => [
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
//                                        ],
//                                    ],
//                                ],
//                            ],
                        ],
                    ],
                    [
                        'label' => 'Отзывы',
                        'icon' => 'comments',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Все отзывы', 'icon' => 'circle-o', 'url' => ['/reviews/index'],],
                        ],
                    ],
                    [
                        "label" => "Управление пользователями",
                        "url" => "#",
                        "icon" => "users",
                        "items" => [
                            [
                                "label" => "Пользователи",
                                "url" => ["/users/index"],
                            ],
                            [
                                "label" => "Создать пользователя",
                                "url" => ["/users/create"],
                            ],
                        ],
                    ],

                ],
            ]
        ) ?>

    </section>

</aside>
