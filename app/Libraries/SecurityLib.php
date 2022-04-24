<?php
namespace App\Libraries;

use Config\AccessMenu;
use App\Models\MenuModel;

class SecurityLib
{
    protected $access;
    protected $delimiter;
    protected $config;
    protected $menus;

    public function __construct()
    {
        $this->config    = new AccessMenu();
        $this->access    = $this->config->menu();
        $this->delimiter = $this->config->delimiter();

        $this->menus = new MenuModel();
    }

    public function check_access($action, $slug)
    {
        foreach ($this->access as $key => $menu) {
            if ($menu['slug'] == $slug) {
                if (in_array($action, $menu['action'])) {
                    return true;
                }
            }
        }
        return false;
    }
}
