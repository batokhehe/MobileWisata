<?php
namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    public $table = 'menus';
    public $name;
    public $slug;
    public $parent_id;
    public $icon;
    public $controller;
    public $model;
    public $sequence;
    public $active;
    public $created_at;
    public $updated_at;
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function find($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->where('id', $id);
        // $builder->where('active', '1');
        $query = $builder->get();

        return $query->getRow();
    }

    public function findGroupID($id){
        $builder = $this->db->table('users_groups');
        $builder->select('*');
        $builder->where('user_id', $id);
        $query = $builder->get();

        return $query->getRow()->group_id;
    }    

    public function joinGroupMenu($session){
        $groups_menus = 'groups_menus';
        if ($session->has('email')) {

            $group_id = $this->findGroupID($session->user_id);

            $builder = $this->db->table($this->table);
            $builder->distinct($this->table.'.id');
            $builder->select($this->table.'.slug');
            $builder->select('gm.access');
            $builder->join($groups_menus . ' as gm', 'gm.menu_id = ' . $this->table . '.id', 'left');
            $builder->where('gm.group_id', $group_id);
            $query = $builder->get();

            return $query->getResult();
        } else {
            return [];
        }
    }

    public function findMenuId($value)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('slug', $value);
        $query = $this->db->get();

        return $query->row();
    }

    public function all()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('active', '1');
        $query = $this->db->get();

        return $query->result();
    }

    public function allUpdate()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('active', '1');
        $this->db->where('id <', '11');
        $query = $this->db->get();

        return $query->result();
    }

    public function first()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('active', '1');
        $query = $this->db->get();

        return $query->first_row();
    }

    /* for sidebar */
    public function getSidebar()
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->where('active', '1');
        $builder->orderBy('sequence', 'asc');
        $query = $builder->get();

        return $query->getResult();
    }

    public function getBySlug($slug)
    {
        $builder = $this->db->table($this->table);
        $builder->select('*');
        $builder->where('slug', $slug);
        $query = $builder->get();

        return $query->getRow();
    }

    public function getTree()
    {
        $builder = $this->db->table($this->table);
        $builder->select('id, parent_id');
        $builder->where('active', '1');
        $builder->orderBy('sequence', 'asc');
        $query = $builder->get();

        return $query->getResult();
    }

    public function seederAccess()
    {
        $this->db->select('id, slug');
        $this->db->from($this->table);
        $notNUll = ' is NOT NULL';
        $this->db->where('slug' . $notNUll);
        $this->db->where('controller' . $notNUll);
        $this->db->where('model' . $notNUll);
        $query = $this->db->get();

        return $query->result();
    }

    public function roleLib()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->order_by('sequence', 'asc');
        $query = $this->db->get();

        return $query->result_array();
    }
}
