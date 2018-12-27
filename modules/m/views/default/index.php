<?php
use app\common\services\UtilService;
use app\common\services\UrlService;
use app\common\services\StaticSerivce;
use app\assets\MAsset;
StaticSerivce::includeAppJsStatic("/js/m/default/index.js", MAsset::className());
$this->title = Yii::$app->params['title'].'成就你的未来！';
?>
<header class='demos-header'>
      <h1 class="demos-title">jQuery WeUI</h1>
      <p class='demos-sub-title'>轻量强大的UI库，不仅仅是 WeUI</p>
</header>
<div >
    <div class="shop_header">
        <i class="shop_icon"></i>
        <strong><?=UtilService::encode($info['name']); ?></strong>
    </div>

    <div class="fastway_list_box">
      
          <?=$info['description']; ?></li>
       
    </div>
</div>


<div class="weui-grids">
      <a href="<?=UrlService::buildMUrl('/equipment/info')?>" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_button.png" alt="">
        </div>
        <p class="weui-grid__label">
          	扫描 
        </p>
      </a>
      <a href="<?=UrlService::buildMUrl('/equip/info')?>" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_cell.png" alt="">
        </div>
        <p class="weui-grid__label">
          	设备
        </p>
      </a>
      <a href="<?=UrlService::buildMUrl('/task/index')?>" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_cell.png" alt="">
        </div>
        <p class="weui-grid__label">
          	任务
        </p>
      </a>
      <a href="flex.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_cell.png" alt="">
        </div>
        <p class="weui-grid__label">
          Flex
        </p>
      </a>
      <a href="toast.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_toast.png" alt="">
        </div>
        <p class="weui-grid__label">
          Toast
        </p>
      </a>
      <a href="dialog.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_dialog.png" alt="">
        </div>
        <p class="weui-grid__label">
          Dialog
        </p>
      </a>
      <a href="progress.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_progress.png" alt="">
        </div>
        <p class="weui-grid__label">
          Progress
        </p>
      </a>
      <a href="msg.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_msg.png" alt="">
        </div>
        <p class="weui-grid__label">
          Msg
        </p>
      </a>
      <a href="article.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_article.png" alt="">
        </div>
        <p class="weui-grid__label">
          Article
        </p>
      </a>
      <a href="action-sheet.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_actionSheet.png" alt="">
        </div>
        <p class="weui-grid__label">
          ActionSheet
        </p>
      </a>
      <a href="icons.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_icons.png" alt="">
        </div>
        <p class="weui-grid__label">
          Icons
        </p>
      </a>
      <a href="panel.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_panel.png" alt="">
        </div>
        <p class="weui-grid__label">
          Panel
        </p>
      </a>
      <a href="navbar.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_tab.png" alt="">
        </div>
        <p class="weui-grid__label">
          Navbar
        </p>
      </a>
      <a href="tabbar.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_tab.png" alt="">
        </div>
        <p class="weui-grid__label">
          Tabbar
        </p>
      </a>
      <a href="searchbar.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_search_bar.png" alt="">
        </div>
        <p class="weui-grid__label">
          SearchBar
        </p>
      </a>
      <a href="toptip.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_msg.png" alt="">
        </div>
        <p class="weui-grid__label">
          Toptip
        </p>
      </a>
      <a href="loadmore.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_new.png" alt="">
        </div>
        <p class="weui-grid__label">
          Loadmore
        </p>
      </a>
      <a href="slider.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_new.png" alt="">
        </div>
        <p class="weui-grid__label">
          Slider
        </p>
      </a>
      <a href="uploader.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_new.png" alt="">
        </div>
        <p class="weui-grid__label">
          Uploader
        </p>
      </a>
      <a href="badge.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_new.png" alt="">
        </div>
        <p class="weui-grid__label">
          Badge
        </p>
      </a>
      <a href="footer.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_new.png" alt="">
        </div>
        <p class="weui-grid__label">
          Footer
        </p>
      </a>
      <a href="preview.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_new.png" alt="">
        </div>
        <p class="weui-grid__label">
          Preview
        </p>
      </a>
      <a href="gallery.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_new.png" alt="">
        </div>
        <p class="weui-grid__label">
          Gallery
        </p>
      </a>
      <a href="swipeout.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_new.png" alt="">
        </div>
        <p class="weui-grid__label">
          Swipeout
        </p>
      </a>
    </div>

    <div class="demos-header">
      <h2 class='demos-second-title'>拓展组件</h2>
      <p class='demos-sub-title'>jQuery WeUI 专属组件</p>
    </div>

    <div class="weui-grids">
      <a href="ptr.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_ptr.png" alt="">
        </div>
        <p class="weui-grid__label">
          下拉刷新
        </p>
      </a>
      <a href="infinite.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_up.png" alt="">
        </div>
        <p class="weui-grid__label">
          滚动加载
        </p>
      </a>
      <a href="picker.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_picker.png" alt="">
        </div>
        <p class="weui-grid__label">
          Picker
        </p>
      </a>
      <a href="calendar.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_calendar.png" alt="">
        </div>
        <p class="weui-grid__label">
          Calendar
        </p>
      </a>
      <a href="city-picker.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_city.png" alt="">
        </div>
        <p class="weui-grid__label">
          City Picker
        </p>
      </a>
      <a href="datetime-picker.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_datetime.png" alt="">
        </div>
        <p class="weui-grid__label">
          Datetime
        </p>
      </a>
      <a href="swiper.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_swiper.png" alt="">
        </div>
        <p class="weui-grid__label">
          Swiper
        </p>
      </a>
      <a href="noti.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_msg.png" alt="">
        </div>
        <p class="weui-grid__label">
          Notification
        </p>
      </a>
      <a href="select.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_select.png" alt="">
        </div>
        <p class="weui-grid__label">
          Select
        </p>
      </a>
      <a href="popup.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_panel.png" alt="">
        </div>
        <p class="weui-grid__label">
          Popup
        </p>
      </a>
      <a href="photo-browser.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_photo.png" alt="">
        </div>
        <p class="weui-grid__label">
          Photos
        </p>
      </a>
      <a href="count.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_new.png" alt="">
        </div>
        <p class="weui-grid__label">
          Count
        </p>
      </a>
    </div>

    <div class="demos-header">
      <h2 class='demos-second-title'>模板</h2>
      <p class='demos-sub-title'>常见的页面模板</p>
    </div>

    <div class="weui-grids">
      <a href="tpl-shopping-cart.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_new.png" alt="">
        </div>
        <p class="weui-grid__label">
          购物车
        </p>
      </a>
      <a href="tpl-chat.html" class="weui-grid js_grid">
        <div class="weui-grid__icon">
          <img src="/images/m/icon_nav_new.png" alt="">
        </div>
        <p class="weui-grid__label">
          聊天
        </p>
      </a>
    </div>