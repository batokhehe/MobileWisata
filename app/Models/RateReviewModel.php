<?php

namespace App\Models;

use CodeIgniter\Model;

class RateReviewModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'rate_review';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'destination_id',
        'rate',
        'review',
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
        'rate'           => 'required',
        'review'         => 'required',
        'destination_id' => 'required|is_destination_exists[destination_id]',
        'user_id'        => 'required|is_user_exists[user_id]',
    ];
    protected $validationMessages = [
        'rate'           => [
            'required' => 'Rate is required',
        ],
        'review'         => [
            'required' => 'Review is required',
        ],
        'destination_id' => [
            'required'              => 'Destination is required',
            'is_destination_exists' => 'Destination is not exists',
        ],
        'user_id'        => [
            'required'       => 'User is required',
            'is_user_exists' => 'User is not exists',
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
        $db = db_connect();
        $where = ['deleted_at' => null];
        if ($request->getGet('destination')) {
            $where['destination_id'] = $request->getGet('destination');
        }
        if ($request->getGet('query')) {
            $where['rate'] = $request->getGet('query');
        }

        return $db->table('v_rate_review')->where($where)->orderBy('id', 'ASC')->get($limit, $page)->getResultArray();
    }

    public static function findById($id)
    {
        $model = new RateReviewModel();
        return $model->where([$model->primaryKey => $id])->where(['deleted_at' => null])->first();
    }

    public static function findAverageByDestinationId($id)
    {
        $model = new RateReviewModel();
        return $model->selectAvg('rate')->where(['destination_id' => $id, 'deleted_at' => null])->first()['rate'];
    }

    public static function createNew($model, $request, $user)
    {
        return $model->insert([
            'rate'           => $request->getVar('rate'),
            'review'         => $request->getVar('review'),
            'destination_id' => $request->getVar('destination_id'),
            'user_id'        => $user->data->id,

            'created_at'     => date('Y-m-d H:i:s'),
        ]);
    }

    public static function updateData($id, $model, $request, $user)
    {
        return $model->update($id, [
            'rate'           => $request->getVar('rate'),
            'review'         => $request->getVar('review'),
            'destination_id' => $request->getVar('destination_id'),
            'user_id'        => $user->data->id,

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
