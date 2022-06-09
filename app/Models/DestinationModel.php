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
        'image_portrait',
        'image_landscape',
        'url',
        'lat',
        'long',
        'status_apps',
        'status_web',
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
        'url'         => 'required',
        'lat'         => 'required',
        'long'        => 'required',
        'status_apps' => 'required',
        'category_id' => 'required|is_category_exists[category_id]',
    ];
    protected $validationMessages = [
        'name'        => [
            'required' => 'Name is required',
        ],
        'description' => [
            'required' => 'Description is required',
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
        'status_apps' => [
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

    public static function getAll($request, $limit, $page, $query, $lat, $long)
    {
        $where = ['deleted_at' => null];
        if ($request->getGet('category')) {
            $where['category_id'] = $request->getGet('category');
        }
        if ($request->getGet('popular') || ($request->getGet('sort_by') && $request->getGet('sort_by') == 'popular')) {
            $db = db_connect();
            return $db->table('v_popular_destination')->where($where)->like('name', $query)->get($limit, $page)->getResult();
        }
        if ($request->getGet('sort_by') && $request->getGet('sort_by') == 'distance' && $request->getGet('lat') && $request->getGet('long')) {
            $db = db_connect();
            $lat = $request->getGet('lat');
            $long = $request->getGet('long');
            return $db->table('destination')->select('*, (6371 * acos(cos(radians(' . $lat . ')) * cos(radians(lat)) * cos( radians(`long`) - radians(' . $long . ')) + sin (radians(' . $lat . ')) * sin(radians(lat)))) AS distance')->where($where)->like('name', $query)->orderBy('distance', 'ASC')->get($limit, $page)->getResult();
        }

        $model = new DestinationModel();

        $whereIn = ['0', '1', '2', '3'];

        if ($request->getGet('intro')) {
            $whereIn = ['1', '3'];
        }

        if ($request->getGet('home')) {
            $whereIn = ['2', '3'];
        }

        return $model->whereIn('status_apps', $whereIn)->where($where)->like('name', $query)->orderBy('id', 'ASC')->get($limit, $page)->getResult();
    }

    public static function getAllCounter()
    {
        $model = new DestinationModel();
        return count($model->select('id')->where('deleted_at', null)->findAll());
    }

    public static function findById($id)
    {
        $model = new DestinationModel();
        return $model->where([$model->primaryKey => $id])->where(['deleted_at' => null])->first();
    }

    public static function createNew($model, $request, $image_portrait, $image_landscape, $user)
    {
        return $model->insert([
            'name'            => $request->getVar('name'),
            'description'     => $request->getVar('description'),
            'image_portrait'  => $image_portrait,
            'image_landscape' => $image_landscape,
            'url'             => $request->getVar('url'),
            'lat'             => $request->getVar('lat'),
            'long'            => $request->getVar('long'),
            'status_apps'     => $request->getVar('status_apps'),
            'category_id'     => $request->getVar('category_id'),

            'created_at'      => date('Y-m-d H:i:s'),
        ]);
    }

    public static function updateData($id, $model, $image_portrait, $image_landscape, $request, $user)
    {
        $data = [
            'name'        => $request->getVar('name'),
            'description' => $request->getVar('description'),
            'url'         => $request->getVar('url'),
            'lat'         => $request->getVar('lat'),
            'long'        => $request->getVar('long'),
            'status'      => $request->getVar('status'),
            'category_id' => $request->getVar('category_id'),

            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        if ($image_portrait != '') {
            $data['image_portrait'] = $image_portrait;
        }
        if ($image_landscape != '') {
            $data['image_landscape'] = $image_landscape;
        }
        return $model->update($id, $data);
    }

    public static function softDelete($id, $model, $user)
    {
        return $model->update($id, [
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
