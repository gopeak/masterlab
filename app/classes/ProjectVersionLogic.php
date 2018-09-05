<?php
namespace main\app\classes;

use main\app\model\project\ProjectVersionModel;

class ProjectVersionLogic
{
    public function getVersionByFilter($project_id, $name = '', $page = 1, $pageSize = 30)
    {
        $model = new ProjectVersionModel();
        $table = $model->getTable();

        $where = " WHERE `project_id`=$project_id AND `name` LIKE '%{$name}%'";
        $start = $pageSize * ($page - 1);
        $limit = " LIMIT $start, $pageSize";
        $order = " ORDER BY id DESC";

        $sqlCount = "SELECT count(*) as cc FROM  {$table} {$where}";
        $count = $model->db->getOne($sqlCount);

        $sql = "SELECT * FROM {$table} {$where}";
        $sql .= $order . $limit;

        $arr = $model->db->getRows($sql);
        return [true, $arr, $count];
    }
}