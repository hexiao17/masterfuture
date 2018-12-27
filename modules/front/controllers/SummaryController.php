<?php
namespace app\modules\front\controllers;

use app\modules\front\controllers\common\BaseFrontController;
use app\models\masterfuture\MasterfutureTaskExtra;
use app\models\masterfuture\MasterfutureSummaryExtra;
use app\common\services\ValidateService;
use app\common\services\UtilService;

class SummaryController extends BaseFrontController
{
    
    public function actionIndex() {
        $user_id = $this->current_user['id'];
        $summarys = MasterfutureSummaryExtra::find()->where(['user_id'=>$user_id,'statu'=>1])->orderBy(['type'=>SORT_ASC])->all();
        
        $this->render('index',['summarys'=>$summarys]);
    }
    
    public function actionSet() {
       
        $user_id = $this->current_user['id'];
        $date_now = date('Y-m-d H:i:s');
        //查询规定时间段内的所有任务
        $dateStr = trim($this->post('dateStr',''));
        
        $arr = explode(' - ',$dateStr);
        if(sizeof($arr)!=2 || !ValidateService::isDate($arr[0]) || !ValidateService::isDate($arr[1])){
            return $this->renderJSON([],"请选择正确的时间~~",-1);
        }
        
        
        $tasks = MasterfutureTaskExtra::find()->where(['user_id'=>$user_id])
                ->andWhere(['>','created_time',$arr[0]])
                ->andWhere(['<=','finish_time',$arr[1]])
                ->all();
        
        $longText = "";
        $i = 1;
        //循环处理字符串
        foreach ($tasks as $_item){
            $longText =$longText. "<br>".$i.'、'.$_item['title']."<br>";
            $longText =$longText. "[正文：".$this->stripHtmlTags(['br','hr','p','u'], $_item['task_desc'])."]";
            $i++;
        }
        
        //保存
        $summary_model = new MasterfutureSummaryExtra();
        $summary_model->user_id = $user_id;
        $summary_model->created_time = $date_now;
        $summary_model->title =  date('[Y-m--',strtotime($arr[0])).date('Y-m]',strtotime($arr[1])).'总结';
        $summary_model->year_month = date('[Y-m-d--',strtotime($arr[0])).date('Y-m-d]',strtotime($arr[1]));
        $summary_model->summary_content = $longText;
       
        $ret = $summary_model->save(0);
        if(!$ret){
            //var_dump($summary_model) ;
            return $this->renderJSON([],"失败".$summary_model->getErrors(),-1);;
        }
        return $this->renderJSON([],"成功",200);;
    }
    
    public function actionInfo() {
        $id = intval($this->get('id',0));
        
        
        $summary_model = MasterfutureSummaryExtra::find()->where(['id'=>$id])->one();
        
        
        return $this->render('info',['summary_info'=>$summary_model]);
        
        
        
    }
    
    
    
    /**
     * 删除指定标签
     *
     * @param array $tags     删除的标签  数组形式
     * @param string $str     html字符串
     * @param bool $content   true保留标签的内容text
     * @return mixed
     */
    function stripHtmlTags($tags, $str, $content = true)
    {
        $html = [];
        // 是否保留标签内的text字符
        if($content){
            foreach ($tags as $tag) {
                $html[] = '/(<' . $tag . '.*?>(.|\n)*?<\/' . $tag . '>)/is';
            }
        }else{
            foreach ($tags as $tag) {
                $html[] = "/(<(?:\/" . $tag . "|" . $tag . ")[^>]*>)/is";
            }
        }
        $data = preg_replace($html, '', $str);
        return $data;
    }
    
    
    
    
    
    
}

