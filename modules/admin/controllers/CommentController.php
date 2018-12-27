<?php
namespace app\modules\admin\controllers;
use app\modules\admin\controllers\common\BaseAdminController;
use app\models\member\MemberComments;
use app\common\services\DataHelper;
use app\models\book\Book;
use app\models\member\Member;
use app\common\services\ConstantMapService;

class CommentController extends BaseAdminController {
    
   public function actionIndex() {
       $status = intval( $this->get("status",ConstantMapService::$status_default ) );
       $p = intval( $this->get("p",1) );
       $p = ( $p > 0 )?$p:1;
       $query = MemberComments::find();
       
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
       
       $data = [];
       if($list){
           $member_mapping = DataHelper::getDicByRelateID( $list,Member::className(),"member_id","id",[ "nickname" ] );
           $book_mapping = DataHelper::getDicByRelateID($list, Book::className(), "book_id", "id",['name']);
           foreach ($list as $_item){
                $data[]= [
                    'id'=>$_item['id'],
                    'nickname'=>$member_mapping[$_item['member_id']]['nickname'],
                    'bookname'=>$book_mapping[$_item['book_id']]['name'],
                    'score'=>$_item['score'],
                    'content'=>$_item['content'],
                    'created_time'=>$_item['created_time'],
                    'status'=>$_item['status'],
                    'type'=>ConstantMapService::$comment_type_mapping[$_item['type']]
                ];
           }
           
       } 
       
       return $this->render('index',[
           'search_conditions' => [ 
               'p' => $p,
               'status' => $status, 
           ],
           'status_mapping' => ConstantMapService::$status_mapping,
           'comments'=>$data,
           'pages' => [
               'total_count' => $total_res_count,
               'page_size' => $this->page_size,
               'total_page' => $total_page,
               'p' => $p
           ]
       ]);
    }
    
    
    public function actionSet(){
        if( \Yii::$app->request->isGet ) {
            $id = intval( $this->get("id", 0) );
            $info = [];
            if( $id ){
                $info = MemberComments::find()->where([ 'id' => $id ])->one();
            }
    
            $book_list = Book::find()->orderBy([ 'id' => SORT_DESC ])->all();
           
            return $this->render('set',[
                'book_list' => $book_list,                
                'info' => $info
            ]);
        }
    
        $id = intval( $this->post("id",0) );
        $book_id = intval( $this->post("book_id",0) );
        $score = intval($this->post("score",0));    
        $content = trim( $this->post("content","") );
      
        $date_now = date("Y-m-d H:i:s");
    
        if( !$book_id ){
            return $this->renderJSON([],"请选择产品~~",-1);
        }
        if( !$score ){
            return $this->renderJSON([],"请填写评分~~",-1);
        }
        if( mb_strlen( $content,"utf-8" ) < 5 ){
            return $this->renderJSON([],"评论的长度必须大于5个字符~~",-1);
        } 
        $info = [];
        if( $id ){
            $info = MemberComments::findOne(['id' => $id]);
        }
        if( $info ){
            $model_comment = $info;
        }else{
            $model_comment = new MemberComments();
            //模拟的属性
            $model_comment->status = 1;
            $model_comment->created_time = $date_now;
            $model_comment->type = 2;
            
            //设置为随机用户
            $count = Member::find()->count();            
            $model_comment->member_id = rand(1,$count);            
            
        }
        $model_comment->book_id = $book_id;
        $model_comment->score = $score;
        $model_comment->content = $content;         
        if($model_comment->save( 0 )){
            //更新评论数
            $book_model = Book::findOne(['id'=>$book_id]);
            $book_model->comment_count +=1;
            $book_model->update( 0 );
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
            return $this->renderJSON([],"请选择要操作的评论~~",-1);
        }
    
        if( !in_array( $act,['remove','recover' ])){
            return $this->renderJSON([],"操作有误，请重试~~",-1);
        }
    
        $info = MemberComments::find()->where([ 'id' => $id ])->one();
        if( !$info ){
            return $this->renderJSON([],"指定评论不存在~~",-1);
        }
    
        switch ( $act ){
            case "remove":
                $info->status = 0;
                break;
            case "recover":
                $info->status = 1;
                break;
        }        
        $info->update( 0 );
        return $this->renderJSON( [],"操作成功~~" );
    }
    
    
    
    
}