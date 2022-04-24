<?php
namespace App\Libraries;

use App\Models\MenuModel;
use App\Libraries\SecurityLib;

class MenuLib
{
    protected $menu;
    protected $securitylib;
    public $active_menu;

    public function __construct()
    {
        $this->menu = new MenuModel();
        $this->securitylib = new SecurityLib();
    }

    public function arrayTree(array $array, $parent = null)
    {
        $tree = [];
        foreach ($array as $key => $value) {
            $value = (array)$value;
            if ($value['parent_id'] == $parent) {
                $children = $this->arrayTree($array, $value['id']);
                if ($children) {
                    $value['children'] = $children;
                }
                $tree[] = $value;
            }
        }
        return $tree;
    }

    public function arrayTreeIds(array $array, $parent = null)
    {
        $ids = [];
        foreach ($array as $value) {
            $value = (array)$value;
            if ($value['parent_id'] == $parent) {
                $children = $this->arrayTreeIds($array, $value['id']);
                if ($children) {
                    $ids[$value['id']] = $children;
                } else {
                    $ids[$value['id']] = $value['id'];
                }
            }
        }
        return $ids;
    }

    public function arrayTreeSearch(array $haystack, $needle)
    {
        foreach ($haystack as $key => $value) {
            if (is_array($value)) {
                $return = $this->arrayTreeSearch($value, $needle);
                if (is_array($return)) {
                    return [$key => $return];
                }
            } else {
                if ($value == $needle) {
                    return [$key => $needle];
                }
            }
        }
        return false;
    }

    public function arrayTreeKeys(array $array)
    {
        $keys = [];
        foreach ($array as $key => $value) {
            $keys[] = $key;
            if (is_array($array[$key])) {
                $keys = array_merge($keys, $this->arrayTreeKeys($array[$key]));
            }
        }
        return $keys;
    }

    public function sidebar($slug)
    {
        $menu = $this->menu->getBySlug($slug);
        $tree = $this->menu->getSidebar();
        $tree = $this->arrayTree($tree);
        $tree = $this->treeSidebar($tree, $menu);
        return $tree;
    }

    public function treeSidebarIds($menu)
    {
        $tree = $this->menu->getTree();
        $tree = $this->arrayTreeIds($tree);
        $tree = is_array($this->arrayTreeSearch($tree, $menu)) ? $this->arrayTreeSearch($tree, $menu) : [];
        $tree = $this->arrayTreeKeys($tree);
        return $tree;
    }

    public function treeSidebar(array $array, $menu, &$html = null)
    {
        foreach ($array as $value) {
            $children = false;

            if (isset($value['children']) && sizeof($value['children']) > 0) {
                $count = 0;
                foreach ($value['children'] as $key => $chid) {
                    if ($this->securitylib->check_access('index', $chid['slug'])) {
                        $count++;
                    }
                }
                if($count > 0){
                    $children = true;
                }
            }

        //    $active = '';
        //    if ($this->active_menu == $value['slug']) {
        //        $active = 'active';
        //    }

            if ($children) {
                $exists = false;
                foreach ($value['children'] as $c) {
                    if ($this->active_menu == $c['slug']) {
                        $exists = true;
                    }
                }
                $html .= '<li class="nav-item has-treeview ' . ($exists == true ? 'menu-open' : '') . '">';
            } else {
                if ($value['slug'] != null && $value['controller'] != null && $value['model'] != null) {
                    if ($this->securitylib->check_access('index', $value['slug'])) {
                        $html .= '<li class="nav-item ' . ($this->active_menu == $value['slug'] ? ' active' : '') . '">';
                    } else {
                        $html .= '<li hidden class="nav-item '.(in_array($value['id'], $this->treeSidebarIds($menu)) ? ' active' : '').'">';
                    }
                } else {
                    $html .= '<li hidden class="nav-item' . (in_array($value['id'], $this->treeSidebarIds($menu)) ? ' active' : '') . '">';
                }
            }

            if ($value['slug'] != null) {
                $html .= '<a href="' . base_url() . '/admin/' . $value['slug'] . '" class="nav-link' . ($this->active_menu == $value['slug'] ? ' active' : '') . '">';
            } else {
                $html .= '<a class="nav-link" href="javascript:void(0)">';
            }

            if ($value['icon'] != null) {
                $html .= print_icon($value['icon']);
            }

            $html .= '&nbsp; <p>' . $value['name'];
            if ($children) {
                $html .= ' <i class="right fas fa-angle-left"></i>';
            }
            $html .= '</p>';

            // if ($children) {
            //     $html .= '<span class="pull-right-container">';
            //     $html .= '</span>';
            // }

            $html .= '</a>';

            if ($children) {
                $exists = false;
                foreach ($value['children'] as $c) {
                    if ($this->active_menu == $c['slug']) {
                        $exists = true;
                    }
                }
                $html .= '<ul class="nav nav-treeview" ' . ($exists == true ? ' style="display:block;"' : '') . '>';
                $this->treeSidebar($value['children'], $menu, $html);
                $html .= '</ul>';
            }

            $html .= '</li>';
        }

        return $html;
    }
}