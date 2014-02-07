<?php
App::uses('HuradSeoListener', 'HuradSeo.Event');

HuradNavigation::addMenu(
    'hurad_seo',
    __d('hurad_seo', 'Hurad SEO'),
    '#',
    'manage_options',
    ['class' => 'glyphicon glyphicon-search']
);
HuradNavigation::addSubMenu(
    'hurad_seo',
    'dashboard',
    __d('hurad_seo', 'Configuration'),
    ['admin' => true, 'plugin' => 'hurad_seo', 'controller' => 'seo', 'action' => 'config'],
    'manage_options'
);

HuradMetaBox::addMetaBox('hurad-seo', __d('hurad_seo', 'Hurad SEO'), 'meta_box', 'Post.center');

CakeEventManager::instance()->attach(new HuradSeoListener());
