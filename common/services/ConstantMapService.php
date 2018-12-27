<?php
namespace app\common\services;

class ConstantMapService
{
    public static $img_captcha_cookie_name="img_valide_code";
    public static $status_default=-1;
    public static $default_time_stamps = '0000-00-00 00:00:00';
    public static $client_type_wechat = 1; //接入类型
    
    public static $default_avatar= "default_avatar.png";
    //代表默认密码
    public static $default_password = "******";
    
    public static $default_syserror = '系统繁忙，请稍后再试~~';
    
    public static $tmpData_status_mapping=[
        2=>'已发布',
        1 => '正常',
        0 => '已删除'
    ];
    
    public static $status_mapping = [
        1 => '正常',
        0 => '已删除'
    ];
    
    public static $sex_mapping = [
        1 => '男',
        2 => '女',
        0 => '未填写'
    ];
    
    public static $pay_status_mapping = [
        1 => '已支付',
        -8 => '待支付',
        0 => '已关闭'
    ];
    
    public static $express_status_mapping = [
        1 => '会员已签收',
        -6 => '已发货待签收',
        -7 => '已付款待发货',
        -8 => '待支付',
        0 => '已关闭'
    ];
    
    public static $express_status_mapping_for_member = [
        1  => '已签收',
        -6 => '已发货',
        -7 => '等待商家发货',
        -8 => '待支付',
        0 => '已关闭'
    ];
    
    public static $market_qrcode_type_mapping=[
          1=>'系统类型',
          2=>'会员类型'
    ];
    public  static $zbnews_tmp_att_type_mapping=[
        1=>'有',
        0=>'无'
    ];
    public static $role_tab_role_cate_mapping=[
        1=>'后台权限',
        2=>'前台权限'
    ];
    public static $user_role_cate_mapping=[
        1=>'前台用户',
        2=>'后台用户'
    ];
    
    public static $comment_type_mapping=[
        1=>'真实',
        2=>'模拟'
    ];
    
    public static $invitate_user_type_mapping=[
    		2=>'注册',
    		4=>'付费'
    ];
    public static $invitate_user_status_mapping=[
    		0=>'未发放',
    		1=>'已发放'
    ];
    
    //通知系统
    public static $notice_wx_status_mapping=[
    		0=>'未发送',
    		1=>'v',
    		-3=>'x',
    ];
    public static $notice_wx_type_mapping = [
    		1=>'手工发送',
    		2=>'被动触发(注册，付款)',
    		3=>'系统自动（定时推广）',
    ];
    // 
    public static $notice_sms_status_mapping=[
    		0=>'未发送',
    		1=>'v',
    		-3=>'x',
    ];
    public static $notice_sms_type_mapping = [
    		1=>'手工发送',
    		2=>'被动触发(注册，付款)',
    		3=>'系统自动（定时推广）',
    ];
    
    
    //--------------task变量
    public static $task_taskgroup_mapping = [
    		1=>'今天',
    		2=>'本周',
    		3=>'本月',
    		4=>'季度',
    		5=>'本年',
    		6=>'将来'    		
    ];
    public static $task_pubLevel_mapping = [
    		0=>'不公开',
    		1=>'公开'
        ];
    public static $task_reply_isAccept_mapping = [
    		-1=>'屏蔽',
    		0=>'待审核',
    		1=>'已采纳'	
    ];
    
    public static $equipment_statu_mapping = [
        10 => '在用',
        4 => '维修',
        3=>'回收',
        2=>'报废'
    ];
    
    public static $alarm_statu_mapping = [
        0 => '删除',
        1 => '待处理',
        2=>'已接单，马上处理',
        3=>'处理完成'
         
    ];
    
    
    
    public static $userorder_statu_mapping = [
        0=>'删除',
        1=>'待处理',
        2=>'接单，马上处理',
        3=>'处理完成'
    ];
    public static $userorder_type_mapping = [
            1=>'维修',
            2=>'回收',
            3=>'报废',
            4=>'电脑申请'
    ];
    public static $userorder_audittype_mapping = [
            1=>'手动',
            2=>'自动'
    ];
    //处理记录的状态
    public static $replyrecord_statu_mapping=[
        0 => '删除',
        1 => '待审核',
        2=>'已审核',
    ];
}

