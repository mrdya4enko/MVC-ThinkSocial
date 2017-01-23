<?php
return [
     // User:
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
    'profile/show' => 'profile/show',
    'profile/edit' => 'profile/edit',
    'profile/update' => 'profile/update',
    'profile/input' => 'profile/input',
    'profile/insert' => 'profile/insert',
    'profile/delete' => 'profile/delete',
    //Managing the user groups
    'groups/page' => 'group/GroupPage',
    'groups/add' => 'group/MyGroupCreateJSON',
    'groups/subscribe' => 'group/Subscribe',
    'groups/unsubscribe' => 'group/UnSubscribe',
    'groups/find' => 'group/find',
    'groups' => 'group/index',
    'group/subsribe/([0-9]+)' => 'group/subsribe/$1',
    'group/unsubsribe/([0-9]+)' => 'group/unsubsribe/$1',
//
//
//
    'group/edit/([0-9]+)' => 'group/edit/$1',
    'group/([0-9]+)' => 'group/show/$1',
    // Main page
    'index.php' => 'site/index', // actionIndex in SiteController
    '' => 'site/index', // actionIndex in SiteController
];
