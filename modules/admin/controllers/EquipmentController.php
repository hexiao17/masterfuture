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

use app\models\Organize;
use app\models\equipment\EquipmentUseLog;
use app\models\equipment\EquipmentInventoryRecord;
use app\models\equipment\EquipmentInventory;
use yii\base\Exception;
use app\models\equipment\EquipmentDetailExtra;
use app\models\equipment\EquipmentClassInfoExtra;
use app\models\OrganizeExtra;
use app\models\equipment\EquipmentInventoryRecordExtra;
use app\models\equipment\EquipmentInventoryExtra;
use app\models\equipment\EquipmentUseLogExtra;
/**
 * 设备管理
 * @author Administrator
 *
 */
class EquipmentController extends BaseAdminController
{
    public function actionIndex(){
        //多用户的话，要只能查自己的，单这里是只考虑本单位，所有都能查到
        $mix_kw = trim( $this->get("mix_kw","" ) );
        $statu = intval( $this->get("statu",ConstantMapService::$status_default ) );
        
        $p = intval( $this->get("p",1) );
     
        $query = EquipmentDetailExtra::find();
        $p = ( $p > 0 )?$p:1;
     
        if( $mix_kw ){          
            $where_qrcode = [ 'LIKE','qrcode','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
            $where_org = [ 'LIKE','org_id','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
            $query->andWhere([ 'OR',$where_qrcode,$where_org ]);
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
        
        $data = [];
    
        if( $list ){
           
            $class_mapping = DataHelper::getDicByRelateID( $list,EquipmentClassInfoExtra::className(),"classinfo_id","id",[ "name","equipment_model","produce_company","produce_date" ] );
            $org_mapping = DataHelper::getDicByRelateID($list, OrganizeExtra::className(), "org_id", "id",["name"]);
           // $now_use_mapping = DataHelper::getDicByRelateID($list, EquipmentUseLog::className(), "now_use", "id",["use_name","created_time"]);
            $record_mapping = DataHelper::getDicByRelateID($list, EquipmentInventoryRecordExtra::className(), "invent_record_id", "id",['ops_user','ops_time']);
            foreach( $list as $_item ){
                
                $tmp_class = $class_mapping[$_item['classinfo_id']];
                $tmp_org = $org_mapping[$_item['org_id']];
             //   $tmp_use = $now_use_mapping[$_item['now_use']];
                $tmp_record = $record_mapping[$_item['invent_record_id']];
                $data[] = [
                    'id' => $_item['id'],
                    'qrcode' => UtilService::encode( $_item['qrcode'] ),
                    
                    'class_name'=>UtilService::encode($tmp_class['name']),
                    'class_model'=>UtilService::encode($tmp_class['equipment_model']),
                    'class_produce_company'=>UtilService::encode($tmp_class['produce_company']),
                    'class_produce_date'=>UtilService::encode($tmp_class['produce_date']),
                    'org_name'=>UtilService::encode($tmp_org['name']),
                    'use_user'=>'1',//UtilService::encode($tmp_use['use_name']),
                    'use_time'=>'2',//UtilService::encode($tmp_use['created_time']),
                    'record_user'=>UtilService::encode($tmp_record['ops_user']),
                    'record_time'=>UtilService::encode($tmp_record['ops_time']),
                    
                    'equip_params' => UtilService::encode( $_item['equip_params'] ),
                    'beizhu' => UtilService::encode( $_item['beizhu'] ),
                     
                    'statu' => UtilService::encode( $_item['statu'] ), 
                ];
            }
        }
        return $this->render('index',[
            'list' => $data,
            'search_conditions' => [
                'mix_kw' => $mix_kw,                 
                'statu' => $statu,
                
            ],
            'status_mapping' => ConstantMapService::$equipment_statu_mapping,             
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
        $reback_url = UrlService::buildAdminUrl("/equipment/index");
        if( !$id ){
            return $this->redirect( $reback_url );
        }
     
        $query = EquipmentDetailExtra::find();
        $info = $query->where([ 'id' => $id ])->one();
        if( !$info ){
            return $this->redirect( $reback_url );
        }
        //查询关联信息
        $class_info = EquipmentClassInfoExtra::find()->where(['id'=>$info->classinfo_id])->one();
        $org_info = OrganizeExtra::find()->where(['id'=>$info->org_id])->one();
        $invent_records = EquipmentInventoryRecordExtra::find()->where(['id'=>$info->invent_record_id])->all();
        
        if(!$class_info || !$org_info || !$invent_records){
            return $this->redirect( $reback_url );
        }
        
        //查询本设备的使用记录
        $use_logs = EquipmentUseLog::find()->where(['equip_detail_id'=>$info->id])->all();
         
        return $this->render("info",[
            "equip_detail" => $info, 
            "class_info"=>$class_info,
            "org_info"=>$org_info,
            "invent_records"=>$invent_records,
            "use_logs"=>$use_logs          
        ]);
    }
    
    public function actionSet(){
        if( \Yii::$app->request->isGet ) {
            $id = intval( $this->get("id", 0) ); 
            $query = EquipmentDetailExtra::find();
            
            $info = [];
           if ($id){//修改
                $info = $query->where([ 'id' => $id ])->one();
            }else {//新建
                $info = new EquipmentClassInfoExtra();
            }        
            
            return $this->render('set',[ 
                'info' => $info, 
            ]);
        }
        
        $invent_id = intval( $this->post("invent_id",0) );
        $organize = intval( $this->post("organize",0) );
       
        $use_name = trim( $this->post("use_name","") );
        $receiver = trim( $this->post("receiver","") );       
        $send_name = trim( $this->post("send_name","") ); 
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
    
        
       //事务
        //变更库存，生成库存记录
        //生成使用记录
        //保存设备详细信息
        $inventory = EquipmentInventoryExtra::find()->where(['id'=>$invent_id])->one();
        $class_info = EquipmentClassInfoExtra::find()->where(['id'=>$inventory->classinfo_id])->one();
        
        $transaction = \Yii::$app->db->beginTransaction();
        try {
         
            //库存变更
            $invent_record = new EquipmentInventoryRecord();
            $invent_record->inventory_id = $invent_id;
            $invent_record->updateNum = -1;
            $invent_record->ops_user = $send_name;
            $invent_record->ops_time = $date_now;
            $invent_record->user_id =  $this->current_user['uid'];
            $invent_record->created_time = $date_now;
            $invent_record->beizhu = "发放";
            if($invent_record->save(0)){
                $inventory->total = $inventory->total-1;
                $inventory->updated_time = $date_now;
                $inventory->save( 0 );
            }
            //生成设备  
            $e_model = new EquipmentDetailExtra();
            $e_model->qrcode =  md5(uniqid(mt_rand(), true)); 
            $e_model->qr_code_url = UrlService::buildMUrl('/equip/info',['qrcode'=>$e_model->qrcode]);
            $e_model->classinfo_id = $class_info->id;
            $e_model->org_id = $organize;
            $e_model->statu = 10;
            $e_model->beizhu = $beizhu;
            $e_model->equip_params = $class_info->equip_params; 
            $e_model->invent_record_id = $invent_record->attributes['id'];
            
            if($e_model->save()){
                //添加使用记录
                $use_record = new EquipmentUseLogExtra();
                $use_record->equip_detail_id = $e_model->id;
                $use_record->use_name = $use_name;
                $use_record->receiver = $receiver;
                $use_record->user_id =  $this->current_user['uid'];
                $use_record->created_time = $date_now; 
                $use_record->relate_userid = 0;
                $use_record->beizhu = "首次";
                if(!$use_record->save()){
                     var_dump($use_record->getErrors());
                    throw new Exception("使用记录添加产生异常");
                }
            }else{
                //打印错误
               // var_dump($e_model->getErrors());
               throw new Exception("设备添加产生异常");
            }
           
            $transaction->commit();
        } catch (Exception $e) {
           $transaction->rollBack();
           //记录错误信息 
          return $this->renderJSON([],"系统异常~~". $e->getMessage(),-1);           
        }      
        
        return $this->renderJSON([],"操作成功~~");
    }
    
    
    
    
    /**
     *  
     * 操作方法需要大改
     * ，应该不需要设置状态
     * 
     * @return  
     */
    public function actionOps(){
        if( !\Yii::$app->request->isPost ){
            return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
        }
    
        $id = $this->post('id',[]);
        $act = trim($this->post('act',''));
        if( !$id ){
            return $this->renderJSON([],"请选择正确的设备~~",-1);
        }
    
        if( !in_array( $act,['recover','repair','scrap','recycling' ])){
            return $this->renderJSON([],"操作有误，请重试~~",-1);
        }
      
        $query = EquipmentDetailExtra::find();
        $info =$query->where([ 'id' => $id ])->one();
        if( !$info ){
            return $this->renderJSON([],"指定设备不存在~~",-1);
        }
    
        switch ( $act ){
            
            case "recover":  //恢复正常
                $info->statu = 1;
                $info->updated_time = date("Y-m-d H:i:s");
                $info->update( 0 );
                break;
            case "repair"://维修，跳转到                
                $info->statu = 0;
                $info->updated_time = date("Y-m-d H:i:s");
                $info->update( 0 );
                break;
            case "remove":
                
                $info->statu = 0;
                $info->updated_time = date("Y-m-d H:i:s");
                $info->update( 0 );
                break;
            case "remove":
                
                $info->statu = 0;
                $info->updated_time = date("Y-m-d H:i:s");
                $info->update( 0 );
                break;
        }
       
        return $this->renderJSON( [],"操作成功~~" );
    } 
    
    //json
    public function actionGetdata(){
        $arr = [
            "code"=> 0,
            "msg"=> "",
            "count"=> 100,
            "data"=> [[
                "userName"=> "测试用户1",
                "equip_id"=> "21",
                
            ], [
                "userName"=> "测试用户2",
                "equip_id"=> "2",
               
            ], [
                "userName"=> "测试用户3",
                "equip_id"=> "170003",
                
            ], [
                "userName"=> "测试用户4",
                "equip_id"=> "170004",
                
            ], [
                "userName"=> "测试用户5",
                "equip_id"=> "170005",
               
            ]]
        ];
        
        
        return $this->renderData($arr);
        
        
        
    }
    


}

