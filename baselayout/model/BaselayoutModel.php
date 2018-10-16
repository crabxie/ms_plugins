<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/10/17
 * Time: 上午4:12
 */

namespace plugins\baselayout\model;

use libs\asyncme\Service;

class BaselayoutModel
{

    protected $service = null;

    protected $db = null;

    protected $cache = null;

    protected $redis = null;

    protected $base_layout_table = 'base_layout';

    public function __construct(Service $service)
    {
        $this->service = $service;
        $this->db = $service->getDb();
        $this->cache = $service->getCache();
        $this->redis = $service->getRedis();
        if(method_exists($this,'init')) {
            call_user_func([$this,'init']);
        }
    }

    public function baseLayoutLists($where=[],$order=[])
    {
        $obj = $this->db->table($this->base_layout_table);
        $obj=$obj->where($where);
        if ($order) {
            if(is_array($order[0])) {
                foreach($order as $val) {
                    $obj = $obj->orderBy($val[0],$val[1]);
                }
            } else {
                $obj = $obj->orderBy($order[0],$order[1]);
            }
        }

        $res = $obj->get();
        if ($res) {
            reset($res);
            $res = json_decode(json_encode($res),true);
        }
        return $res;
    }

}