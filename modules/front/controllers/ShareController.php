<?php

namespace app\modules\front\controllers;
  
use app\common\services\DataHelper; 
use app\common\services\UtilService;
use app\common\services\ConstantMapService;
use app\common\services\UrlService;
 
use app\models\masterfuture\MasterfutureTask;
use app\models\masterfuture\MasterfutureShareTask;
use app\models\masterfuture\MasterfutureCategory;
 
use app\models\masterfuture\MasterfutureShareTaskReply;
 
use app\models\member\MemberExtra;
use app\modules\front\controllers\common\BaseFrontController;
use app\models\masterfuture\MasterfutureShareTaskExtra;
class ShareController extends BaseFrontController
{
	 
   
    /**
     * 一键分享的动作
     */
    public function actionOne(){
        if( !\Yii::$app->request->isPost ){
            return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
        }
        $act = trim($this->post("act",""));
        $type = intval($this->post("type",""));
        $task_id = intval( $this->post("id",0) );
        $passwd = trim( $this->post("passwd","") );  
        $date_now = date("Y-m-d H:i:s");
         
        if( !in_array( $type,[ "0","1" ]) ){
            return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
        }
        
        if( !$task_id){
            return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
        }
        if( !in_array($act, ["add","del"]) ){
            return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
        }
        
        $user_id = $this->current_user['id'];
        //$task_info = MasterfutureTask::find()->where([ 'id' => $id,'user_id' => $this->current_user['id'] ])->one();
        //只能分享自己的任务
        $task_info = MasterfutureTask::find()->where([ 'id' => $task_id,'user_id' => $user_id])->one();
        if( !$task_info ){
            return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
        }
        
        $task_info->updated_time = $date_now;
        
        switch ( $act ){
            case "add":
                $new_share = new MasterfutureShareTask();
                $new_share->uuid =  md5(uniqid(mt_rand(), true));   
                $new_share->task_id = $task_info->id;
                if(!$passwd){
                    $new_share->share_level = 2;
                }
                $new_share->access_pwd = $passwd;
                $new_share->created_user = $user_id;
                $new_share->cate_id = $task_info->cate_id;
                $new_share->snapshot =  $task_info->task_desc;
                $new_share->created_time =  $date_now;
                $new_share->title = $task_info->title;               
                if($new_share->save(0)){
                    $task_info->isShare = 1;
                    $task_info->updated_time = $date_now;
                    $task_info->share_id = $new_share->uuid;
                    $task_info->update( 0 );
                }
                break;
            case "del":
                $share_list  = MasterfutureShareTask::find()->where(['task_id'=>$task_id,'created_user'=>$user_id])->all(); 
                //循环删除
                foreach ($share_list as $share){
                    $share->statu =0;
                    $share->updated_time = $date_now;
                    $share->update(0);
                }
                $task_info->isShare = 0;
                $task_info->updated_time = $date_now;
                $task_info->update( 0 );
                break; 
        }
        
        return $this->renderJSON([],"操作成功~~");
        
    }
   
    public function actionGetpwd(){
        if( !\Yii::$app->request->isPost ){
            return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
        }
        
        $id = intval($this->post('id',0));
        $info = MasterfutureShareTaskExtra::find()->where(['task_id'=>$id,'statu'=>1])->one();
        if(!$info){
            return $this->renderJSON([],ConstantMapService::$default_syserror,-1);
        }
        
        return $this->renderJSON([],"密码是:".$info->access_pwd,200);
        
    }
     
   //任务首页
    public function actionIndex(){ 
		//----------- ---------------------------------------	
		//关键词	 
		$kw = trim( $this->get("kw","") );
		//排序规则
		$sort_field = trim( $this->get("sort_field","default") );
		$sort = trim( $this->get("sort","") );
		$sort = in_array(  $sort,['asc','desc'] )?$sort:'desc';
		//分组
		 
		//分页
		$p = intval( $this->get("p",1) );
		$p = ( $p > 0 )?$p:1;
		//默认显示条数
		$pageSize =10;
		//
		$query = MasterfutureShareTask::find();
		
		//查询基本条件
		$query->where(['share_level'=>2])->andWhere(['>=','statu',1]);
		
		//echo '%-'.strtr($kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'-%';
		//exit();
		if($kw){
			  $where_title = ['LIKE','title','%'.strtr($kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
			  $where_content = ['LIKE','task_desc','%'.strtr($kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
			  $query->andWhere(['OR',$where_title,$where_content]);
		}
		 
		//分页功能
		$total_res_count = $query->count();
		$total_page = ceil($total_res_count/$pageSize);
		
		$list = $query->orderBy(['statu'=>SORT_DESC,'agree_num' => SORT_DESC,'view_num'=>SORT_DESC,'id'=>SORT_DESC])
			->offset(($p-1)*$pageSize)
			->limit($pageSize)
			->all();
		 
		$data = [];
		if( $list ){
		    //关联查询
		    $member_mapping = DataHelper::getDicByRelateID($list, MemberExtra::className(), "created_user",'id', ['nickname','avatar']);
		    $cate_mapping = DataHelper::getDicByRelateID($list, MasterfutureCategory::className(), "cate_id", 'id',['name']);
		    foreach( $list     as $_item ){
		        $user = isset($member_mapping[$_item['created_user']])?$member_mapping[$_item['created_user']]:['nickname'=>"无昵称"];
		        $cate = isset($cate_mapping[$_item['cate_id']])?$cate_mapping[$_item['cate_id']]:['name'=>"无分类"];
		        
		        $data[] = [
		            'uuid' => $_item['uuid'],
		            'title' => UtilService::cutstr(UtilService::encode( $_item['title'] ),40),
		            'content' => UtilService::cutstr(UtilService::encode( $_item['snapshot'] ),200),
		            'created_time'=>UtilService::str2DateFormate($_item['created_time'], 'Y-m-d'),
		            'view_num' => UtilService::encode( $_item['view_num'] ),
		            'agree_num' => UtilService::encode( $_item['agree_num'] ),
		            'reply_num' => UtilService::encode( $_item['reply_num'] ),
		            'cate_name'=>UtilService::cutstr(UtilService::encode( $cate['name'] ),10),
		            'username'=>$user['nickname'],
		            'end_date'=>UtilService::str2DateFormate($_item['expired_time'], 'Y-m-d'),
		            'user_id'=>$_item['created_user'],
		            'avatar'=>$user['avatar'],
		            'statu'=>$_item['statu']
		        ];
		    }
		}
		
		$search_conditions = [
				'kw' => $kw,
				'sort_field' => $sort_field,
				'sort' => $sort,
			 
		];  
		 
		return $this->render($this->isWechat?"mini_index":"index",[
			 
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
    					'pubLevel'=>$task_model->pubLevel,
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
    		$pubLevel = intval($this->post('pubLevel',-1));
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
    			if($pubLevel <0 || $pubLevel >1){
    				return $this->renderJSON([],"请选择是否公开~~",-1);
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
    			$task_model->pubLevel = $pubLevel;
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
    	
    	
    	
    	if( !in_array( $act,[ "edit_type","edit_weight","edit_statu" ]) ){
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
    	if( $act=="edit_statu"&&!$statu ){
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
    		case "edit_statu":
    			$task_info->statu = $statu;
    			$task_info->task_group = 1;//把置顶改成今天
    			$task_info->update( 0 );
    			break;    		
    	}
    	
    	return $this->renderJSON([],"操作成功~~");
  }
  
  public function actionInfo(){
      $uuid = $this->get("uuid","");
      if(!$uuid){
          return $this->renderJSON([],"访问链接不正确~~",-1);
      }
      
      $Share_info = MasterfutureShareTask::find()->where(['uuid'=>$uuid])->andWhere(['>=','statu',1])->one();
      if(!$Share_info){
          return $this->renderJSON([],"访问的页面不存在~~",-1);
      }
      
      //reply
      $replys =  MasterfutureShareTaskReply::find()->where(['share_id'=>$Share_info->id,'statu'=>1])->orderBy(['isAccept'=>SORT_DESC,'floor'=>SORT_ASC])->all();
      //member
      $data[] = $Share_info;
      $member_mapping = DataHelper::getDicByRelateID($data, MemberExtra::className(), 'created_user', 'id',['nickname','avatar']);
      
      $members_mapping = DataHelper::getDicByRelateID($replys, MemberExtra::className(), 'user_id', 'id',['nickname','avatar','status']);
      
      //
      $reply_list = [];
      foreach ($replys as $_item){
          $tmp_member = $members_mapping[$_item['user_id']];
          $reply_list[] = [
              'id'=>$_item['id'],
              'content'=>UtilService::encode( $_item['content']),
              'created_time'=>$_item['created_time'],
              'agree_num'=>$_item['agreeNum'],
              'isAccept'=>$_item['isAccept'],
              'floor'=>$_item['floor'],
              'user_id'=>$_item['user_id'],
              //
              'nickname'=>$tmp_member['nickname'],
              'avatar'=>$tmp_member['avatar'],
              'user_statu'=>$tmp_member['status'],
          ];
          
          
      }
      //更新访问次数
      $Share_info->view_num = $Share_info->view_num + 1;
      $Share_info->update( 0 );
      
      //不需要密码,直接显示
      if(empty($Share_info->access_pwd)){
          return $this->render("info",[
              'share_info'=>$Share_info,
              'member'=>$member_mapping[$Share_info['created_user']],
              'replys'=>$reply_list
          ]);
      } 
      return $this->redirect(UrlService::buildFrontUrl('/share/accesspwd',['uuid'=>$uuid])); 
   }
   /**
    * 有密码时候的访问
    */
   public function actionAccesspwd(){
      
       //get方法，访问，如果存在cookie，就说明可以访问
       if(!\Yii::$app->request->isPost){
           $uuid = trim($this->get('uuid',''));
            $u_cookie =   $this->getCookie($uuid);
            
            if($u_cookie){
                $Share_info = MasterfutureShareTask::find()->where(['uuid'=>$uuid ])->andWhere(['>=','statu','1'])->one();
                 
                
                //reply
                $replys =  MasterfutureShareTaskReply::find()->where(['share_id'=>$Share_info->id,'statu'=>1])->orderBy(['isAccept'=>SORT_DESC,'floor'=>SORT_ASC])->all();
                //member
                $data[] = $Share_info;
                $member_mapping = DataHelper::getDicByRelateID($data, MemberExtra::className(), 'created_user', 'id',['nickname','avatar']);
                
                $members_mapping = DataHelper::getDicByRelateID($replys, MemberExtra::className(), 'user_id', 'id',['nickname','avatar','status']);
                
                //
                $reply_list = [];
                foreach ($replys as $_item){
                    $tmp_member = $members_mapping[$_item['user_id']];
                    $reply_list[] = [
                        'id'=>$_item['id'],
                        'content'=>UtilService::encode( $_item['content']),
                        'created_time'=>$_item['created_time'],
                        'agree_num'=>$_item['agreeNum'],
                        'isAccept'=>$_item['isAccept'],
                        'floor'=>$_item['floor'],
                        'user_id'=>$_item['user_id'],
                        //
                        'nickname'=>$tmp_member['nickname'],
                        'avatar'=>$tmp_member['avatar'],
                        'user_statu'=>$tmp_member['status'],
                    ]; 
                }
                
                //更新访问次数
                $Share_info->view_num = $Share_info->view_num + 1;
                $Share_info->update( 0 );
                
                return $this->render("info",[
                    'share_info'=>$Share_info,
                    'member'=>$member_mapping[$Share_info['created_user']],
                    'replys'=>$reply_list
                ]);
                
            }else{
                return $this->render('passwd',['uuid'=>$uuid]); 
            }
       
        }else{
           //post  验证密码 设置cookie
           $uuid = trim($this->post("uuid",""));
           $passwd = trim($this->post("passwd",""));
           if(!$uuid || !$passwd){
               return $this->renderJSON([],"访问链接不正确或密码错误~~",-1);
           }
          
           $Share_info = MasterfutureShareTaskExtra::find()->where(['uuid'=>$uuid])->andWhere(['>=','statu','1'])->one();
           if(!$Share_info){
               return $this->renderJSON([],"访问的页面不存在~~",-1);
           }
           
           if($Share_info->access_pwd != $passwd){              
               
               return $this->renderJSON([],"密码错误~~",-1);
           }
           //密码正确，设置cookie
           
           $this->setCookie($Share_info->uuid, true);
           
            return $this->renderJSON([],"密码正确~~",200);
       } 
   }
}
