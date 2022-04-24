<?php
/**
 * Created by PhpStorm.
 * User: thomzee
 * Date: 31/01/18
 * Time: 01.22
 */

class RoleLib
{
    protected $_ci;
    protected $access;
    protected $delimiter;

    protected $current;
    protected $current_group;
    protected $current_accesses;
    protected $available_menus;

    function __construct()
    {
        $this->_ci = &get_instance();
        $this->_ci->load->model('Menu_model', 'menu');
        $this->_ci->load->model('Groupmenu_model', 'group_menu');
        $this->_ci->load->library('TreeLib');

        $this->_ci->config->load('access', TRUE);
        $this->access = $this->_ci->config->item('menu', 'access');
        $this->delimiter = $this->_ci->config->item('delimiter', 'access');

        $this->current = $this->_ci->session->userdata('aeon-panel');
        if($this->_ci->session->has_userdata('aeon-panel')) {
            $this->current_group = $this->current['UserGroupCode']; //$this->_ci->ion_auth->get_users_groups()->row()->id;
            $this->current_accesses = $this->_ci->group_menu->findByGroup($this->current_group);
            $this->available_menus = pluck_obj($this->current_accesses, 'menu_id');
        }
    }

    public function role($role = null, $info = false)
    {
        $tree = $this->_ci->menu->roleLib();
        $menus = pluck_obj($this->_ci->menu->all(), 'id');
        $menusWithParents = $this->menusWithParents($tree, $menus);
        $tree = $this->_ci->treelib->arrayTreeByCurrent($tree, $menusWithParents);
        $html  = '<ul class="list-group">';
        $html .= $this->treeRole($tree, $role, $info);
        $html .= '</ul>';

        return $html;
    }

    public function roleUpdate($role = null, $info = false)
    {
        $tree = $this->_ci->menu->roleLib();
        $menus = pluck_obj($this->_ci->menu->allUpdate(), 'id');
        $menusWithParents = $this->menusWithParents($tree, $menus);
        $tree = $this->_ci->treelib->arrayTreeByCurrent($tree, $menusWithParents);
        $html  = '<ul class="list-group">';
        $html .= $this->treeRole($tree, $role, $info);
        $html .= '</ul>';

        return $html;
    }

    public function roleDetail($role = null, $info = false)
    {
        $this->current_accesses = $this->_ci->group_menu->findByGroup($role);
        $this->available_menus = pluck_obj($this->current_accesses, 'menu_id');

        $tree = $this->_ci->menu->roleLib();
        $menusWithParents = $this->menusWithParents($tree, $this->available_menus);
        $tree = $this->_ci->treelib->arrayTreeByCurrent($tree, $menusWithParents);

        $html  = '<ul class="list-group">';
        $html .= $this->treeRoleDetail($tree, $role, $info);
        $html .= '</ul>';

        return $html;
    }

    public function menusWithParents($menus, $available_menus) {
        $temps = [];
        if ($menus) {
            foreach ($menus as $menu) {
                if (in_array($menu['id'], $available_menus)) {
                    $temps[] = $menu['id'];

                    $parent = $this->_ci->menu->find($menu['id'])->parent_id;
                    if ($parent != null && !in_array($parent, $temps)) {
                        $temps[] = $parent;
                    }
                }
            }
        }

        return $temps;
    }

    public function treeRole(array $array, $role = null, $info = false, &$html = null)
    {
        $all = 'Index';
        foreach ($array as $value) {
            $children = false;

            if (isset($value['children']) && sizeof($value['children']) > 0) {
                $children = true;
            }

            $html .= '<li class="list-group-item">';

            if ($value['icon'] != null) {
                $html .= print_icon($value['icon']);
            }

            $html .= ' &nbsp; '.$value['name'];

            if (! $children && $value['slug']!=null && $value['controller']!=null && $value['model']!=null) {
                $index = $this->access[$value['slug']]['index'];
                $access = $this->access[$value['slug']]['action'];
                if ($this->current_accesses) {
                    foreach ($this->current_accesses as $current_access) {
                        if ($value['id'] == $current_access->menu_id) {
                            $access = explode(',', $current_access->access);
                        }
                    }
                }
                if ($role != null) {
                    $haveAccess = [];
                    foreach (
                        $this->_ci->group_menu->roleLib($role, $value['id'])
                        as $rolemenu
                    ) {
                        $haveAccess = explode($this->delimiter, $rolemenu->access);
                    }
                    if ($info) {
                        $html .= '<ul class="action">';
                        foreach ($access as $action) {
                            if (in_array($action, $haveAccess)) {
                                $html .= '<li class="text-success">';
                                $html .= '<i class="fa fa-check fa-fw"></i>';
                                if ($action==$index) {
                                    $html .= ' &nbsp; <strong>'.ucwords($all).'</strong>';
                                } else {
                                    if (ucwords($action) == 'Detail') {
                                        $html .= ' &nbsp; '.ucwords('view');
                                    } else {
                                        $html .= ' &nbsp; '.ucwords($action);
                                    }
                                }
                                $html .= '</li>';
                            } else {
                                $html .= '<li class="text-danger">';
                                $html .= '<i class="fa fa-times fa-fw"></i>';
                                if ($action==$index) {
                                    $html .= ' &nbsp; <strong>'.ucwords($all).'</strong>';
                                } else {
                                    if (ucwords($action) == 'Detail') {
                                        $html .= ' &nbsp; '.ucwords('view');
                                    } else {
                                        $html .= ' &nbsp; '.ucwords($action);
                                    }
                                }
                                $html .= '</li>';
                            }
                        }
                        $html .= '</ul>';
                    } else {
                        $html .= '<ul class="action">';
                        foreach ($access as $action) {
                            $html .= '<li>';
                            $html .= '<div class="checkbox">';
                            $html .= '<label>';
                            if ($action==$index) {
                                if ($value['slug'] == 'home') {
                                    $html .= '<input type="checkbox" name="access['.$value['id'].'][]" value="'.$action.'" checked disabled class="primary">'; // hapus checked
                                    $html .= '<input type="hidden" name="access['.$value['id'].'][]" value="'.$action.'">';
                                    $html .= ' &nbsp; <strong>'.ucwords($all).'</strong>';
                                }else{
                                    $html .= '<input type="checkbox" name="access['.$value['id'].'][]" value="'.$action.'"'.(in_array($action, $haveAccess) ? ' checked' : '').' class="primary">';
                                    $html .= ' &nbsp; <strong>'.ucwords($all).'</strong>';
                                }
                            } else {
                                $html .= '<input type="checkbox" name="access['.$value['id'].'][]" value="'.$action.'"'.(in_array($action, $haveAccess) ? ' checked' : '').' '.(!in_array($index, $haveAccess) ? ' disabled' : '').'>';
                                if (ucwords($action) == 'Detail') {
                                    $html .= ' &nbsp; '.ucwords('view');
                                } else {
                                    $html .= ' &nbsp; '.ucwords($action);
                                }
                            }
                            $html .= '</label>';
                            $html .= '</div>';
                            $html .= '</li>';
                        }
                        $html .= '</ul>';
                    }
                } else {
                    $html .= '<ul class="action">';
                    foreach ($access as $action) {
                        $html .= '<li>';
                        $html .= '<div class="checkbox">';
                        $html .= '<label>';
                        if ($action==$index) {
                            if ($value['slug'] == 'home') {
                                $html .= '<input type="checkbox" name="access['.$value['id'].'][]" value="'.$action.'" checked disabled class="primary">'; // hapus checked
                                $html .= '<input type="hidden" name="access['.$value['id'].'][]" value="'.$action.'">';
                                $html .= ' &nbsp; <strong>'.ucwords($all).'</strong>';
                            }else{
                                $html .= '<input type="checkbox" name="access['.$value['id'].'][]" value="'.$action.'"  class="primary">'; // hapus checked
                                $html .= ' &nbsp; <strong>'.ucwords($all).'</strong>';
                            }
                        } else {
                            $html .= '<input type="checkbox" name="access['.$value['id'].'][]" value="'.$action.'" >'; // hapus checked
                            if (ucwords($action) == 'Detail') {
                                $html .= ' &nbsp; '.ucwords('view');
                            } elseif ((substr($value['name'], 0,9) == "Transaksi") && (ucwords($action) == 'Create')) {
                                $html .= ' &nbsp; Print';//ucwords($action);
                            }
                            else {
                                $html .= ' &nbsp; '.ucwords($action);
                            }
                        }
                        $html .= '</label>';
                        $html .= '</div>';
                        $html .= '</li>';
                    }
                    $html .= '</ul>';
                }
            }

            if ($children && $value['slug']==null && $value['controller']==null && $value['model']==null && ! $info) {
                $html .= '<div class="checkbox check_all_content">';
                $html .= '<label>';
                $html .= '<input type="checkbox" class="check_all"> &nbsp; '.lang('check_all');
                $html .= '</label>';
                $html .= '</div>';
            }

            $html .= '</li>';

            if ($children) {
                $html .= '<li class="list-group-item children">';
                $html .= '<ul class="list-group">';
                $this->treeRole($value['children'], $role, $info, $html);
                $html .= '</ul>';
                $html .= '</li>';
            }
        }

        return $html;
    }

    public function treeRoleDetail(array $array, $role = null, $info = false, &$html = null)
    {
        $all = 'Index';
        foreach ($array as $value) {
            $children = false;

            if (isset($value['children']) && sizeof($value['children']) > 0) {
                $children = true;
            }

            $html .= '<li class="list-group-item">';

            if ($value['icon'] != null) {
                $html .= print_icon($value['icon']);
            }

            $html .= ' &nbsp; '.$value['name'];

            if (!$children && $value['slug']!=null && $value['controller']!=null && $value['model']!=null) {
                $index = $this->access[$value['slug']]['index'];
                $access = $this->access[$value['slug']]['action'];
                if ($this->current_accesses) {
                    foreach ($this->current_accesses as $current_access) {
                        if ($value['id'] == $current_access->menu_id) {
                            $access = explode(',', $current_access->access);
                        }
                    }
                }
                if ($role != null) {
                    $haveAccess = [];
                    foreach (
                        $this->_ci->group_menu->roleLib($role, $value['id'])
                        as $rolemenu
                    ) {
                        $haveAccess = explode($this->delimiter, $rolemenu->access);
                    }
                    if ($info) {
                        $html .= '<ul class="action">';
                        foreach ($access as $action) {
                            if (in_array($action, $haveAccess)) {
                                $html .= '<li class="text-success">';
                                $html .= '<i class="fa fa-check fa-fw"></i>';
                                if ($action==$index) {
                                    $html .= ' &nbsp; <strong>'.ucwords($all).'</strong>';
                                } else {
                                    if (ucwords($action) == 'Detail') {
                                        $html .= ' &nbsp; '.ucwords('view');
                                    } else {
                                        $html .= ' &nbsp; '.ucwords($action);
                                    }
                                }
                                $html .= '</li>';
                            } else {
                                $html .= '<li class="text-danger">';
                                $html .= '<i class="fa fa-times fa-fw"></i>';
                                if ($action==$index) {
                                    $html .= ' &nbsp; <strong>'.ucwords($all).'</strong>';
                                } else {
                                    if (ucwords($action) == 'Detail') {
                                        $html .= ' &nbsp; '.ucwords('view');
                                    } else {
                                        $html .= ' &nbsp; '.ucwords($action);
                                    }
                                }
                                $html .= '</li>';
                            }
                        }
                        $html .= '</ul>';
                    } else {
                        $html .= '<ul class="action">';
                        foreach ($access as $action) {
                            if (in_array($action, $haveAccess)) {
                                $html .= '<li>';
                                $html .= '<div class="checkbox">';
                                $html .= '<label>';
                                if ($action==$index) {
                                    if ($value['slug'] == 'home') {
                                        $html .= '<input type="checkbox" name="access['.$value['id'].'][]" value="'.$action.'" checked disabled class="primary">'; // hapus checked
                                        $html .= '<input type="hidden" name="access['.$value['id'].'][]" value="'.$action.'">';
                                        $html .= ' &nbsp; <strong>'.ucwords($all).'</strong>';
                                    }else{
                                        $html .= '<input type="checkbox" name="access['.$value['id'].'][]" value="'.$action.'"'.(in_array($action, $haveAccess) ? ' checked' : '').' class="primary" disabled>';
                                        $html .= ' &nbsp; <strong>'.ucwords($all).'</strong>';
                                    }
                                } else {
                                    $html .= '<input type="checkbox" name="access['.$value['id'].'][]" value="'.$action.'"'.(in_array($action, $haveAccess) ? ' checked' : '').' disabled>';
                                    if (ucwords($action) == 'Detail') {
                                        $html .= ' &nbsp; '.ucwords('view');
                                    } else {
                                        $html .= ' &nbsp; '.ucwords($action);
                                    }
                                }
                                $html .= '</label>';
                                $html .= '</div>';
                                $html .= '</li>';
                            }
                        }
                        $html .= '</ul>';
                    }
                } else {
                    $html .= '<ul class="action">';
                    foreach ($access as $action) {
                        if ($action==$index) {
                            $html .= '<li>';
                            $html .= '<div class="checkbox">';
                            $html .= '<label>';
                            if ($action==$index) {
                                if ($value['slug'] == 'home') {
                                    $html .= '<input type="checkbox" name="access['.$value['id'].'][]" value="'.$action.'" checked disabled class="primary">'; // hapus checked
                                    $html .= '<input type="hidden" name="access['.$value['id'].'][]" value="'.$action.'">';
                                    $html .= ' &nbsp; <strong>'.ucwords($all).'</strong>';
                                }else{
                                    $html .= '<input type="checkbox" name="access['.$value['id'].'][]" value="'.$action.'"  class="primary" disabled>'; // hapus checked
                                    $html .= ' &nbsp; <strong>'.ucwords($all).'</strong>';
                                }
                            } else {
                                $html .= '<input type="checkbox" name="access['.$value['id'].'][]" value="'.$action.'" disabled>'; // hapus checked
                                if (ucwords($action) == 'Detail') {
                                    $html .= ' &nbsp; '.ucwords('view');
                                } elseif ((substr($value['name'], 0,9) == "Transaksi") && (ucwords($action) == 'Create')) {
                                    $html .= ' &nbsp; Print';//ucwords($action);
                                }
                                else {
                                    $html .= ' &nbsp; '.ucwords($action);
                                }
                            }
                            $html .= '</label>';
                            $html .= '</div>';
                            $html .= '</li>';
                        }
                    }
                    $html .= '</ul>';
                }
            }

            $html .= '</li>';

            if ($children) {
                $html .= '<li class="list-group-item children">';
                $html .= '<ul class="list-group">';
                $this->treeRoleDetail($value['children'], $role, $info, $html);
                $html .= '</ul>';
                $html .= '</li>';
            }
        }

        return $html;
    }
}