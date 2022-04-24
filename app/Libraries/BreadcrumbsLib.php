<?php
namespace App\Libraries;

use App\Models\MenuModel;

class BreadcrumbsLib
{
    protected $menu;

    public function __construct()
    {
        $this->menu = new MenuModel();
    }

    function breadcrumbs($menu_id) {
        $breadcrumbs = $this->generateBreadcrumbs($menu_id);
        $result = '<div class="col-sm-6">';
        $result .= '<ol class="breadcrumb float-sm-right">';
        foreach ($breadcrumbs as $key => $breadcrumb) {
            $result .= '<li class="breadcrumb-item">' . $breadcrumb['name'] . '</li>';
        }
        $result .= '</ol>';
        $result .= '</div>';
        return $result;
    }

//    <ol class="breadcrumb">
//        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
//        <li class="active">Dashboard</li>
//    </ol>

    function generateBreadcrumbs($menu_id, &$breadcrumbs = array())
    {
        if ($menu_id != null) {
            $menu = $this->menu->find($menu_id);
            if($menu != null){
                if ($menu->parent_id != null) {
                    $parent = $this->menu->find($menu->parent_id);
                    if ($parent != null){
                        $this->generateBreadcrumbs($parent->id, $breadcrumbs);
                    }
                }
            }
            $breadcrumbs[$menu->id]['name'] = $menu->name;
            $breadcrumbs[$menu->id]['slug'] = $menu->slug;
        }

        return $breadcrumbs;
    }

    function getMenuId($slug) {
        $menu = $this->menu->getBySlug($slug);
        return $menu->id;
    }
}