<?php

namespace App\Models;

use App\Models\DestinationModel;
use App\Models\HeadlineModel;
use App\Models\MediaModel;
use CodeIgniter\Model;

class HomeModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'destination';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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

    public static function getHeadline()
    {
        $model = new HeadlineModel();
        return $model->first();
    }

    public static function getDestinationById($id)
    {
        $model = new DestinationModel();
        return $model->where(['id' => $id, 'deleted_at' => null])->first();
    }

    public static function getMediaByDestinationId($id)
    {
        $model = new MediaModel();
        return $model->where(['destination_id' => $id])->findAll();
    }

    public static function getPopular()
    {
        $db = db_connect();
        return $db->query('SELECT * FROM v_popular_destination')->getResult();
    }
}
