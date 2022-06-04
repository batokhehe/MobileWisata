<?php

namespace App\Models;

use CodeIgniter\Model;

class GuideModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'guide';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'title',
        'description',
        'image',
        'icon',
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
        'title'       => 'required',
        'description' => 'required',
        'icon' => 'required',
    ];
    protected $validationMessages = [
        'title'       => [
            'required' => 'Guide Title is required',
        ],
        'description' => [
            'required' => 'Guide Description is required',
        ],
        'icon' => [
            'required' => 'Guide Icon is required',
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
        $model = new GuideModel();
        return $model->where(['deleted_at' => null])->like('title', $query)->orderBy('id', 'ASC')->get($limit, $page)->getResult();
    }

    public static function getAllCounter()
    {
        $model = new GuideModel();
        return count($model->select('id')->where('deleted_at', null)->findAll());
    }

    public static function findById($id)
    {
        $model = new GuideModel();
        return $model->where([$model->primaryKey => $id])->where(['deleted_at' => null])->first();
    }

    public static function createNew($model, $request, $image, $user)
    {

        return $model->insert([
            'title'       => $request->getVar('title'),
            'description' => $request->getVar('description'),
            'image'       => $image,
            'icon' => $request->getVar('icon'),
            'created_at'  => date('Y-m-d H:i:s'),
        ]);
    }

    public static function updateData($id, $model, $request, $image, $user)
    {
        $data = [
            'title'       => $request->getVar('title'),
            'description' => $request->getVar('description'),
            'icon' => $request->getVar('icon'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];
        if ($image != '') {
            $data['image'] = $image;
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
