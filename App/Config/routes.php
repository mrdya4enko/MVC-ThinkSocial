<?php
return [
    /*****USER******/

    'user/register' => 'user/register',
    'user/login' => 'user/login',
    'user/logout' => 'user/logout',

    // Management users: (future)
    //'admin/user/create' => 'adminUser/create',
    //'admin/user/update/([0-9]+)' => 'adminUser/update/$1',
    //'admin/user/delete/([0-9]+)' => 'adminUser/delete/$1',
    //'admin/user' => 'adminUser/index',
    // Admin panel:
    // 'admin' => 'admin/index',
    //Managing the user profile

    /*****PROFILE******/

    'profile/show' => 'profile/show',
    'profile/edit' => 'profile/edit',
    'profile/update' => 'profile/update',
    'profile/input' => 'profile/input',
    'profile/insert' => 'profile/insert',
    'profile/delete' => 'profile/delete',

    /*****ALBUMS******/

    'albums/insert' => 'albums/insert',
    'albums/delete/([0-9]+)' => 'albums/deleteAlbum/$1',
    'albums' => 'albums/index',

    /*****ALBUM******/

    'album/([0-9]+)' => 'album/index/$1',
    'album/insert/([0-9]+)' => 'album/insertPhoto/$1',
    'album/update/([0-9]+)' => 'album/updateAlbum/$1',
    'album/delete/([0-9]+)' => 'album/deletePhoto/$1',

    /*****MAIN PAGE******/

    'index.php' => 'site/index', // actionIndex in SiteController
    '' => 'site/index', // actionIndex in SiteController
];
