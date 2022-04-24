<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SidebarLib
{
    protected $_ci;

    public function __construct()
    {
        $this->_ci = &get_instance();
    }

    public function group($user_id)
    {
        if ($user_id) {
            $data = $this->session->userdata('aeon-panel');
            // $selected_groups = $this->_ci->users_group->findByUser($user_id);
            // $group = $selected_groups ? $this->_ci->group->find($selected_groups->group_id) : '';

            return $data['UserGroupCode'];
        }
    }    
}