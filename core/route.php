<?php
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
            "title" => $item->title,
            "abstract" => _getAbstract($item, false),
            "category" => $item->categories,
            "views" => number_format($item->views),
            "commentsNum" => number_format($item->commentsNum),
            "agree" => number_format($item->agree),
            "permalink" => $item->permalink,
            "lazyload" => _getLazyload(false)
        );
    };
    $self->response->throwJson(array("data" => $result));
}
