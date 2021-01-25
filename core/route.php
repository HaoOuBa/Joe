<?php

/* 排行榜 */
function _getRanking($self)
{
    header("HTTP/1.1 200 OK");
    $ranking_txt = Helper::options()->JAside_Ranking;
    $ranking_arr = explode("$", $ranking_txt);
    $arrContextOptions = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false,]];
    $json = file_get_contents("https://the.top/v1/{$ranking_arr[1]}/1/9", false, stream_context_create($arrContextOptions));
    $res = json_decode($json, TRUE);
    if ($res['code'] === 0) {
        $self->response->throwJson([
            "code" => 1,
            "title" => $ranking_arr[0],
            "data" => $res["data"]
        ]);
    } else {
        $self->response->throwJson([
            "code" => 0,
            "title" => $ranking_arr[0],
            "data" => null
        ]);
    }
}

/* 列表 */
function _getPost($self)
{
    header("HTTP/1.1 200 OK");
    $page = $self->request->page;
    $pageSize = $self->request->pageSize;
    $type = $self->request->type;
    $result = [];
    $self->widget('Widget_Contents_Sort', 'page=' . $page . '&pageSize=' . $pageSize . '&type=' . $type)->to($item);
    while ($item->next()) {
        $result[] = array(
            "image" => _getThumbnail($item, false),
            "time" => date('Y-m-d', $item->created),
            "created" => date('Y年m月d日', $item->created),
            "title" => _getEncryptionTitle($item, false),
            "abstract" => _getAbstract($item, false),
            "category" => $item->categories,
            "views" => _getViews($item, false),
            "commentsNum" => number_format($item->commentsNum),
            "agree" => _getAgree($item, false),
            "permalink" => $item->permalink,
            "lazyload" => _getLazyload(false)
        );
    };
    $self->response->throwJson(array("data" => $result));
}

/* 浏览量 */
function _handleViews($self)
{
    header("HTTP/1.1 200 OK");
    $cid     = $self->request->cid;
    $db = Typecho_Db::get();
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if (sizeof($row) > 0) {
        $db->query($db->update('table.contents')->rows(array('views' => (int)$row['views'] + 1))->where('cid = ?', $cid));
        $self->response->throwJson(array(
            "code" => 1,
            "data" => $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid))
        ));
    } else {
        $self->response->throwJson(array("code" => 0, "data" => null));
    }
}

/* 点赞 */
function _handleAgree($self)
{
    header("HTTP/1.1 200 OK");
    $cid = $self->request->cid;
    $type = $self->request->type;
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
            "data" => $db->fetchRow($db->select('agree')->from('table.contents')->where('cid = ?', $cid))
        ));
    } else {
        $self->response->throwJson(array("code" => 0, "data" => null));
    }
}

/* 收录 */
function _getRecord($self)
{
    header("HTTP/1.1 200 OK");
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
    curl_setopt($ch, CURLOPT_REFERER, "https://www.baidu.com/s?ie=UTF-8&wd={$url}");
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