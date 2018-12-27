<?php
use \app\common\services\UrlService;
?>
  <div style="text-align: center">
          <div class="laypage-main">
          
          	<?php
          	//计算起始页码
          	$cur_page = $pages['p'];//当前页
          	$max_page = $pages['total_page'];//总页数
          	$btn_count = 3;  //一半的按钮数
          	$start_p = $cur_page>$btn_count?$cur_page-$btn_count:1;
          	$end_p = $cur_page +$btn_count > $max_page ?$max_page:$cur_page+$btn_count;
          	
          	//	还有其他参数的情况  
          	$queryParam=[];        
          	if (isset($condition)){
          		$queryParam +=$condition;
          	}          	
          	?>
          	<?php 
          	if($cur_page >1) :?>
          		 
          	     <a class="laypage-first" href="<?=UrlService::buildMUrl( $url,$queryParam + ['p'=>1]);?>">首页</a>;
          		 <a   href="<?=UrlService::buildMUrl( $url,$queryParam + ["p"=>$cur_page-1]);?>">上一页</a>;
          	<?php endif;?>
          	<?php 
			//循环显示的页面
          	 for( $_page = $start_p ;$_page <= $end_p;$_page++ ):?>
				<?php if( $_page ==  $cur_page):?>
				 <span class="laypage-curr"><a href="<?=UrlService::buildNullUrl();?>"><?=$_page;?></a></span>                     
				<?php else:?>                   
                        <?php 
	                        $queryParam = ['p'=>$_page];
	                        if (isset($condition)){
	                        	$queryParam +=$condition;
	                        }              
                        ?>
                          <a href="<?=UrlService::buildMUrl( $url,$queryParam);?>"><?=$_page;?></a>
                    
				<?php endif;?>
			<?php endfor;?>      
			
			<?php 
				if ($cur_page < $max_page):			
			?>			   
	          <a href="<?=UrlService::buildMUrl( $url,$queryParam + ['p'=>$cur_page+1]);?>" class="laypage-next">下一页</a> 
	            <a href="<?=UrlService::buildMUrl( $url,$queryParam + ['p'=>$max_page]);?>" class="laypage-last" title="尾页">尾页</a>
			<?php endif;?>  
			
			<span >共<?=$pages['total_count'];?>条</span>
			
          </div>
  </div>
  
  
  
 