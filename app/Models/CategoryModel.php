<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'category';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name'        => 'required',
        'description' => 'required',
    ];
    protected $validationMessages = [
        'name'        => [
            'required' => 'Category Name is required',
        ],
        'description' => [
            'required' => 'Category Description is required',
        ],
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
        $model = new CategoryModel();
        return $model->where(['deleted_at' => null])->like('name', $query)->orderBy('id', 'ASC')->get($limit, $page)->getResult();
    }

    public static function getAllCounter()
    {
        $model = new CategoryModel();
        return count($model->select('id')->where('deleted_at', null)->findAll());
    }

    public static function findById($id)
    {
        $model = new CategoryModel();
        return $model->where([$model->primaryKey => $id])->where(['deleted_at' => null])->first();
    }

    public static function createNew($model, $request, $user)
    {

        return $model->insert([
            'name'        => $request->getVar('name'),
            'description' => $request->getVar('description'),
            'created_at'   => date('Y-m-d H:i:s'),
        ]);
    }

    public static function updateData($id, $model, $request, $user)
    {
        return $model->update($id, [
            'name'        => $request->getVar('name'),
            'description' => $request->getVar('description'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);
    }

    public static function softDelete($id, $model, $user)
    {
        return $model->update($id, [
            'deleted_at'   => date('Y-m-d H:i:s'),
        ]);
    }
}
