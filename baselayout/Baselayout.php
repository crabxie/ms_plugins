<?php
/**
 * Created by PhpStorm.
 * User: xiequan
 * Date: 2018/7/15
 * Time: 上午1:31
 */

namespace plugins\baselayout;

use libs\asyncme\Plugins as Plugins;
use libs\asyncme\RequestHelper as RequestHelper;
use libs\asyncme\ResponeHelper as ResponeHelper;
use \Slim\Http\UploadedFile;

require  dirname(__FILE__).'/model/BaselayoutModel.php';


class Baselayout extends Plugins
{


    public function IndexAction(RequestHelper $req,array $preData)
    {
        $status = true;
        $mess = '成功';
        $data = [
            'test'=>'what the hell',
            'req'=>$req,
        ];

        return new ResponeHelper($status,$mess,$data);
    }


    /**
     * @name 获取列表
     * @param RequestHelper $req
     * @param array $preData
     * @return ResponeHelper
     * @priv ask
     */
    public function listsAction(RequestHelper $req,array $preData)
    {
        try{
            $title = '基础布局';
            $request_plugin_id = $req->query_datas['pl_id'];
            if(!$request_plugin_id) {
                throw new \Exception('参数不正确');
            }

            $baselayout_model = new model\BaselayoutModel($this->service);
            $where = ['status'=>1];
            $info = $baselayout_model->baseLayoutLists($where);
            $status = true;
            $mess = '成功';
            $data = [
                'title'=>$title,
                'status'=>$status,
                'info'=>$info,
            ];
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $status = false;
            $mess = '失败';
            $data = [
                'title'=>$title,
                'status'=>$status,
                'mess'=>$mess,
                'error'=>$error,
            ];
        }


        return new ResponeHelper($status,$mess,$data,'template','lists',__CLASS__);

    }
}