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
    protected $session;

    public function __construct()
    {
        // $this->config    = new AccessMenu();
        // $this->access    = $this->config->menu();
        $this->delimiter = ',';

        $this->menus = new MenuModel();
        $this->session = \Config\Services::session(); 
    }

    public function check_access($action, $slug)
    {
        foreach ($this->menus->joinGroupMenu($this->session) as $key => $menu) {
            if ($menu->slug == $slug) {
                $accesses = explode($this->delimiter, $menu->access);
                if(in_array($action, $accesses)){
                    return true;
                }
            }
        }
        return false;
    }
}
