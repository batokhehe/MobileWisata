<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoriteModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'favorite';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'destination_id',
        'user_id',
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'destination_id' => 'required|is_destination_exists[destination_id]',
    ];
    protected $validationMessages = [
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

    public static function getAll($user, $request, $limit, $page)
    {
        $db    = db_connect();
        $where = ['user_id' => $user->data->id];
        $like  = '';
        if ($request->getGet('query')) {
            $like = $request->getGet('query');
        }
        return $db->table('v_favorite_list')->where($where)->like('destination_name', $like)->orderBy('id', 'ASC')->get($limit, $limit * $page)->getResult();
    }

    public static function findById($id)
    {
        $model = new FavoriteModel();
        return $model->where([$model->primaryKey => $id])->first();
    }

    public static function findByIdWithUser($destination, $user)
    {
        $model = new FavoriteModel();
        if ($model->where(['destination_id' => $destination, 'user_id' => $user])->first()) {
            return true;
        } else {
            return false;
        }
    }

    public static function createNew($model, $request, $user)
    {

        return $model->insert([
            'destination_id' => $request->getVar('destination_id'),
            'user_id'        => $user->data->id,
        ]);
    }

    public static function softDelete($id, $user, $model)
    {
        return $model->where(['destination_id' => $id, 'user_id' => $user->data->id])->delete();
    }
}
