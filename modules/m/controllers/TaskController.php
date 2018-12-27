<?php

namespace app\modules\m\controllers;
 
use app\common\services\DataHelper;
 
use app\common\services\UtilService;
use app\common\services\ConstantMapService;
use app\common\services\UrlService;
 
use app\models\masterfuture\MasterfutureTask;
 
use app\models\masterfuture\MasterfutureCategory;
 use app\modules\m\controllers\common\BaseMController;
use app\models\member\MemberExtra;
class TaskController extends BaseMController
{
	 
   
    
	 //public  $layout = "layout_index";
   //任务首页
    public function actionIndex(){
        $user_id = $this->current_user['id'];
	    //---------查询置顶任务（<=5条）--------------------------------------
	    //未完成的，置顶的，5个任务
        $query = MasterfutureTask::find()->where(['weight'=>90])->andWhere(['statu'=>0,'user_id'=>$user_id])->orderBy(['weight' => SORT_DESC ])->limit(5);
	    $list_top5 = $query->all();
		$data5 = [];
		if( $list_top5 ){
			//关联查询
			$member_mapping = DataHelper::getDicByRelateID($list_top5, MemberExtra::className(), "user_id",'id', ['nickname','avatar']);
			$cate_mapping = DataHelper::getDicByRelateID($list_top5, MasterfutureCategory::className(), "cate_id", 'id',['name']);
			foreach( $list_top5 as $_item ){
				$user = isset($member_mapping[$_item['user_id']])?$member_mapping[$_item['user_id']]:['nickname'=>"无昵称"];
				$cate = isset($cate_mapping[$_item['cate_id']])?$cate_mapping[$_item['cate_id']]:['name'=>"无分类"];
				$data5[] = [
						'id' => $_item['id'],
						'title' => UtilService::cutstr(UtilService::encode( $_item['title'] ),40),
						'task_desc' => UtilService::cutstr(UtilService::encode( $_item['task_desc'] ),100),
						'username'=>$user['nickname'],
				        'avatar'=>$user['avatar'],
						'user_id'=>$_item['user_id'],
						'end_date'=>UtilService::str2DateFormate($_item['end_date'], 'Y-m-d'),
						'created_time'=>UtilService::str2DateFormate($_item['created_time'], 'Y-m-d'),
						'isShare'=>$_item['isShare'] ,
				    'cate_name'=>UtilService::cutstr(UtilService::encode( $cate['name'] ),10) 
				];
			}
		}
		 
		//-----------默认当天任务---------------------------------------	
		//关键词	 
		$kw = trim( $this->get("kw","") );
		
		//排序规则
		$sort_field = trim( $this->get("sort_field","default") );
		$sort = trim( $this->get("sort","") );
		$sort = in_array(  $sort,['asc','desc'] )?$sort:'desc';
		
		//状态
		$statu = intval($this->get('statu',0));
		//分组
		$group = intval($this->get("group",1));
		//分页
		$p = intval( $this->get("p",1) );
		$p = ( $p > 0 )?$p:1;
		//默认显示条数
		$pageSize =10;
		//
		$query = MasterfutureTask::find()->where(['statu'=>$statu,'user_id'=>$user_id]);
        
		if($kw){
			  $where_title = ['LIKE','title','%'.strtr($kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
			  $where_content = ['LIKE','task_desc','%'.strtr($kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
			  $query->andWhere(['OR',$where_title,$where_content]);
		}
		if($group >=1 && $group <=100){
			$query->andWhere(['task_group'=>$group]);
		}
		
		//分页功能
		$total_res_count = $query->count();
		$total_page = ceil($total_res_count/$pageSize);
		
		$list = $query->orderBy(['id'=>SORT_DESC])
			->offset(($p-1)*$pageSize)
			->limit($pageSize)
			->all();
		 
		$data = [];
		if( $list ){
			//关联查询
		    $member_mapping = DataHelper::getDicByRelateID($list, MemberExtra::className(), "user_id",'id', ['nickname','avatar']);
		    $cate_mapping = DataHelper::getDicByRelateID($list, MasterfutureCategory::className(), "cate_id", 'id',['name']);
			foreach( $list as $_item ){
				$user = isset($member_mapping[$_item['user_id']])?$member_mapping[$_item['user_id']]:['nickname'=>"无昵称"];
				$cate = isset($cate_mapping[$_item['cate_id']])?$cate_mapping[$_item['cate_id']]:['name'=>"无分类"];
				$data[] = [
						'id' => $_item['id'],
						'title' => UtilService::cutstr(UtilService::encode( $_item['title'] ),40),
						'task_desc' => UtilService::cutstr(UtilService::encode( $_item['task_desc'] ),100),
					 	'username'=>$user['nickname'],
				        'avatar'=>$user['avatar'],
						'user_id'=>$_item['user_id'],
						'end_date'=>UtilService::str2DateFormate($_item['end_date'], 'Y-m-d'),
						'created_time'=>UtilService::str2DateFormate($_item['created_time'], 'Y-m-d'),
				        'isShare'=>$_item['isShare'] ,
				    'cate_name'=>UtilService::cutstr(UtilService::encode( $cate['name'] ),10),
				];
			}
		}
		
		$search_conditions = [
				'kw' => $kw,
				'sort_field' => $sort_field,
				'sort' => $sort,
				'group'=>$group
		];  
		 
		return $this->render($this->isWechat?"mini_index":"index",[
				'list_top5'=>$data5,
				'list' => $data,
				'search_conditions' => $search_conditions,
				'pages' => [
						'total_count' => $total_res_count,
						'page_size' => $pageSize,
						'total_page' => $total_page,
						'p' => $p
				]
		]); 
        
    }
    
    /*
     * 搜索
     * 默认按发布时间排序
     */
    private function getSearchData( $page_size = 1 ){
    	$kw = trim( $this->get("kw","") );
    	//default = id
    	$sort_field = trim( $this->get("sort_field","default") );
    	$sort = trim( $this->get("sort","") );
    	$sort = in_array(  $sort,['asc','desc'] )?$sort:'desc';
    	$group = intval($this->get("group",1));    	
    	$statu = intval($this->get("statu",0));
    	
    	$p = intval( $this->get("p",1 ) );
    	if( $p < 1 ){
    		$p = 1;
    	} 
    	//查询代办
    	$query = MasterfutureTask::find()->where([ 'statu' => $statu , 'task_group'=>$group])->andWhere(['<','weight',90]);
    	
    	//模糊查询，目前没有索引，只匹配标题,tags
    	if( $kw ){
    		$where_title = [ 'LIKE','title','%'.strtr($kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
    		$where_desc = [ 'LIKE','task_desc','%'.strtr($kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
    		$query->andWhere([ 'OR',$where_title,$where_desc ]);
    	}
    
    	switch ( $sort_field ){
    		case "weight":
    		case "created_time":
    		case "end_time":
    			$query->orderBy( [  $sort_field => ( $sort == "asc")?SORT_ASC:SORT_DESC,'id' => SORT_DESC ] );
    			break;
    		default:
    			$query->orderBy([ 'id' => SORT_DESC ]);
    			break;
    	}
    
    		
    	return $query->offset(  ( $p - 1 ) * $page_size )
    	->limit( $page_size )
    	->all();
    } 
	/**
	 * 
	 */
    public function actionSet(){
    	
    	$now_date = date("Y-m-d H:i:s");
    	//返回首页
    	$reback_url = UrlService::buildFrontUrl('/task/index');
    	if(\Yii::$app->request->isGet){    		
    		//取得ID
    		$id = intval( $this->get("id", 0) );    		
    		  
    		$query = MasterfutureTask::find(); 
    		$info = [];
    		if($id){// 
    			$user_id = $this->current_user['id'];
    			$task_model = $query->where(['id'=>$id,'user_id' =>$user_id])->one();
    			
    			if(!$task_model){
    				return  $this->redirect($reback_url);
    			}
    			//处理信息
    			$info = [
    					'id'=>$task_model->id,
    					'title'=>$task_model->title,
    					'task_desc'=>$task_model->task_desc,
    					//'pub_time'=>$tmpnews->pubtime?$tmpnews->pubtime:$tmpnews->updatetime,
    					'task_group'=>$task_model->task_group,
    					'weight'=>$task_model->weight,
    			         'start_date'=>$task_model->start_date,
    			         'end_date'=>$task_model->end_date,
    					 
    			];
    			 
    		
    		}else {//自建新闻
    			$info = new MasterfutureTask();
    		}
    		
    		return $this->render('set',[
    				'info' => $info    				 
    		]);
    	} 
    	if(\Yii::$app->request->isPost){
    		$method = trim($this->post("addr_method",''));
    		$id = intval($this->post('id',0));
    		$title = trim($this->post("title",""));
    		$content = trim($this->post("task_desc",""));
    		$group = intval($this->post("group",0));
    		$data_str = trim($this->post('data_str',''));
    		$weight= intval($this->post('weight',0));
    		 
    		$user_id = $this->current_user['id'];
    		
    		//公用校验
    		if( mb_strlen( $title,"utf-8" ) < 3 ){
    			return $this->renderJSON([],"请输入符合规范的标题~~",-1);
    		}   		 
    		if( mb_strlen( $content ,"utf-8") < 3 ){
    			return $this->renderJSON([],"请输入符合规范的描述~~",-1);
    		}
    		 	 
    		if($method =='set'){//set方法添加 或者修改
    			
    			$task_model = MasterfutureTask::find()->where(['id'=>$id,'user_id' =>$user_id])->one();
    			//set页面的校验
//     			if(strlen($title) < 3 || strlen($content)  < 2 || $group <1 || $group >6 || $weight >100 || $weight <1 || $pubLevel <0 || $pubLevel >1){
//     				//return  $this->render('set',['info'=>$task_model]);
//     				return $this->renderJSON([],"请输入符合规范的图书名称~~",-1);
//     			}
    		
    			if( mb_strlen( $data_str ,"utf-8") < 20 ){
    			    //应该还要正则判断时间格式的
    			    
    				return $this->renderJSON([],"请输入符合规范的时间~~",-1);
    			}
    			if($group <1 || $group >6 ){
    				return $this->renderJSON([],"请选择组~~",-1);
    			}
    			if( $weight >100 || $weight <1 ){
    				return $this->renderJSON([],"请设置权重~~",-1);
    			}
    		 
    			if(!$task_model){
    				$task_model = new MasterfutureTask();
    			}
    			//add/edit
    			;
    			$task_model->title = $title;
    			$task_model->task_desc = $content;
    			$task_model->task_group = $group;
    			$task_model->start_date = explode(" ",$data_str)[0];
    			$task_model->end_date = explode(" ",$data_str)[1];
    			 
    			$task_model->weight = $weight;
    		 
    			$task_model->user_id = $user_id;
    			$task_model->created_time = $task_model->updated_time = $now_date;
    			if($task_model->save(0)){
    				 
    				return $this->renderJSON([],"操作成功~~");
    			}else {
    				return  $this->render('set',['info'=>$task_model]);
    			}
    				
    			
    		}elseif ($method == 'index'){//index 页面快速添加
    			//保存任务
    			//校验参数
    			
    			$task_model = new MasterfutureTask();
    			$task_model->title = $title;
    			$task_model->task_desc = $content;
    			$task_model->task_group = $group;
    			$task_model->user_id = $user_id;
    			$task_model->created_time = $task_model->updated_time = $now_date;
    			
    			if($task_model->save( 0 )){
    				//返还json
    				return $this->renderJson([],$msg='ok',$code=200);
    			} else{
    				return $this->renderJson([],$msg='fail',$code=-2);
    			}
    		}else{//非法参数
    			  return  $this->redirect($reback_url);
    		}
    		 
    	}
     
    }
    public function actionOps(){
    	if( !\Yii::$app->request->isPost ){
    		return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
    	}
    	
    	$act = $this->post("act","");
    	$id = intval( $this->post("dataid",0) );
    	$group = intval( $this->post("group",0) );
    	$weight = intval($this->post('weight',0));
    	$statu = intval($this->post('statu',0));
    	
    	
    	$date_now = date("Y-m-d H:i:s");
    	
    	
    	
    	if( !in_array( $act,[ "edit_type","edit_weight","task_finish",'task_del' ]) ){
    		return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
    	}
    	
    	if( !$id ){
    		return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
    	}
    	if( $act=="edit_type"&&!$group ){
    		return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
    	}
    	if( $act=="edit_weight"&&!$weight ){
    		return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
    	}
    	
    	$user_id = $this->current_user['id'];
    	//$task_info = MasterfutureTask::find()->where([ 'id' => $id,'user_id' => $this->current_user['id'] ])->one();
    	//只能修改自己的任务
    	$task_info = MasterfutureTask::find()->where([ 'id' => $id,'user_id' => $user_id])->one();
    	if( !$task_info ){
    		return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
    	}
    	
    	$task_info->updated_time = $date_now;
    	
    	switch ( $act ){
    		case "edit_type":
    			$task_info->task_group = $group;
    			$task_info->update(0);
    			break;
    		case "edit_weight":
    			$task_info->weight = $weight;
    			$task_info->update( 0 );
    			break;
    		case "task_finish":
    			$task_info->statu = 1;
    			$task_info->finish_time = $date_now;
    			$task_info->update( 0 );
    			break; 
    		case "task_del":
    		    $task_info->statu = -1;
    		    $task_info->updated_time = $date_now;
    		    $task_info->update( 0 );
    		    break;
    			
    	}
    	
    	return $this->renderJSON([],"操作成功~~");
  }
  
  public function actionInfo(){
    //只能访问自己的
  	
  	$user_id = $this->current_user['id'];
  	$id = intval($this->get('id',1));
  	//返回首页		
  	$reback_url = UrlService::buildMUrl('/task/index');
  	
  	$task_info = MasterfutureTask::find()->where(['id'=>$id,'user_id'=>$user_id])->one();
  	$data[] = $task_info;
  	$member_mapping = DataHelper::getDicByRelateID($data, MemberExtra::className(), 'user_id', 'id',['nickname','avatar']);
  	
  	$cate_mapping = DataHelper::getDicByRelateID($data, MasterfutureCategory::className(), 'cate_id', 'id',['name']);
  	
  	
  	
  	if(!$task_info){
  		//是否是拥有者
         return  $this->redirect($reback_url);
   	}  
  	//更新查看数
  	$task_info->viewNum +=1;
  	$task_info->save(0);	 
  	return $this->render("info",[
  			'task_model'=>$task_info, 
  			'current_user'=>['id'=>$user_id],
  	        'user_avatar'=>$member_mapping[$task_info[user_id]]['avatar'],
  	        'user_name'=>$member_mapping[$task_info[user_id]]['nickname'],
  			'cate_name'=>$cate_mapping[$task_info['cate_id']]['name']
  	]);
  }
  
    
}
