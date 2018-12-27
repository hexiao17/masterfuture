<style>
<!--
.notice {
    width: 600px;
    margin: 30px auto;
    padding: 30px 15px;
    border-top: 5px solid #009688;
    line-height: 30px;
    text-align: center;
    font-size: 16px;
    font-weight: 300;
    background-color: #f2f2f2;
}
-->
</style>
<div class="layui-col-md8">
<div class="fly-none" style="min-height: 0; padding: 0;">
   
   <h2><?=$summary_info['year_month'].'|'.$summary_info['title']?></h2>
  
  <div class="notice layui-text"   >
	<?=nl2br($summary_info['summary_content'])?>

 </div>
</div>
</div>
