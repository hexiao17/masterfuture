<?php
use \app\common\services\UrlService;
?>
<div class="row">
    <div class="col-lg-12">
        <span class="pagination_count" style="line-height: 40px;">共<?=$pages['total_count'];?>条记录 | 每页<?=$pages['page_size'];?>条</span>
        <ul class="pagination pagination-lg pull-right" style="margin: 0 0 ;">

			<?php for( $_page = 1;$_page <= $pages['total_page'];$_page++ ):?>
				<?php if( $_page == $pages['p'] ):?>
                    <li class="active">
                        <a href="<?=UrlService::buildNullUrl();?>"><?=$_page;?></a>
                    </li>
				<?php else:?>
                    <li> 
                        <?php 
                           //	还有其他参数的情况
                        	$queryParam = ['p'=>$_page];
                        	if (isset($condition)){
                        		$queryParam +=$condition;
                        	}                        
                        ?>
                          <a href="<?=UrlService::buildAdminUrl( $url,$queryParam);?>"><?=$_page;?></a>
                    </li>
				<?php endif;?>

			<?php endfor;?>
        </ul>
    </div>
</div>