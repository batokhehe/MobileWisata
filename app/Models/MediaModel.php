<?php

namespace App\Models;

use CodeIgniter\Model;

class MediaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'media';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'media_type',
        'position',
        'file_name',
        'file_path',
        'destination_id',
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
        'media_type'     => 'required',
        'destination_id' => 'required|is_destination_exists[category_id]',
    ];
    protected $validationMessages = [
        'media_type'     => [
            'required' => 'Media Type is required',
        ],
        'destination_id' => [
            'required'              => 'Destination is required',
            'is_destination_exists' => 'Destination is not exists',
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

    public static function getAll()
    {
        $model = new MediaModel();
        return $model->findAll();
    }

    public static function findById($id)
    {
        $model = new MediaModel();
        return $model->where([$model->primaryKey => $id])->where(['deleted_at' => null])->first();
    }

    public static function createNew($model, $request, $file_name, $file_path, $user)
    {
        return $model->insert([
            'media_type'     => $request->getVar('media_type'),
            'file_name'      => $file_name,
            'file_path'      => $file_path,
            'destination_id' => $request->getVar('destination_id'),

            'created_at'     => date('Y-m-d H:i:s'),
        ]);
    }

    public static function updateData($id, $model, $request, $file_name, $file_path, $user)
    {
        return $model->update($id, [
            'media_type'     => $request->getVar('media_type'),
            'file_name'      => $file_name,
            'file_path'      => $file_path,
            'destination_id' => $request->getVar('destination_id'),

            'updated_at'     => date('Y-m-d H:i:s'),
        ]);
    }

    public static function softDelete($id, $model, $user)
    {
        return $model->update($id, [
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
