<?php
namespace app\modules\admin\controllers; 
use app\common\services\UtilService;
use app\common\services\ConstantMapService;
use app\modules\admin\controllers\common\BaseAdminController;
use app\common\services\UrlService;

use app\common\services\DataHelper;
use app\models\equipment\EquipmentClassInfoExtra;
use app\models\member\MemberExtra;
 
/**
 * 计划管理
 * @author Administrator
 *
 */
class PlansController extends BaseAdminController
{
    public function actionIndex(){
        //多用户的话，要只能查自己的，单这里是只考虑本单位，所有都能查到
        $mix_kw = trim( $this->get("mix_kw","" ) );
        $statu = intval( $this->get("statu",ConstantMapService::$status_default ) );
        
        $p = intval( $this->get("p",1) );
     
        $query = EquipmentClassInfoExtra::find();
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
        
        $data = [];
    
        if( $list ){
            $user_mapping = DataHelper::getDicByRelateID( $list,MemberExtra::className(),"user_id","id",[ "nickname" ] );
            
            foreach( $list as $_item ){
                $tmp_user= $user_mapping[$_item['user_id']];
                $data[] = [
                    'id' => $_item['id'],
                    'investment_plan' => UtilService::encode( $_item['investment_plan'] ),
                     'name' => UtilService::encode( $_item['name'] ),
                    'equipment_model' => UtilService::encode( $_item['equipment_model'] ),
                    'unit' => UtilService::encode( $_item['unit'] ),
                    'material_code' => UtilService::encode( $_item['material_code'] ),
                    'price' => UtilService::encode( $_item['price'] ),
                    'produce_company' => UtilService::encode( $_item['produce_company'] ),
                    'produce_date' => UtilService::encode( $_item['produce_date'] ),
                    'created_time' => UtilService::encode( $_item['created_time'] ), 
                    'statu' => UtilService::encode( $_item['statu'] ),
                    'created_user'=>$tmp_user['nickname']
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
        $reback_url = UrlService::buildAdminUrl("/plans/index");
        if( !$id ){
            return $this->redirect( $reback_url );
        }
     
        $query = EquipmentClassInfoExtra::find();
        $info = $query->where([ 'id' => $id ])->one();
        if( !$info ){
            return $this->redirect( $reback_url );
        }
        $data[] = $info;
        $user_mapping = DataHelper::getDicByRelateID( $data,MemberExtra::className(),"user_id","id",[ "nickname" ] );
         
        return $this->render("info",[
            "info" => $info, 
            "username"=>$user_mapping[$info['user_id']]['nickname']            
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
            
            return $this->render('set',[ 
                'info' => $info, 
            ]);
        }
    
        $id = intval( $this->post("id",0) );      
        $investment_plan = trim( $this->post("investment_plan","") );
        $name = trim( $this->post("name","") );
        $equipment_model = trim( $this->post("equipment_model","") );
        $unit = trim( $this->post("unit","") );
        $material_code = trim( $this->post("material_code","") );       
        $price = trim( $this->post("price","") );
        $produce_company = trim( $this->post("produce_company","") );
        $procure_company = trim( $this->post("procure_company","") );
        $procure_tel = trim( $this->post("procure_tel","") );
        $equip_params = trim( $this->post("equip_params","") );
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
    
        
        $info = [];
        if( $id ){
            $info = EquipmentClassInfoExtra::findOne(['id' => $id]);
        }
        if( $info ){
            $e_model = $info;
        }else{
            $e_model = new EquipmentClassInfoExtra();
            $e_model->status = 1;
            $e_model->created_time = $date_now;
        }    
         
        $e_model->investment_plan = $investment_plan;
        $e_model->name = $name;
        $e_model->equipment_model = $equipment_model;
        $e_model->unit =  $unit;
        $e_model->material_code = $material_code;
        $e_model->price = $price;
        $e_model->produce_company = $produce_company;
        $e_model->procure_company = $procure_company;
        $e_model->procure_tel  =  $procure_tel;
        $e_model->equip_params = $equip_params;
        $e_model->beizhu = $beizhu;
      
        //作者
        $e_model->user_id = $this->current_user['id'];
        $succ = $e_model->save( 0 );
        
        return $this->renderJSON([],"操作成功~~");
    }
    
    public function actionOps(){
        if( !\Yii::$app->request->isPost ){
            return $this->renderJSON( [],ConstantMapService::$default_syserror,-1 );
        }
    
        $id = $this->post('id',[]);
        $act = trim($this->post('act',''));
        if( !$id ){
            return $this->renderJSON([],"请选择要操作的账号~~",-1);
        }
    
        if( !in_array( $act,['remove','recover' ])){
            return $this->renderJSON([],"操作有误，请重试~~",-1);
        }
      
        $query = EquipmentClassInfoExtra::find();
        $info =$query->where([ 'id' => $id ])->one();
        if( !$info ){
            return $this->renderJSON([],"指定计划不存在~~",-1);
        }
    
        switch ( $act ){
            case "remove":
                
                $info->statu = 0;
                $info->updated_time = date("Y-m-d H:i:s");
                $info->update( 0 );               
                break;
            case "recover":
                $info->statu = 1;
                $info->updated_time = date("Y-m-d H:i:s");
                $info->update( 0 );
                break;
        }
       
        return $this->renderJSON( [],"操作成功~~" );
    } 
   

}

