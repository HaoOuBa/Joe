<?php

/**
 * 统计
 * 
 * @package custom 
 * 
 **/

?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <?php $this->need('public/include.php'); ?>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/joe.census.min.css'); ?>">
    <script src="https://fastly.jsdelivr.net/npm/echarts@5.1.1/dist/echarts.min.js"></script>
    <script src="<?php $this->options->themeUrl('assets/js/joe.census.min.js'); ?>"></script>
</head>

<body>
    <div id="Joe">
        <?php $this->need('public/header.php'); ?>
        <div class="joe_container">
            <div class="joe_main">
                <?php Typecho_Widget::widget('Widget_Stat')->to($item); ?>
                <!-- 基础统计 -->
                <div class="joe_census__basic">
                    <div class="joe_census__basic-item list">
                        <div class="list">
                            <div class="count">
                                <h6>文章数</h6>
                                <p><?php echo number_format($item->publishedPostsNum); ?></p>
                            </div>
                            <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="30" height="30">
                                <path d="M947.2 298.667c0-34.134-12.8-68.267-38.4-89.6L814.933 115.2c-51.2-51.2-132.266-51.2-179.2 0l-512 516.267c-25.6 21.333-38.4 55.466-38.4 89.6v132.266c0 46.934 38.4 85.334 81.067 85.334h682.667c25.6 0 42.666-17.067 42.666-42.667s-17.066-42.667-42.666-42.667h-409.6L908.8 388.267c25.6-25.6 38.4-55.467 38.4-89.6zM170.667 853.333V721.067c0-12.8 4.266-21.334 12.8-29.867l413.866-418.133 153.6 153.6-413.866 413.866c-8.534 8.534-21.334 12.8-34.134 12.8H170.667zm678.4-524.8l-38.4 38.4-153.6-153.6 38.4-38.4c8.533-8.533 21.333-12.8 29.866-12.8 12.8 0 21.334 4.267 29.867 12.8l93.867 93.867c8.533 8.533 12.8 17.067 12.8 29.867s-4.267 21.333-12.8 29.866z" />
                            </svg>
                        </div>
                        <div class="list">
                            <div class="count">
                                <h6>评论数</h6>
                                <p><?php echo number_format($item->publishedCommentsNum); ?></p>
                            </div>
                            <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="32" height="32">
                                <path d="M511.914 928.016c-8.257 0-16.341-3.096-22.706-9.46l-95.984-95.985c-12.557-12.557-12.557-32.682 0-45.24s32.683-12.556 45.24 0l73.45 73.45 73.45-73.45c6.02-6.02 14.105-9.46 22.706-9.46h223.962c17.718 0 31.995-14.277 31.995-31.995V223.962c0-17.545-14.277-31.994-31.995-31.994H192.14c-17.546 0-31.995 14.449-31.995 31.994v511.914c0 17.718 14.45 31.995 31.995 31.995h95.984c17.717 0 31.994 14.277 31.994 31.995s-14.277 31.994-31.994 31.994H192.14c-52.98 0-95.984-43.003-95.984-95.984V223.962c0-52.98 43.003-95.984 95.984-95.984h639.892c52.98 0 95.984 43.004 95.984 95.984v511.914c0 52.98-43.003 95.984-95.984 95.984H621.143l-86.523 86.695c-6.193 6.193-14.45 9.461-22.706 9.461z" />
                                <path d="M335.944 511.914c-26.49 0-47.992-21.502-47.992-47.992s21.501-47.992 47.992-47.992 47.991 21.502 47.991 47.992-21.501 47.992-47.991 47.992zm191.967 0c-26.49 0-47.992-21.502-47.992-47.992s21.502-47.992 47.992-47.992 47.992 21.502 47.992 47.992-21.502 47.992-47.992 47.992zm192.14 0c-26.49 0-47.992-21.502-47.992-47.992s21.502-47.992 47.992-47.992 47.992 21.502 47.992 47.992-21.674 47.992-47.992 47.992z" />
                            </svg>
                        </div>
                        <div class="list">
                            <div class="count">
                                <h6>分类数</h6>
                                <p><?php echo number_format($item->categoriesNum); ?></p>
                            </div>
                            <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="28" height="28">
                                <path d="M166.79 123.639v778.578l311.724-133.273a86.303 86.303 0 0 1 64.857-1.208L857.21 888.279v-764.64H166.79zM145.215 58.91h733.57a43.151 43.151 0 0 1 43.152 43.152v817.608a43.151 43.151 0 0 1-58.62 40.282l-343.14-131.806a21.576 21.576 0 0 0-16.225.303L162.194 974.582a43.151 43.151 0 0 1-60.132-39.678V102.062a43.151 43.151 0 0 1 43.153-43.15z" />
                                <path d="M329.816 411.307a32.363 32.363 0 1 1 0-64.727h364.368a32.363 32.363 0 1 1 0 64.727H329.816zm0 170.814a32.363 32.363 0 1 1 0-64.728h364.368a32.363 32.363 0 1 1 0 64.728H329.816z" />
                            </svg>
                        </div>
                        <div class="list">
                            <div class="count">
                                <h6>页面数</h6>
                                <p><?php echo number_format($item->publishedPagesNum + $item->publishedPostsNum); ?></p>
                            </div>
                            <svg class="icon" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" width="26" height="26">
                                <path d="M653.824 32.256l264.96 264.704c20.48 20.48 32.256 48.384 32.256 77.568v539.648c0 60.672-49.152 109.824-109.824 109.824H182.784c-60.672 0-109.824-49.152-109.824-109.824V109.824C73.216 49.152 122.368 0 182.784 0h393.472c29.184 0 57.088 11.52 77.568 32.256zm-32 71.168v225.792H847.36L621.824 103.424zm-60.672-30.208H182.784c-20.224 0-36.608 16.384-36.608 36.608v804.608c0 20.224 16.384 36.608 36.608 36.608H840.96c20.224 0 36.608-16.384 36.608-36.608v-524.8 12.544h-256c-40.448 0-73.216-32.768-73.216-73.216v-256h12.8zm0 0" />
                            </svg>
                        </div>
                    </div>
                    <div class="joe_census__basic-item category">
                        <?php $this->widget('Widget_Metas_Category_List')->to($item); ?>
                        <ul>
                            <?php while ($item->next()) : ?>
                                <li data-name="<?php $item->name() ?>" data-value="<?php $item->count() ?>"></li>
                            <?php endwhile; ?>
                        </ul>
                        <div id="category"></div>
                    </div>
                </div>
                <div class="joe_census__lately">
                    <div class="title">最近评论</div>
                    <div class="content">
                        <div id="lately"></div>
                    </div>
                </div>
                <?php if ($this->options->JBTPanel && $this->options->JBTKey) : ?>
                    <div class="joe_census__server">
                        <div class="joe_census__server-item">
                            <div class="title">
                                <span>实时负载</span>
                                <div class="count">
                                    <span class="core">0 核</span>
                                    <span class="split">/</span>
                                    <span class="ram">0 MB</span>
                                </div>
                            </div>
                            <div class="content">
                                <div id="work"></div>
                            </div>
                        </div>
                        <div class="joe_census__server-item">
                            <div class="title">
                                <span>实时流量</span>
                                <div class="count">
                                    <span class="up">总发送：0 B</span>
                                    <span class="split">/</span>
                                    <span class="down">总接收：0 B</span>
                                </div>
                            </div>
                            <div class="content">
                                <div id="flow"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="joe_census__filing">
                    <div class="title">文章归档</div>
                    <div class="content">
                        <div id="filing"></div>
                        <div class="item load">
                            <div class="tail"></div>
                            <div class="head"></div>
                            <button class="button">加载更多</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->need('public/footer.php'); ?>
    </div>
</body>

</html>