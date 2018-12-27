<?php
namespace app\modules\admin\controllers;

use app\modules\admin\controllers\common\BaseAdminController;
use app\models\sms\SmsQueue;
use app\common\services\ConstantMapService;

use app\models\member\Member;
use app\common\services\DataHelper;
use app\common\services\SmsService;
use app\common\services\QueueListService;
use app\models\role\Role;
use app\models\notice\NoticeWxQueue;
use app\models\notice\NoticeSmsQueue;
/**
 * 用于 管理通知的类
 *  1、微信通知
 *  2、短信通知
 * @author Administrator
 *
 */
class NoticeController extends BaseAdminController
{
    /**
     * 已发微信列表
     */
    public function actionIndex_wx(){
        $mix_kw = trim( $this->get("mix_kw","" ) );
        $status = intval( $this->get("status",ConstantMapService::$status_default ) );       
        $p = intval( $this->get("p",1) );
        $p = ( $p > 0 )?$p:1;
        
        $query = NoticeWxQueue::find();
        
        if( $mix_kw ){
            $where_mobile = [ 'LIKE','mobile','%-'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'-%', false ];
            $where_content = [ 'LIKE','content','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
            $query->andWhere([ 'OR',$where_mobile,$where_content ]);
        }
        
        if( $status > ConstantMapService::$status_default ){
            $query->andWhere([ 'status' => $status ]);
        } 
        //分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
        //60,60 ~ 11,10 - 1
        $total_res_count = $query->count();
        $total_page = ceil( $total_res_count / $this->page_size );
        
        
        $list = $query->orderBy([ 'id' => SORT_DESC ])
        ->offset( ( $p - 1 ) * $this->page_size )
        ->limit($this->page_size)
        ->all( );
         
       
        
        return $this->render('index_wx',[
            'list' => $list,
            'search_conditions' => [
                'mix_kw' => $mix_kw,
                'p' => $p,
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
    /**
     * 已发短信列表
     */
    public function actionIndex_sms(){
    	$mix_kw = trim( $this->get("mix_kw","" ) );
    	$status = intval( $this->get("status",ConstantMapService::$status_default ) );
    	$p = intval( $this->get("p",1) );
    	$p = ( $p > 0 )?$p:1;
    
    	$query = NoticeSmsQueue::find();
    
    	if( $mix_kw ){
    		$where_mobile = [ 'LIKE','mobile','%-'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'-%', false ];
    		$where_content = [ 'LIKE','content','%'.strtr($mix_kw,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
    		$query->andWhere([ 'OR',$where_mobile,$where_content ]);
    	}
    
    	if( $status > ConstantMapService::$status_default ){
    		$query->andWhere([ 'status' => $status ]);
    	}
    	//分页功能,需要两个参数，1：符合条件的总记录数量  2：每页展示的数量
    	//60,60 ~ 11,10 - 1
    	$total_res_count = $query->count();
    	$total_page = ceil( $total_res_count / $this->page_size );
    
    
    	$list = $query->orderBy([ 'id' => SORT_DESC ])
    	->offset( ( $p - 1 ) * $this->page_size )
    	->limit($this->page_size)
    	->all( );
    	 
    	 
    
    	return $this->render('index_sms',[
    			'list' => $list,
    			'search_conditions' => [
    					'mix_kw' => $mix_kw,
    					'p' => $p,
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
    /**
     * 发送微信通知
     */
    public function actionSet_wx(){
        
         if( \Yii::$app->request->isGet ) {
    			$id = intval( $this->get("id", 0) );
    			 
    			$info = [];
    			if( $id ){
    				$info = NoticeWxQueue::find()->where([ 'id' => $id ])->one();
    			}    			 
    			
    			//查询所有会员
    			$list_membsers = Member::find()->where('role_id' >'1')->andWhere(['status'=>1])->orderBy(['role_id'=>SORT_DESC])->all();
    			 
    			$data = [] ;
    			$tmp_role_mapping = DataHelper::getDicByRelateID($list_membsers, Role::className(), "role_id", 'id',['name']);
    			
    			foreach ($list_membsers as $_member){
    			    $role = $tmp_role_mapping[$_member['role_id']];
    			    $_item['nickname'] = $_member->nickname;
    			    $_item['mobile']  = $_member->mobile;
    			    $_item['role_name']= $role['name'];
    			
    			    $data[] = $_item;
    			}
    			
    			
    			return $this->render('set_wx',[    				  
    				'info' => $info,
    			    'memeber_list' =>$data,
    			]);
    		}
    		$id = intval( $this->post("id",0) );
    		 
    		$zb_count =  intval($this->post("zb_count",0));
    		$st_count =  intval($this->post("st_count",0));
    		
    		$mobile_list = $this->post('mobile_list',[]); 
    		$date_now = date("Y-m-d H:i:s");
    		 
    		if( $zb_count < 1 && $st_count <1 ){
    		    return $this->renderJSON([],"请输入符合规范的通知内容~~".$zb_count,-1);
    		}
    		
    		 $mobileArr = json_decode($mobile_list);
    		  
    		 if(sizeof($mobileArr) <1){
    		     return $this->renderJSON([],"请选择发送人~~",-1);
    		 } 
    		 //生成通知内容
    		 $sendstr="已更新";
    		 $sendstr .= $zb_count>0?"招标信息".$zb_count."条":"";
    		 $sendstr .= $st_count>0?",商谈信息".$st_count."条":""; 		 
    		
    		for ($i=0;$i<sizeof($mobileArr);$i++){//循环发送短信   	    
    		    $model_sms = new NoticeWxQueue();    		  
    		    $model_sms->created_time = $date_now; 
    		    $model_sms->content = $sendstr;   
    		    $model_sms->wx_status = 0;
    		    $model_sms->mobile = $mobileArr[$i];   		    
    		    $model_sms->send_user = $this->current_user['nickname'];
    		    $model_sms->save( 0 );    
    		    //批量微信通知
    		    QueueListService::addQueue("send_weixin_msg",[
    		        'task_id'=>$model_sms->id,
    		        'mobile' => $mobileArr[$i],
    		        'content' => $model_sms->content,
    		        'type'=>1, //手动
    		    ]);
    		    
    		} 	 
    		  return $this->renderJSON([],"操作成功~~");     
        
    }    
    
    
    /**
     * 发送系统维护通知
     */
    public function actionSet_wh(){
    
    	if( \Yii::$app->request->isGet ) {
    		$id = intval( $this->get("id", 0) );
    
    		$info = [];
    		if( $id ){
    			$info = NoticeWxQueue::find()->where([ 'id' => $id ])->one();
    		}
    		 
    		//查询所有会员
    		$list_membsers = Member::find()->where('role_id' >'1')->andWhere(['status'=>1])->orderBy(['role_id'=>SORT_DESC])->all();
    
    		$data = [] ;
    		$tmp_role_mapping = DataHelper::getDicByRelateID($list_membsers, Role::className(), "role_id", 'id',['name']);
    		 
    		foreach ($list_membsers as $_member){
    			$role = $tmp_role_mapping[$_member['role_id']];
    			$_item['nickname'] = $_member->nickname;
    			$_item['mobile']  = $_member->mobile;
    			$_item['role_name']= $role['name'];
    			 
    			$data[] = $_item;
    		}
    		 
    		 
    		return $this->render('set_wh',[
    				'info' => $info,
    				'memeber_list' =>$data,
    		]);
    	}
    	$id = intval( $this->post("id",0) );
    	 
    	$str_first =  trim($this->post("str_first",""));
    	$str_two =  trim($this->post("str_two",""));
    	$str_three =  trim($this->post("str_three",""));
    	$str_four =  trim($this->post("str_four",""));
    
    	$mobile_list = $this->post('mobile_list',[]);
    	$date_now = date("Y-m-d H:i:s");
    	 
    	if( strlen($str_first) < 1 ||  strlen($str_two) <1 || strlen($str_three)< 1  || strlen($str_four) < 1  ){
    		return $this->renderJSON([],"请输入符合规范的通知内容~~".$str_first,-1);
    	}
    
    	$mobileArr = json_decode($mobile_list);
    
    	if(sizeof($mobileArr) <1){
    		return $this->renderJSON([],"请选择发送人~~",-1);
    	}
    	//生成通知内容,日志只填写基本信息
    	$sendstr= $str_four."[".$str_three."]";    	 
    
    	for ($i=0;$i<sizeof($mobileArr);$i++){//循环发送短信
    		$model_sms = new NoticeWxQueue();
    		$model_sms->created_time = $date_now;
    		$model_sms->content = $sendstr;
    		$model_sms->wx_status = 0;
    		$model_sms->mobile = $mobileArr[$i];
    		$model_sms->send_user = $this->current_user['nickname'];
    		$model_sms->save( 0 );
    		//添加到执行序列
    		QueueListService::addQueue("send_weixin_wh",[
    		'task_id'=>$model_sms->id,
    		'mobile' => $mobileArr[$i],
    		'first' => $str_first,
    		'two' => $str_two,
    		'three' => $str_three,
    		'four'  => $str_four,
    		'type'=>1, //手动
    		]);
    
    	}
    	return $this->renderJSON([],"操作成功~~");
    
    }
    /**
     * 添加短信
     * 模板：尊敬的用户，你订购的招标信息，今日更新了${count}条,请登录微信服务号(陕西易中信息技术有限公司)查看详情。
     */
    public function actionSet_sms(){
    
    	if( \Yii::$app->request->isGet ) {
    		$id = intval( $this->get("id", 0) );
    
    		$info = [];
    		if( $id ){
    			$info = NoticeSmsQueue::find()->where([ 'id' => $id ])->one();
    		}
    		 
    		//查询所有会员
    		$list_membsers = Member::find()->where('role_id' >'1')->andWhere(['status'=>1])->orderBy(['role_id'=>SORT_DESC])->all();
    
    		$data = [] ;
    		$tmp_role_mapping = DataHelper::getDicByRelateID($list_membsers, Role::className(), "role_id", 'id',['name']);
    		 
    		foreach ($list_membsers as $_member){
    			$role = $tmp_role_mapping[$_member['role_id']];
    			$_item['nickname'] = $_member->nickname;
    			$_item['mobile']  = $_member->mobile;
    			$_item['role_name']= $role['name'];
    			 
    			$data[] = $_item;
    		}

    		//查询所有短信模板的ID列表
    		$template = [
    			'SMS_135044871'=>'"陕西易中信息技术有限公司"公众号，你的同行都在用，专注长庆油田招标信息，即时发布，来开拓您的广阔市场吧。',
    			'SMS_135039773'=>'亲爱的${name}，长庆油田招标信息已经更新。请关注"陕西易中信息技术有限公司"微信公众号，绑定手机即可浏览，不看后悔',
    			'SMS_106955100'=>'尊敬的用户，你订购的招标信息，今日更新了${count}条,请登录微信服务号(陕西易中信息技术有限公司)查看详情。'
    		];
    		 
    		return $this->render('set_sms',[
    				'info' => $info,
    				'memeber_list' =>$data,
    				'template'=>$template
    		]);
    	}
    	//post
    	//手动添加电话
    	$add_mobile = trim($this->post('add_mobile',''));
    	//批量选择的电话
    	$mobile_list = $this->post('mobile_list',[]);
    	 
    	//模板ID
    	$template_id = trim($this->post('template_id',''));
    	if(strlen($template_id)<1) {
    		return $this->renderJSON([],"选个模板啊" ,-1);
    	}
    	//模板参数
    	$parmStr = trim($this->post('paramstr','')); 
    	$date_now = date("Y-m-d H:i:s");
    	//转换成数组
    	$mobileArr = json_decode($mobile_list);
    	
    	$tmpList = [];
    	if(sizeof($mobileArr) >0){
    		 $tmpList = $mobileArr;
    	}
    	if(strlen($add_mobile)>1 && sizeof(explode(",", $add_mobile))>0 ){
    		$tmpList = $tmpList + explode(",", $add_mobile);
    	}
    	if(sizeof($tmpList) <1){
    		return $this->renderJSON([],"不管怎么弄，你都得搞个发送人啊",-1);
    	} 
    	
    	//参数数组
    	$paramArr = json_decode($parmStr);
    	if(sizeof($paramArr)<1){
    		return $this->renderJSON([],"你还是需要参数的，尽管可能没有".$template_id,-1);
    	}
    	//循环发送短信
    	for ($i=0;$i<sizeof($tmpList);$i++){
    		$model_sms = new NoticeSmsQueue();
    		$model_sms->created_time = $date_now;
    		$model_sms->content = json_encode($paramArr);//"准备发送";
    		$model_sms->sms_status = 0;
    		$model_sms->return_msg = "";
    		$model_sms->template_id =$template_id;
    		$model_sms->mobile = trim($tmpList[$i]);
    		$model_sms->send_user = $this->current_user['nickname'];
    		$model_sms->save( 0 );
    		//把批量发短信加入队列中
    		    		    QueueListService::addQueue( "send_sms",[
    		    		    		'task_id'=>$model_sms->id,
    		    		            'mobile' => $tmpList[$i],
    		    		            'paramArr' =>$paramArr,  		    		        
    		    		            'template_id'=>$model_sms->template_id,
    		    		            'type'=>1,//
    		    		        ]
    		    		     );   	 
    
    	}
    	 
    	return $this->renderJSON([],"操作成功~~");
    
    }
}

