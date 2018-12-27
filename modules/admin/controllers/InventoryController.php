<?php
namespace app\modules\admin\controllers; 
use app\common\services\UtilService;
use app\common\services\ConstantMapService;
use app\modules\admin\controllers\common\BaseAdminController;
use app\common\services\UrlService;

use app\common\services\DataHelper;
use app\models\member\Member; 
use app\models\User;
use app\models\equipment\EquipmentClassInfo;
use app\models\equipment\EquipmentInventory;
use app\models\equipment\EquipmentInventoryRecord;
use app\models\equipment\EquipmentInventoryAddr;
use app\models\equipment\EquipmentInventoryExtra;
use app\models\equipment\EquipmentClassInfoExtra;
use app\models\equipment\EquipmentInventoryAddrExtra;
use app\models\equipment\EquipmentInventoryRecordExtra;
/**
 * 库存管理
 * @author Administrator
 *
 */
class InventoryController extends BaseAdminController
{
    /**
     * 库存列表
     * @return string
     */
    public function actionIndex(){
        //未调试查询功能
        $mix_kw = trim( $this->get("mix_kw","" ) );
        $statu = intval( $this->get("statu",ConstantMapService::$status_default ) );
        
        $p = intval( $this->get("p",1) );
     
        $query = EquipmentInventoryExtra::find();
        $p = ( $p > 0 )?$p:1;
     
        if( $mix_kw ){          
            $where_name = [ 'LIKE','name','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
            $where_model = [ 'LIKE','equipment_model','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
            $query->andWhere([ 'OR',$where_name,$where_model ]);
        }
    
        if( $statu > ConstantMapService::$status_default ){
            $query->andWhere([ 'statu' => $statu ]);
        }
     
    
        //分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
        //60,60 ~ 11,10 - 1
        $total_res_count = $query->count();
        $total_page = ceil( $total_res_count / $this->page_size );
        //如果p>total_page
        if($p > $total_page){
            $p = $total_page;
        }
    
        $list = $query->orderBy([ 'id' => SORT_DESC ])
        ->offset( ( $p - 1 ) * $this->page_size )
        ->limit($this->page_size)
        ->all( );
        
        //库存地点
        $addrs = EquipmentInventoryAddr::find()->all();
        $addr_map = UtilService::Objects2Map($addrs,'id','factory');
     
        $data = [];
    
        if( $list ){
            $class_mapping = DataHelper::getDicByRelateID( $list,EquipmentClassInfoExtra::className(),"classinfo_id","id",[ "name","equipment_model","produce_company" ] );
            
            foreach( $list as $_item ){
                $tmp_class= $class_mapping[$_item['classinfo_id']];
                $addr_id = $_item['inventory_addr'];
                $data[] = [
                    'id' => $_item['id'],
                    'equipment_name' => UtilService::encode( $tmp_class['name']),
                    'equipment_model' => UtilService::encode($tmp_class['equipment_model']),
                    'total' => UtilService::encode( $_item['total'] ),
                    'inventory_addr' => UtilService::encode( $addr_map[$addr_id] ), 
                    'produce_company' => UtilService::encode( $tmp_class['produce_company'] ), 
                    'updated_time' => UtilService::encode( $_item['updated_time'] ), 
                    'beizhu' => UtilService::encode( $_item['beizhu'] ), 
                ];
            }
        }
        return $this->render('index',[
            'list' => $data,
            'search_conditions' => [
                'mix_kw' => $mix_kw,                 
                'statu' => $statu,
                
            ],
            'status_mapping' => ConstantMapService::$status_mapping,             
            'pages' => [
                'total_count' => $total_res_count,
                'page_size' => $this->page_size,
                'total_page' => $total_page,
                'p' => $p
            ]
             
        ]);
    }
   
    public function actionInfo(){
        $id = intval( $this->get("id", 0) );
        $reback_url = UrlService::buildAdminUrl("/inventory/index");
        if( !$id ){
            return $this->redirect( $reback_url );
        }
     
        $query = EquipmentInventoryExtra::find();
        $info = $query->where([ 'id' => $id ])->one();
        if( !$info ){
            return $this->redirect( $reback_url );
        }
        //关联查询
        $data[] = $info;
        $class_mapping = DataHelper::getDicByRelateID( $data,EquipmentClassInfoExtra::className(),"classinfo_id","id",[ "investment_plan","name","equipment_model",
                "produce_company","produce_date","procure_company","procure_tel","equip_params","material_code","price" ] );
        //库存变更记录
        $inventory_records = EquipmentInventoryRecord::find()->where(['inventory_id'=>$info->id])->all(); 
        //库存地点
        $addrs = EquipmentInventoryAddrExtra::find()->all();
        $addr_map = UtilService::Objects2Map($addrs,'id','factory');
        $info->inventory_addr = $addr_map[$info->inventory_addr];
        
        return $this->render("info",[
            "info" => $info, 
            "class_model"=>$class_mapping[$info['classinfo_id']]  ,
            'records'=>$inventory_records
        ]);
    }
    
    public function actionSet(){
        if( \Yii::$app->request->isGet ) {
            $id = intval( $this->get("id", 0) ); 
            $query = EquipmentClassInfoExtra::find();
            
            $info = [];
           if ($id){//新闻修改
                $info = $query->where([ 'id' => $id ])->one();
            }else {//新建
                $info = new EquipmentClassInfoExtra();
            }        
           
            //计划信息
            $plans = EquipmentClassInfoExtra::find()->where(['statu'=>1])->all();
            
            //库存地点
            $addrs  = EquipmentInventoryAddrExtra::find()->all();
            
            return $this->render('set',[ 
                'info' => $info, 
                'plans'=>$plans,
                'addrs'=>$addrs
            ]);
        }
    
        $plan = intval( $this->post("plan",0) );      
        $updateNum = trim( $this->post("updateNum","") );        
        $inventory_addr = intval( $this->post("inventory_addr",0) );        
        $receiver = trim( $this->post("ops_user","") );        
        $receive_time = trim( $this->post("ops_time","") );    
        $beizhu = trim( $this->post("beizhu","") ); 
        $date_now = date("Y-m-d H:i:s");
        
//         $file_key = trim($this->post('file_key',''));
       
//         $tmpnews_id = intval($this->post('tmpnews_id',0));
         
//         if( mb_strlen( $title,"utf-8" ) < 1 ){
//             return $this->renderJSON([],"请输入符合规范的图书名称~~",-1);
//         } 
//         if( mb_strlen( $pub_company ,"utf-8") < 3 ){
//             return $this->renderJSON([],"请输入符合规范的发布名称~~",-1);
//         }
    
//         if( mb_strlen( $expired_time ,"utf-8") < 3 ){
//             return $this->renderJSON([],"请输入符合规范的过期时间~~",-1);
//         }
//         if( mb_strlen( $pub_time ,"utf-8") < 3 ){
//             return $this->renderJSON([],"请输入符合规范的发布时间~~",-1);
//         }
//         if( mb_strlen( $content,"utf-8" ) < 10 ){
//             return $this->renderJSON([],"请输入新闻描述，并不能少于10个字符~~",-1);
//         } 
//         if( mb_strlen( $tags,"utf-8" ) < 1 ){
//             return $this->renderJSON([],"请输入图书标签，便于搜索~~",-1);
//         }
    
        $inventory = EquipmentInventoryExtra::find()->where(['classinfo_id'=>$plan,'inventory_addr'=>$inventory_addr])->one();
        
        if(!$inventory){//库存不存在，就新建
            $inventory = new EquipmentInventoryExtra();            
            $inventory->classinfo_id = $plan;
            $inventory->total = $updateNum;
            $inventory->inventory_addr = $inventory_addr;
            $inventory->user_id =  $this->current_user['uid'];                      
        }else{
            //添加
            $inventory->total = $inventory->total + $updateNum;            
        }
        $inventory->updated_time =  $date_now;
        $inventory->beizhu = $beizhu;
        
        if($inventory->save( 0 ) ){
            //添加库存变更记录
            $record = New EquipmentInventoryRecordExtra();
            $record->inventory_id = $inventory->id;
            $record->updateNum = $updateNum;
            $record->ops_user = $receiver;
            $record->ops_time = $receive_time;
            $record->user_id =  $this->current_user['uid'];    
            $record->created_time = $date_now;
            $record->beizhu = "添加库存";   
            $record->save(0);
        } 
        
        return $this->renderJSON([],"操作成功~~");
    }
    
   //json
    public function actionGetdata(){
        $arr = [
            "code"=> 0,
            "msg"=> "",
            "count"=> 100,
            "data"=> [[
                "userName"=> "测试用户1",
                "invent_id"=> "1",
                "deptName"=> "测试部门1"
            ], [
                "userName"=> "测试用户2",
                "invent_id"=> "2",
                "deptName"=> "测试部门1"
            ], [
                "userName"=> "测试用户3",
                "invent_id"=> "170003",
                "deptName"=> "测试部门2"
            ], [
                "userName"=> "测试用户4",
                "invent_id"=> "170004",
                "deptName"=> "测试部门2"
            ], [
                "userName"=> "测试用户5",
                "invent_id"=> "170005",
                "deptName"=> "测试部门3"
            ]]
        ];
        

        return $this->renderData($arr);
        
        
        
    }

}

