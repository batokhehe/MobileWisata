<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'user';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDelete    = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'name',
        'email',
        'phone',
        'image',
        'password',
        'address',
        'forgot_password_code',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name'     => 'required',
        'email'    => 'required|valid_email|is_unique[user.email]|min_length[6]',
        // 'phone'    => 'required',
        'password' => 'required',
        // 'address'  => 'required',
    ];
    protected $validationMessages = [
        'name'     => [
            'required' => 'Name is required',
        ],
        'email'    => [
            'required' => 'Email is required',
        ],
        // 'phone'    => [
        //     'required' => 'Phone is required',
        // ],
        'password' => [
            'required' => 'Password is required',
        ],
        // 'address'  => [
        //     'required' => 'Address is required',
        // ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public static function getAll($request, $limit, $page, $query)
    {
        $model = new UserModel();
        return $model->like('name', $query)->orderBy('id', 'ASC')->get($limit, $page)->getResult();
    }

    public static function getAllCounter()
    {
        $model = new UserModel();
        return count($model->select('id')->findAll());
    }

    public static function findById($id)
    {
        $model = new UserModel();
        return $model->where([$model->primaryKey => $id])->where(['deleted_at' => null])->first();
    }

    public static function getUserByForgotCode($id)
    {
        $model = new UserModel();
        return $model->where(['forgot_password_code' => $id])->where(['deleted_at' => null])->first();
    }    

    public static function softDelete($id, $model, $user)
    {
        return $model->update($id, [
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function createNew($model, $request, $image, $password, $user)
    {
        return $model->insert([
            'name'       => $request->getVar('name'),
            'email'      => $request->getVar('email'),
            'phone'      => $request->getVar('phone'),
            'image'      => $image,
            'password'   => $password,
            'address'    => $request->getVar('address'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public static function updateData($id, $model, $request, $image, $password, $user)
    {
        $data = [
            'name'       => $request->getVar('name'),
            'email'      => $request->getVar('email'),
            'phone'      => $request->getVar('phone'),
            'address'    => $request->getVar('address'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        if ($password != '') {
            $data['password'] = $password;
        }
        if ($image != '') {
            $data['image'] = $image;
        }
        return $model->update($id, $data);
    }

}
