<?php

namespace App\Models;

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
        return $model->where(['id' => $id])->first();
    }

    public static function getBlogById($id)
    {
        $model = new BlogModel();
        return $model->where(['id' => $id])->first();
    }

    public static function getPopularById($id)
    {
        $db = \Config\Database::connect();
        return $db->table('v_popular_destination')
            ->where(['id' => $id])->get()->getRow();
    }

    public static function getRateByDestinationId($id)
    {
        $db = \Config\Database::connect();
        return $db->table('v_rate_review')
            ->where(['destination_id' => $id])->get()->getResult();
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

    public static function getReviewSummary($id)
    {
        $db = db_connect();
        return $db->query('SELECT' .
            '(SELECT COUNT(id) FROM rate_review WHERE rate = 1 AND rate_review.destination_id = r.destination_id) AS one, ' .
            '(SELECT COUNT(id) FROM rate_review WHERE rate = 2 AND rate_review.destination_id = r.destination_id) AS two, ' .
            '(SELECT COUNT(id) FROM rate_review WHERE rate = 3 AND rate_review.destination_id = r.destination_id) AS three, ' .
            '(SELECT COUNT(id) FROM rate_review WHERE rate = 4 AND rate_review.destination_id = r.destination_id) AS four, ' .
            '(SELECT COUNT(id) FROM rate_review WHERE rate = 5 AND rate_review.destination_id = r.destination_id) AS five, ' .
            '(SELECT COUNT(id) FROM rate_review WHERE rate_review.destination_id = r.destination_id) AS total_review, ' .
            '(SELECT AVG(rate) FROM rate_review WHERE rate_review.destination_id = r.destination_id) AS average FROM rate_review AS r ' .
            'WHERE r.destination_id = ' . $id . ' LIMIT 1 ')->getRow();
    }

    public static function getBlog()
    {
        $db = \Config\Database::connect();
        return $db->table('blog')->select('blog.*, category.name as category_name')
            ->join('category', 'category.id = blog.category_id')
            ->where(['blog.deleted_at' => null])->orderBy('blog.id', 'DESC')->get('5', '0')->getResult();
    }

    public static function getGuide()
    {
        $model = new GuideModel();
        return $model->where(['deleted_at' => null])->get('3', '0')->getResult();
    }
}
