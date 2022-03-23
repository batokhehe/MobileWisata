<?php

namespace App\Models;

use CodeIgniter\Model;

class DestinationModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'destination';
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
        'image',
        'url',
        'lat',
        'long',
        'status',
        'category_id',
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
        'name'        => 'required',
        'description' => 'required',
        'image'       => 'required',
        'url'         => 'required',
        'lat'         => 'required',
        'long'        => 'required',
        'status'      => 'required',
        'category_id' => 'required|is_category_exists[category_id]',
    ];
    protected $validationMessages = [
        'name'        => [
            'required' => 'Name is required',
        ],
        'description' => [
            'required' => 'Description is required',
        ],
        'image'       => [
            'required' => 'Image is required',
        ],
        'url'         => [
            'required' => 'Url is required',
        ],
        'lat'         => [
            'required' => 'Latitude is required',
        ],
        'long'        => [
            'required' => 'Longitude is required',
        ],
        'status'      => [
            'required' => 'Status is required',
        ],
        'category_id' => [
            'required'           => 'Category is required',
            'is_category_exists' => 'Category is not exists',
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

    public static function getAll($request)
    {
        if ($request->getGet('popular')) {
            $db = db_connect();
            return $db->query('SELECT * FROM v_popular_destination')->getResult();
        }

        $model = new DestinationModel();

        $where = ['deleted_at' => null];
        $whereIn = ['0', '1', '2', '3'];

        if ($request->getGet('intro')) {
            $whereIn = ['1', '3'];
        }

        if ($request->getGet('home')) {
            $whereIn = ['2', '3'];
        }

        if ($request->getGet('category')) {
            $where['category_id'] = $request->getGet('category');
        }

        $like = '';
        if ($request->getGet('query')) {
            $like = $request->getGet('query');
        }

        return $model->whereIn('status', $whereIn)->where($where)->like('name', $like)->findAll();
    }

    public static function findById($id)
    {
        $model = new DestinationModel();
        return $model->where([$model->primaryKey => $id])->where(['deleted_at' => null])->first();
    }

    public static function createNew($model, $request, $user)
    {
        return $model->insert([
            'name'        => $request->getVar('name'),
            'description' => $request->getVar('description'),
            'image'       => $request->getVar('image'),
            'url'         => $request->getVar('url'),
            'lat'         => $request->getVar('lat'),
            'long'        => $request->getVar('long'),
            'status'      => $request->getVar('status'),
            'category_id' => $request->getVar('category_id'),

            'created_at'  => date('Y-m-d H:i:s'),
        ]);
    }

    public static function updateData($id, $model, $request, $user)
    {
        return $model->update($id, [
            'name'        => $request->getVar('name'),
            'description' => $request->getVar('description'),
            'image'       => $request->getVar('image'),
            'url'         => $request->getVar('url'),
            'lat'         => $request->getVar('lat'),
            'long'        => $request->getVar('long'),
            'status'      => $request->getVar('status'),
            'category_id' => $request->getVar('category_id'),

            'updated_at'  => date('Y-m-d H:i:s'),
        ]);
    }

    public static function softDelete($id, $model, $user)
    {
        return $model->update($id, [
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
