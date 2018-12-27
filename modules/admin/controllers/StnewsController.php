<?php
namespace app\modules\admin\controllers;
use app\common\services\UtilService;
use app\common\services\ConstantMapService;
use app\modules\admin\controllers\common\BaseAdminController;
use app\common\services\UrlService;

use app\common\services\DataHelper;
use app\models\member\Member;

use app\models\tmp\PyspiderZbnewTopic;
use app\models\news\News;
use app\models\news\NewsCate;
use app\models\news\NewsFav;
use app\models\news\STNews;
use app\models\news\ZBNews;
use app\models\tmp\TmpStnews;
use app\models\User;
/**
 * 商谈的新闻
 * @author Administrator
 *
 */
class StnewsController extends BaseAdminController
{
    public function actionIndex(){
     
        $mix_kw = trim( $this->get("mix_kw","" ) );
        $status = intval( $this->get("status",ConstantMapService::$status_default ) );       
        $p = intval( $this->get("p",1) );
        
        
        $query = STNews::find();
        $p = ( $p > 0 )?$p:1;
     
        if( $mix_kw ){          
            $where_title = [ 'LIKE','title','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
            $where_company = [ 'LIKE','pub_company','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
            $query->andWhere([ 'OR',$where_title,$where_company ]);
        }
    
        if( $status > ConstantMapService::$status_default ){
            $query->andWhere([ 'status' => $status ]);
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
            $user_mapping = DataHelper::getDicByRelateID( $list,User::className(),"author_id","uid",[ "nickname" ] );
             
            foreach( $list as $_item ){
                $tmp_user= $user_mapping[$_item['author_id']];
                $data[] = [
                    'id' => $_item['id'],
                    'title' => UtilService::encode( $_item['title'] ),
                    //'content' => UtilService::encode( $_item['content'] ),
                    'pub_company' => UtilService::encode( $_item['pub_company'] ),
                    'created_time' => UtilService::encode( $_item['created_time'] ),
                    'tags' => UtilService::encode( $_item['tags'] ),
                    'status' => UtilService::encode( $_item['status'] ),
                    'admin_user'=>$tmp_user['nickname']
                ];
            }
        }
        return $this->render('index',[
            'list' => $data,
            'search_conditions' => [
                'mix_kw' => $mix_kw,              
                'status' => $status,               
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
        $reback_url = UrlService::buildAdminUrl("/news/index");
        if( !$id ){
            return $this->redirect( $reback_url );
        }
      
        $query = STNews::find();
        $info = $query->where([ 'id' => $id ])->one();
        if( !$info ){
            return $this->redirect( $reback_url );
        }
        //收藏历史       
        $fav_log_list = NewsFav::find()->where(['newlist_id'=>$id,'type'=>'st'])->orderBy([ 'id' => SORT_DESC ])->asArray()->all();
        $fav_newlist_data =[];
       // var_dump($fav_log_list);exit();
        if($fav_log_list){
            //关联查询
            $member_mapping = DataHelper::getDicByRelateID($fav_log_list, Member::className(),"member_id","id", [ "nickname" ]);
            foreach ($fav_log_list as $fav_item){
                $tmp_member_info = isset($member_mapping[$fav_item['member_id']])?$member_mapping[$fav_item['member_id']]:[];
                
                $fav_newlist_data[] = [
                    'id'=>$fav_item['id'],
                    'created_time'=>$fav_item['created_time'],
                    'member_info'=>$tmp_member_info,
                ];
            }
        }
        
    
        return $this->render("info",[
            "info" => $info, 
            'fav_data'=>$fav_newlist_data
        ]);
    }
    
    public function actionSet(){
    	$nowDate = date("Y-m-d H:i:s");
        if( \Yii::$app->request->isGet ) {
            $id = intval( $this->get("id", 0) );
            
            $tmpnews_id = intval( $this->get("tmpnews_id", 0) );
            
            $query = STNews::find();
            $tmpnews = null;
            $info = [];
            if($tmpnews_id){//添加临时库中的新闻
                $tmpnews = TmpStnews::find()->where(['id'=>$tmpnews_id])->one();
                if(!$tmpnews){
                    return $this->renderJson([],"old参数错误",-1);
                }
                $info = [
                    'title'=>$tmpnews->title,
                    'pub_company'=>$tmpnews->flowname,
                    //'pub_time'=>$tmpnews->pubtime?$tmpnews->pubtime:$tmpnews->updatetime,
                	'pub_time'=>$nowDate,
                    'tags'=>'竞谈',
                    'expired_time'=>$nowDate,                    
                    'content'=>$tmpnews->content,                    
                ];
               
                
            }elseif ($id){//新闻修改
                $info = $query->where([ 'id' => $id ])->one();
            }else {//自建新闻
                $info = new STNews();
            }        
            
            return $this->render('set',[ 
                'info' => $info,
                'tmpnews_id'=>$tmpnews_id, 
                
            ]);
        }
    
        $id = intval( $this->post("id",0) );
     
        $title = trim( $this->post("title","") );
        $pub_company = trim( $this->post("pub_company","") );
        $expired_time = trim( $this->post("expired_time","") );
        $pub_time = trim( $this->post("pub_time","") );
        $content = trim( $this->post("content","") );       
        $tags = trim( $this->post("tags","") );
        $date_now = date("Y-m-d H:i:s");
        
        $tmpnews_id = intval($this->post('tmpnews_id',0));
        
       
        if( mb_strlen( $title,"utf-8" ) < 1 ){
            return $this->renderJSON([],"请输入符合规范的图书名称~~",-1);
        }
    
    
        if( mb_strlen( $pub_company ,"utf-8") < 3 ){
            return $this->renderJSON([],"请输入符合规范的发布名称~~",-1);
        }
    
        if( mb_strlen( $expired_time ,"utf-8") < 3 ){
            return $this->renderJSON([],"请输入符合规范的过期时间~~",-1);
        }
        if( mb_strlen( $pub_time ,"utf-8") < 3 ){
            return $this->renderJSON([],"请输入符合规范的发布时间~~",-1);
        }
        if( mb_strlen( $content,"utf-8" ) < 10 ){
            return $this->renderJSON([],"请输入新闻描述，并不能少于10个字符~~",-1);
        } 
        if( mb_strlen( $tags,"utf-8" ) < 1 ){
            return $this->renderJSON([],"请输入图书标签，便于搜索~~",-1);
        }
    
        
        $info = [];
        if( $id ){
            $info = STNews::findOne(['id' => $id]);
        }
        if( $info ){
            $model_book = $info;
        }else{
            $model_book = new STNews();
            $model_book->status = 1;
            $model_book->created_time = $date_now;
        }    
        
        
        $model_book->title= $title;
        $model_book->pub_company = $pub_company;
        $model_book->expired_time = $expired_time;
        $model_book->content = $content;         
        $model_book->tags = $tags;
        $model_book->pub_time = $pub_time;
        $model_book->updated_time = $date_now;  
        //作者
        $model_book->author_id = $this->current_user['uid'];
        $succ = $model_book->save( 0 );
        
        if($tmpnews_id && $succ){//更新中间库的状态
            $tmp = TmpStnews::find()->where(['id'=>$tmpnews_id])->one();
            $tmp->statu = 2;
            $tmp->save(0);
        }
        
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
       
        $query = STNews::find();
        $info =$query->where([ 'id' => $id ])->one();
        if( !$info ){
            return $this->renderJSON([],"指定书籍不存在~~",-1);
        }
    
        switch ( $act ){
            case "remove":
                $info->status = 0;
                break;
            case "recover":
                $info->status = 1;
                break;
        }
        $info->updated_time = date("Y-m-d H:i:s");
        $info->update( 0 );
        return $this->renderJSON( [],"操作成功~~" );
    }

    
    
    
   

}

