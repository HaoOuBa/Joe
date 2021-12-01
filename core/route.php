<?php

/* 获取文章列表 已测试 √  */
function _getPost($self)
{
    $self->response->setStatus(200);

    $page = $self->request->page;
    $pageSize = $self->request->pageSize;
    $type = $self->request->type;

    /* sql注入校验 */
    if (!preg_match('/^\d+$/', $page)) {
        return $self->response->throwJson(array("data" => "非法请求！已屏蔽！"));
    }
    if (!preg_match('/^\d+$/', $pageSize)) {
        return $self->response->throwJson(array("data" => "非法请求！已屏蔽！"));
    }
    if (!preg_match('/^[created|views|commentsNum|agree]+$/', $type)) {
        return $self->response->throwJson(array("data" => "非法请求！已屏蔽！"));
    }

    /* 如果传入0，强制赋值1 */
    if ($page == 0) $page = 1;
    $result = [];
    /* 增加置顶文章功能，通过JS判断（如果你想添加其他标签的话，请先看置顶如何实现的） */
    $sticky_text = Helper::options()->JIndexSticky;
    if ($sticky_text && $page == 1) {
        $sticky_arr = explode("||", $sticky_text);
        foreach ($sticky_arr as $cid) {
            $self->widget('Widget_Contents_Post@' . $cid, 'cid=' . $cid)->to($item);
            if ($item->next()) {
                $result[] = array(
                    "mode" => $item->fields->mode ? $item->fields->mode : 'default',
                    "image" => _getThumbnails($item),
                    "time" => date('Y-m-d', $item->created),
                    "created" => date('Y年m月d日', $item->created),
                    "title" => $item->title,
                    "abstract" => _getAbstract($item, false),
                    "category" => $item->categories,
                    "views" => _getViews($item, false),
                    "commentsNum" => number_format($item->commentsNum),
                    "agree" => _getAgree($item, false),
                    "permalink" => $item->permalink,
                    "lazyload" => _getLazyload(false),
                    "type" => "sticky",
                );
            }
        }
    }
    $self->widget('Widget_Contents_Sort', 'page=' . $page . '&pageSize=' . $pageSize . '&type=' . $type)->to($item);
    while ($item->next()) {
        $result[] = array(
            "mode" => $item->fields->mode ? $item->fields->mode : 'default',
            "image" => _getThumbnails($item),
            "time" => date('Y-m-d', $item->created),
            "created" => date('Y年m月d日', $item->created),
            "title" => $item->title,
            "abstract" => _getAbstract($item, false),
            "category" => $item->categories,
            "views" => number_format($item->views),
            "commentsNum" => number_format($item->commentsNum),
            "agree" => number_format($item->agree),
            "permalink" => $item->permalink,
            "lazyload" => _getLazyload(false),
            "type" => "normal"
        );
    };

    $self->response->throwJson(array("data" => $result));
}

/* 增加浏览量 已测试 √ */
function _handleViews($self)
{
    $self->response->setStatus(200);

    $cid = $self->request->cid;

    /* sql注入校验 */
    if (!preg_match('/^\d+$/',  $cid)) {
        return $self->response->throwJson(array("code" => 0, "data" => "非法请求！已屏蔽！"));
    }
    $db = Typecho_Db::get();
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if (sizeof($row) > 0) {
        $db->query($db->update('table.contents')->rows(array('views' => (int)$row['views'] + 1))->where('cid = ?', $cid));
        $self->response->throwJson(array(
            "code" => 1,
            "data" => array('views' => number_format($db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid))['views']))
        ));
    } else {
        $self->response->throwJson(array("code" => 0, "data" => null));
    }
}

/* 点赞和取消点赞 已测试 √ */
function _handleAgree($self)
{
    $self->response->setStatus(200);

    $cid = $self->request->cid;
    $type = $self->request->type;

    /* sql注入校验 */
    if (!preg_match('/^\d+$/',  $cid)) {
        return $self->response->throwJson(array("code" => 0, "data" => "非法请求！已屏蔽！"));
    }
    /* sql注入校验 */
    if (!preg_match('/^[agree|disagree]+$/', $type)) {
        return $self->response->throwJson(array("code" => 0, "data" => "非法请求！已屏蔽！"));
    }
    $db = Typecho_Db::get();
    $row = $db->fetchRow($db->select('agree')->from('table.contents')->where('cid = ?', $cid));
    if (sizeof($row) > 0) {
        if ($type === "agree") {
            $db->query($db->update('table.contents')->rows(array('agree' => (int)$row['agree'] + 1))->where('cid = ?', $cid));
        } else {
            $db->query($db->update('table.contents')->rows(array('agree' => (int)$row['agree'] - 1))->where('cid = ?', $cid));
        }
        $self->response->throwJson(array(
            "code" => 1,
            "data" => array('agree' => number_format($db->fetchRow($db->select('agree')->from('table.contents')->where('cid = ?', $cid))['agree']))
        ));
    } else {
        $self->response->throwJson(array("code" => 0, "data" => null));
    }
}

/* 查询是否收录 已测试 √ */
function _getRecord($self)
{
    $self->response->setStatus(200);

    $site = $self->request->site;
    $encryption = md5(mt_rand(1655, 100860065) . time());
    $baiduSite = "https://www.baidu.com/s?ie=utf-8&newi=1&mod=1&isid={$encryption}&wd={$site}&rsv_spt=1&rsv_iqid={$encryption}&issp=1&f=8&rsv_bp=1&rsv_idx=2&ie=utf-8&tn=baiduhome_pg&rsv_enter=0&rsv_dl=ib&rsv_sug3=2&rsv_sug1=1&rsv_sug7=001&rsv_n=2&rsv_btype=i&inputT=3083&rsv_sug4=3220&rsv_sug=9&rsv_sid=32818_1460_33042_33060_31660_33099_33101_32961_26350_22159&_ss=1&clist=&hsug=&f4s=1&csor=38&_cr1=32951";
    $ip = mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255) . '.' . mt_rand(0, 255);
    $header[] = "accept-encoding: gzip, deflate";
    $header[] = "accept-language: en-US,en;q=0.8";
    $header[] = "CLIENT-IP:" . $ip;
    $header[] = "X-FORWARDED-FOR:" . $ip;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $baiduSite);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_REFERER, "https://www.baidu.com/s?ie=UTF-8&wd={$site}");
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $output = curl_exec($ch);
    curl_close($ch);
    $res = str_replace([' ', "\n", "\r"], '', $output);
    if (strpos($res, "抱歉，没有找到与") || strpos($res, "找到相关结果约0个") || strpos($res, "没有找到该URL") || strpos($res, "抱歉没有找到")) {
        $self->response->throwJson(array("data" => "未收录"));
    } else {
        $self->response->throwJson(array("data" => "已收录"));
    }
}

/* 主动推送到百度收录 已测试 √ */
function _pushRecord($self)
{
    $self->response->setStatus(200);

    $token = Helper::options()->JBaiduToken;
    $domain = $self->request->domain;
    $url = $self->request->url;
    $urls = explode(",", $url);
    $api = "http://data.zz.baidu.com/urls?site={$domain}&token={$token}";
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => implode("\n", $urls),
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    curl_close($ch);
    $self->response->throwJson(array(
        'domain' => $domain,
        'url' => $url,
        'data' => json_decode($result, TRUE)
    ));
}

/* 获取壁纸分类 已测试 √ */
function _getWallpaperType($self)
{
    $self->response->setStatus(200);

    $json = _curl("http://cdn.apc.360.cn/index.php?c=WallPaper&a=getAllCategoriesV2&from=360chrome");
    $res = json_decode($json, TRUE);
    if ($res['errno'] == 0) {
        $self->response->throwJson([
            "code" => 1,
            "data" => $res['data']
        ]);
    } else {
        $self->response->throwJson([
            "code" => 0,
            "data" => null
        ]);
    }
}

/* 获取壁纸列表 已测试 √ */
function _getWallpaperList($self)
{
    $self->response->setStatus(200);

    $cid = $self->request->cid;
    $start = $self->request->start;
    $count = $self->request->count;
    $json = _curl("http://wallpaper.apc.360.cn/index.php?c=WallPaper&a=getAppsByCategory&cid={$cid}&start={$start}&count={$count}&from=360chrome");
    $res = json_decode($json, TRUE);
    if ($res['errno'] == 0) {
        $self->response->throwJson([
            "code" => 1,
            "data" => $res['data'],
            "total" => $res['total']
        ]);
    } else {
        $self->response->throwJson([
            "code" => 0,
            "data" => null
        ]);
    }
}

/* 抓取苹果CMS视频分类 已测试 √ */
function _getMaccmsList($self)
{
    $self->response->setStatus(200);

    $cms_api = Helper::options()->JMaccmsAPI;
    $ac = $self->request->ac ? $self->request->ac : '';
    $ids = $self->request->ids ? $self->request->ids : '';
    $t = $self->request->t ? $self->request->t : '';
    $pg = $self->request->pg ? $self->request->pg : '';
    $wd = $self->request->wd ? $self->request->wd : '';
    if ($cms_api) {
        $json = _curl("{$cms_api}?ac={$ac}&ids={$ids}&t={$t}&pg={$pg}&wd={$wd}");
        $res = json_decode($json, TRUE);
        if ($res['code'] === 1) {
            $self->response->throwJson([
                "code" => 1,
                "data" => $res,
            ]);
        } else {
            $self->response->throwJson([
                "code" => 0,
                "data" => "抓取失败！请联系作者！"
            ]);
        }
    } else {
        $self->response->throwJson([
            "code" => 0,
            "data" => "后台苹果CMS API未填写！"
        ]);
    }
}

/* 获取虎牙视频列表 已测试 √ */
function _getHuyaList($self)
{
    $self->response->setStatus(200);

    $gameId = $self->request->gameId;
    $page = $self->request->page;
    $json = _curl("https://www.huya.com/cache.php?m=LiveList&do=getLiveListByPage&gameId={$gameId}&tagAll=0&page={$page}");
    $res = json_decode($json, TRUE);
    if ($res['status'] === 200) {
        $self->response->throwJson([
            "code" => 1,
            "data" => $res['data'],
        ]);
    } else {
        $self->response->throwJson([
            "code" => 0,
            "data" => "抓取失败！请联系作者！"
        ]);
    }
}

/* 获取服务器状态 */
function _getServerStatus($self)
{
    $self->response->setStatus(200);

    $api_panel = Helper::options()->JBTPanel;
    $api_sk = Helper::options()->JBTKey;
    if (!$api_panel) return $self->response->throwJson([
        "code" => 0,
        "data" => "宝塔面板地址未填写！"
    ]);
    if (!$api_sk) return $self->response->throwJson([
        "code" => 0,
        "data" => "宝塔接口密钥未填写！"
    ]);
    $request_time = time();
    $request_token = md5($request_time . '' . md5($api_sk));
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_panel . '/system?action=GetNetWork');
    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 3000);
    curl_setopt($ch, CURLOPT_TIMEOUT_MS, 3000);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,  array("request_time" => $request_time, "request_token" => $request_token));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response  = json_decode(curl_exec($ch), true);
    curl_close($ch);
    $self->response->throwJson(array(
        /* 状态 */
        "status" => $response ? true : false,
        /* 信息提示 */
        "message" => $response['msg'],
        /* 上行流量KB */
        "up" => $response["up"] ? $response["up"] : 0,
        /* 下行流量KB */
        "down" => $response["down"] ? $response["down"] : 0,
        /* 总发送（字节数） */
        "upTotal" => $response["upTotal"] ? $response["upTotal"] : 0,
        /* 总接收（字节数） */
        "downTotal" => $response["downTotal"] ? $response["downTotal"] : 0,
        /* 内存占用 */
        "memory" => $response["mem"] ? $response["mem"] : ["memBuffers" => 0, "memCached" => 0, "memFree" => 0, "memRealUsed" => 0, "memTotal" => 0],
        /* CPU */
        "cpu" => $response["cpu"] ? $response["cpu"] : [0, 0, [0], 0, 0, 0],
        /* 系统负载 */
        "load" => $response["load"] ? $response["load"] : ["fifteen" => 0, "five" => 0, "limit" => 0, "max" => 0, "one" => 0, "safe" => 0],
    ));
}

/* 获取最近评论 */
function _getCommentLately($self)
{
    $self->response->setStatus(200);

    $time = time();
    $num = 7;
    $categories = [];
    $series = [];
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    for ($i = ($num - 1); $i >= 0; $i--) {
        $date = date("Y/m/d", $time - ($i * 24 * 60 * 60));
        $sql = "SELECT coid FROM `{$prefix}comments` WHERE FROM_UNIXTIME(created, '%Y/%m/%d') = '{$date}' limit 100";
        $count = count($db->fetchAll($sql));
        $categories[] = $date;
        $series[] = $count;
    }
    $self->response->throwJson([
        "categories" => $categories,
        "series" => $series,
    ]);
}

/* 获取文章归档 */
function _getArticleFiling($self)
{
    $self->response->setStatus(200);

    $page = $self->request->page;
    $pageSize = 8;
    if (!preg_match('/^\d+$/', $page)) return $self->response->throwJson(array("data" => "非法请求！已屏蔽！"));
    if ($page == 0) $page = 1;
    $offset = $pageSize * ($page - 1);
    $time = time();
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $result = [];
    $sql = "SELECT FROM_UNIXTIME(created, '%Y 年 %m 月') as date FROM `{$prefix}contents` WHERE created < {$time} AND (password is NULL or password = '') AND status = 'publish' AND type = 'post' GROUP BY FROM_UNIXTIME(created, '%Y 年 %m 月') DESC LIMIT {$pageSize} OFFSET {$offset}";
    $temp = $db->fetchAll($sql);
    $options = Typecho_Widget::widget('Widget_Options');
    foreach ($temp as $item) {
        $date = $item['date'];
        $list = [];
        $sql = "SELECT * FROM `{$prefix}contents` WHERE created < {$time} AND (password is NULL or password = '') AND status = 'publish' AND type = 'post' AND FROM_UNIXTIME(created, '%Y 年 %m 月') = '{$date}' ORDER BY created DESC LIMIT 100";
        $_list = $db->fetchAll($sql);
        foreach ($_list as $_item) {
            $type = $_item['type'];
            $_item['categories'] = $db->fetchAll($db->select()->from('table.metas')
                ->join('table.relationships', 'table.relationships.mid = table.metas.mid')
                ->where('table.relationships.cid = ?', $_item['cid'])
                ->where('table.metas.type = ?', 'category')
                ->order('table.metas.order', Typecho_Db::SORT_ASC));
            $_item['category'] = urlencode(current(Typecho_Common::arrayFlatten($_item['categories'], 'slug')));
            $_item['slug'] = urlencode($_item['slug']);
            $_item['date'] = new Typecho_Date($_item['created']);
            $_item['year'] = $_item['date']->year;
            $_item['month'] = $_item['date']->month;
            $_item['day'] = $_item['date']->day;
            $routeExists = (NULL != Typecho_Router::get($type));
            $_item['pathinfo'] = $routeExists ? Typecho_Router::url($type, $_item) : '#';
            $_item['permalink'] = Typecho_Common::url($_item['pathinfo'], $options->index);
            $list[] = array(
                "title" => date('m/d', $_item['created']) . '：' . $_item['title'],
                "permalink" => $_item['permalink'],
            );
        }
        $result[] = array("date" => $date, "list" => $list);
    }
    $self->response->throwJson($result);
}
