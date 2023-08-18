<?php /**  
    * 时光轴
    *  
    * @package custom  
    */  
    if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <?php $this->need('public/include.php'); ?>
  <?php if ($this->options->JPrismTheme) : ?>
    <link href="<?php $this->options->JPrismTheme() ?>" rel="stylesheet">
  <?php else : ?>
    <link href="<?php _getAssets('assets/lib/prism/prism.min.css'); ?>" rel="stylesheet">
  <?php endif; ?>
  <link href="<?php _getAssets('assets/css/archives.css'); ?>" rel="stylesheet"/>
  <script src="<?php _getAssets('assets/lib/clipboard@2.0.11/clipboard.min.js'); ?>"></script>
  <script src="<?php _getAssets('assets/lib/prism/prism.min.js'); ?>"></script>
  <script src="<?php _getAssets('assets/js/joe.post_page.min.js'); ?>"></script>
</head>

<body>
  <div id="Joe">
    <?php $this->need('public/header.php'); ?>
    <div class="joe_container">
      <div class="joe_main">
        <div class="joe_detail" data-cid="<?php echo $this->cid ?>">
          <?php $this->need('public/batten.php'); ?>
            
<?php /*         <div class="archives">
            <div class="archive-month">
                <h2>2023年05月</h2>
                <ul class="archive-list">
                    <li>
                        <time class="cbp_tmtime">
                            <span>17日</span>
                        </time>
                        <div class="cbp_tmlabel">
                            <a href="https://maomao.ink/index.php/web/1842.html">小程序实现不新开webview跳转H5页面</a
                            >
                        </div>
                    </li>
                </ul>
            </div>
          </div>
          */
?>

            <?php
            $this->widget("Widget_Contents_Post_Recent", "pageSize=10000")->to(
                $archives
            );
            $year = 0;
            $mon = 0;
            $i = 0;
            $j = 0;
            $last_month = '';
            $output = '<div id="archives" class="archives">';
            while ($archives->next()):
                $this_month = date("Y年m月", $archives->created);
                if ($this_month != $last_month) {
                  //不同月份
                  if( $last_month != '' ){
                    //需要给上一个月份做结尾
                    $output .= '</ul></div>';
                  }
                  //需要显示新的月开头
                  $output .= '<div class="archive-month"><h2>' . $this_month . '</h2><ul class="archive-list">';
                  $last_month = $this_month;
                }
                $output .= '<li><time class="cbp_tmtime"><span>' 
                  . date("d日: ", $archives->created) . 
                  '</span></time><div class="cbp_tmlabel"><a href="' 
                  . $archives->permalink . 
                  '">' . $archives->title .
                  '</a></div></li>';                
            endwhile;
            if( $last_month != '' ){
              //需要给上一个月份做结尾
              $output .= '</ul></div>';
            }
            $output .= "</div>";
            echo $output;
            ?>



          <?php $this->need('public/handle.php'); ?>
          <?php $this->need('public/copyright.php'); ?>
        </div>
        <?php $this->need('public/comment.php'); ?>
      </div>
      <?php $this->need('public/aside.php'); ?>
    </div>
    <?php $this->need('public/footer.php'); ?>
  </div>
</body>

</html>