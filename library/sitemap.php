<?php

$db = Typecho_Db::get();
$options = Typecho_Widget::widget('Widget_Options');
$limit = Helper::options()->JSiteMap;
$pages = $db->fetchAll(
    $db->select()->from('table.contents')
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.created < ?', $options->gmtTime)
        ->where('table.contents.type = ?', 'page')
        ->limit($limit)
        ->order('table.contents.created', Typecho_Db::SORT_DESC)
);
$articles = $db->fetchAll(
    $db->select()->from('table.contents')
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.created < ?', $options->gmtTime)
        ->where('table.contents.type = ?', 'post')
        ->limit($limit)
        ->order('table.contents.created', Typecho_Db::SORT_DESC)
);
header("Content-Type: application/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
foreach ($pages as $page) {
    $type = $page['type'];
    $routeExists = (NULL != Typecho_Router::get($type));
    $page['pathinfo'] = $routeExists ? Typecho_Router::url($type, $page) : '#';
    $page['permalink'] = Typecho_Common::url($page['pathinfo'], $options->index);
    echo "\t<url>\n";
    echo "\t\t<loc>" . $page['permalink'] . "</loc>\n";
    echo "\t\t<lastmod>" . date('Y-m-d\TH:i:s\Z', $page['modified']) . "</lastmod>\n";
    echo "\t\t<changefreq>monthly</changefreq>\n";
    echo "\t\t<priority>0.8</priority>\n";
    echo "\t</url>\n";
}
foreach ($articles as $article) {
    $type = $article['type'];
    $article['categories'] = $db->fetchAll($db->select()->from('table.metas')
        ->join('table.relationships', 'table.relationships.mid = table.metas.mid')
        ->where('table.relationships.cid = ?', $article['cid'])
        ->where('table.metas.type = ?', 'category')
        ->order('table.metas.order', Typecho_Db::SORT_ASC));
    $article['category'] = urlencode(current(Typecho_Common::arrayFlatten($article['categories'], 'slug')));
    $article['slug'] = urlencode($article['slug']);
    $article['date'] = new Typecho_Date($article['created']);
    $article['year'] = $article['date']->year;
    $article['month'] = $article['date']->month;
    $article['day'] = $article['date']->day;
    $routeExists = (NULL != Typecho_Router::get($type));
    $article['pathinfo'] = $routeExists ? Typecho_Router::url($type, $article) : '#';
    $article['permalink'] = Typecho_Common::url($article['pathinfo'], $options->index);
    echo "\t<url>\n";
    echo "\t\t<loc>" . $article['permalink'] . "</loc>\n";
    echo "\t\t<lastmod>" . date('Y-m-d\TH:i:s\Z', $article['modified']) . "</lastmod>\n";
    echo "\t\t<changefreq>monthly</changefreq>\n";
    echo "\t\t<priority>0.5</priority>\n";
    echo "\t</url>\n";
}
echo "</urlset>";
