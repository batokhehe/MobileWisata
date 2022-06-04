<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditTrialModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'audit_trial';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'event',
        'module',
        'user_id',
        'created_at',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
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
        $model = new AuditTrialModel();
        return $model->where()->like('name', $query)->orderBy('id', 'DESC')->get($limit, $page)->getResult();
    }

    public static function getAllCounter()
    {
        $model = new AuditTrialModel();
        return count($model->select('id')->where('deleted_at', null)->findAll());
    }

    public static function findById($id)
    {
        $model = new AuditTrialModel();
        return $model->where([$model->primaryKey => $id])->where()->first();
    }

    public static function createNew($model, $event, $module, $user)
    {
        return $model->insert([
            'event'      => $event,
            'module'     => $module,
            'user_id'    => $user->data->id,

            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}