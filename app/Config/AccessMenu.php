<?php

namespace Config;

class AccessMenu
{
    public static function delimiter()
    {
        return ',';
    }

    public static function menu()
    {
        return [
            'user' => [
                'slug'   => 'user',
                'index'  => 'index',
                'action' => ['index', 'detail', 'create', 'update', 'delete'],
                'access' => 'index, detail, create, update, delete',
            ],
            'destination' => [
                'slug'   => 'destination',
                'index'  => 'index',
                'action' => ['index', 'detail', 'create', 'update', 'delete'],
                'access' => 'index, detail, create, update, delete',
            ],
            'headline' => [
                'slug'   => 'headline',
                'index'  => 'index',
                'action' => ['index'],
                'access' => 'index',
            ],
            'media' => [
                'slug'   => 'media',
                'index'  => 'index',
                'action' => ['index', 'detail', 'create', 'update', 'delete'],
                'access' => 'index, detail, create, update, delete',
            ],
            'blog' => [
                'slug'   => 'blog',
                'index'  => 'index',
                'action' => ['index', 'detail', 'create', 'update', 'delete'],
                'access' => 'index, detail, create, update, delete',
            ],
            'category' => [
                'slug'   => 'category',
                'index'  => 'index',
                'action' => ['index', 'detail', 'create', 'update', 'delete'],
                'access' => 'index, detail, create, update, delete',
            ],
            'guide' => [
                'slug'   => 'guide',
                'index'  => 'index',
                'action' => ['index', 'detail', 'create', 'update', 'delete'],
                'access' => 'index, detail, create, update, delete',
            ],
        ];
    }

    
}
