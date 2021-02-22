<?php

/* 获取主题当前版本号 */
function _getVersion()
{
	return "5.3.8";
};

/* 判断是否是手机 */
function _isMobile()
{
	if (isset($_SERVER['HTTP_X_WAP_PROFILE']))
		return true;
	if (isset($_SERVER['HTTP_VIA'])) {
		return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
	}
	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		$clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
		if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
			return true;
	}
	if (isset($_SERVER['HTTP_ACCEPT'])) {
		if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
			return true;
		}
	}
	return false;
}

/* 根据评论agent获取浏览器类型 */
function _getAgentBrowser($agent)
{
	if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
		$outputer = 'Internet Explore';
	} else if (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {
		$outputer = 'FireFox';
	} else if (preg_match('/Maxthon([\d]*)\/([^\s]+)/i', $agent, $regs)) {
		$outputer = 'MicroSoft Edge';
	} else if (preg_match('#360([a-zA-Z0-9.]+)#i', $agent, $regs)) {
		$outputer = '360 Fast Browser';
	} else if (preg_match('/Edge([\d]*)\/([^\s]+)/i', $agent, $regs)) {
		$outputer = 'MicroSoft Edge';
	} else if (preg_match('/UC/i', $agent)) {
		$outputer = 'UC Browser';
	} else if (preg_match('/QQ/i', $agent, $regs) || preg_match('/QQ Browser\/([^\s]+)/i', $agent, $regs)) {
		$outputer = 'QQ Browser';
	} else if (preg_match('/UBrowser/i', $agent, $regs)) {
		$outputer = 'UC Browser';
	} else if (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {
		$outputer = 'Opera';
	} else if (preg_match('/Chrome([\d]*)\/([^\s]+)/i', $agent, $regs)) {
		$outputer = 'Google Chrome';
	} else if (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {
		$outputer = 'Safari';
	} else {
		$outputer = 'Google Chrome';
	}
	echo $outputer;
}

/* 根据评论agent获取设备类型 */
function _getAgentOS($agent)
{
	$os = "Linux";
	if (preg_match('/win/i', $agent)) {
		if (preg_match('/nt 6.0/i', $agent)) {
			$os = 'Windows Vista';
		} else if (preg_match('/nt 6.1/i', $agent)) {
			$os = 'Windows 7';
		} else if (preg_match('/nt 6.2/i', $agent)) {
			$os = 'Windows 8';
		} else if (preg_match('/nt 6.3/i', $agent)) {
			$os = 'Windows 8.1';
		} else if (preg_match('/nt 5.1/i', $agent)) {
			$os = 'Windows XP';
		} else if (preg_match('/nt 10.0/i', $agent)) {
			$os = 'Windows 10';
		} else {
			$os = 'Windows X64';
		}
	} else if (preg_match('/android/i', $agent)) {
		if (preg_match('/android 9/i', $agent)) {
			$os = 'Android Pie';
		} else if (preg_match('/android 8/i', $agent)) {
			$os = 'Android Oreo';
		} else {
			$os = 'Android';
		}
	} else if (preg_match('/ubuntu/i', $agent)) {
		$os = 'Ubuntu';
	} else if (preg_match('/linux/i', $agent)) {
		$os = 'Linux';
	} else if (preg_match('/iPhone/i', $agent)) {
		$os = 'iPhone';
	} else if (preg_match('/mac/i', $agent)) {
		$os = 'MacOS';
	} else if (preg_match('/fusion/i', $agent)) {
		$os = 'Android';
	} else {
		$os = 'Linux';
	}
	echo $os;
}

/* 获取全局懒加载图 */
function _getLazyload($type = true)
{
	if ($type) echo Helper::options()->JLazyload;
	else return Helper::options()->JLazyload;
}

/* 获取头像懒加载图 */
function _getAvatarLazyload($type = true)
{
	if ($type) echo "https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/img/lazyload_avatar.gif";
	else return "https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/img/lazyload_avatar.gif";
}

/* 查询文章浏览量 */
function _getViews($item, $type = true)
{
	$db = Typecho_Db::get();
	$result = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $item->cid))['views'];
	if ($type) echo number_format($result);
	else return number_format($result);
}

/* 查询文章点赞量 */
function _getAgree($item, $type = true)
{
	$db = Typecho_Db::get();
	$result = $db->fetchRow($db->select('agree')->from('table.contents')->where('cid = ?', $item->cid))['agree'];
	if ($type) echo number_format($result);
	else return number_format($result);
}

/* 页面开始计时 */
function _startCountTime()
{
	global $timeStart;
	$mTime     = explode(' ', microtime());
	$timeStart = $mTime[1] + $mTime[0];
	return true;
}

/* 页面结束计时 */
function _endCountTime($precision = 3)
{
	global $timeStart, $timeEnd;
	$mTime     = explode(' ', microtime());
	$timeEnd   = $mTime[1] + $mTime[0];
	$timeTotal = number_format($timeEnd - $timeStart, $precision);
	echo $timeTotal < 1 ? $timeTotal * 1000 . 'ms' : $timeTotal . 's';
}


/* 通过邮箱生成头像地址 */
function _getAvatarByMail($mail)
{
	$gravatarsUrl = 'https://gravatar.helingqi.com/wavatar/';
	$mailLower = strtolower($mail);
	$md5MailLower = md5($mailLower);
	$qqMail = str_replace('@qq.com', '', $mailLower);
	if (strstr($mailLower, "qq.com") && is_numeric($qqMail) && strlen($qqMail) < 11 && strlen($qqMail) > 4) {
		echo 'https://thirdqq.qlogo.cn/g?b=qq&nk=' . $qqMail . '&s=100';
	} else {
		echo $gravatarsUrl . $md5MailLower . '?d=mm';
	}
};

/* 获取侧边栏随机一言 */
function _getAsideAuthorMotto()
{
	$JMottoRandom = explode("\r\n", Helper::options()->JAside_Author_Motto);
	echo $JMottoRandom[array_rand($JMottoRandom, 1)];
}

/* 获取文章摘要 */
function _getAbstract($item, $type = true)
{
	$abstract = "";
	if ($item->password) {
		$abstract = "加密文章，请前往内页查看详情";
	} else {
		if ($item->fields->abstract) {
			$abstract = $item->fields->abstract;
		} else {
			$abstract = Typecho_Common::subStr(strip_tags($item->excerpt), 0, 180, '...');;
		}
	}
	if ($abstract === '') $abstract = "暂无简介";
	if ($type) echo $abstract;
	else return $abstract;
}

/* 获取列表缩略图 */
function _getThumbnails($item)
{
	$result = [];
	$pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
	$patternMD = '/\!\[.*?\]\((http(s)?:\/\/.*?(jpg|jpeg|gif|png|webp))/i';
	$patternMDfoot = '/\[.*?\]:\s*(http(s)?:\/\/.*?(jpg|jpeg|gif|png|webp))/i';
	/* 如果填写了自定义缩略图，则优先显示填写的缩略图 */
	if ($item->fields->thumb) {
		$fields_thumb_arr = explode("\r\n", $item->fields->thumb);
		foreach ($fields_thumb_arr as $list) $result[] = $list;
	}
	/* 如果匹配到正则，则继续补充匹配到的图片 */
	if (preg_match_all($pattern, $item->content, $thumbUrl)) {
		foreach ($thumbUrl[1] as $list) $result[] = $list;
	}
	if (preg_match_all($patternMD, $item->content, $thumbUrl)) {
		foreach ($thumbUrl[1] as $list) $result[] = $list;
	}
	if (preg_match_all($patternMDfoot, $item->content, $thumbUrl)) {
		foreach ($thumbUrl[1] as $list) $result[] = $list;
	}
	/* 如果上面的数量不足3个，则直接补充3个随即图进去 */
	if (sizeof($result) < 3) {
		$custom_thumbnail = Helper::options()->JThumbnail;
		/* 将for循环放里面，减少一次if判断 */
		if ($custom_thumbnail) {
			$custom_thumbnail_arr = explode("\r\n", $custom_thumbnail);
			for ($i = 0; $i < 3; $i++) {
				$result[] = $custom_thumbnail_arr[array_rand($custom_thumbnail_arr, 1)] . "?key=" . mt_rand(0, 1000000);
			}
		} else {
			for ($i = 0; $i < 3; $i++) {
				$result[] = 'https://cdn.jsdelivr.net/gh/HaoOuBa/Joe@master/assets/thumb/' . rand(1, 42) . '.jpg';
			}
		}
	}
	return $result;
}



/* 获取父级评论 */
function _getParentReply($parent)
{
	if ($parent !== "0") {
		$db = Typecho_Db::get();
		$commentInfo = $db->fetchRow($db->select('author')->from('table.comments')->where('coid = ?', $parent));
		echo '<div class="parent"><span style="vertical-align: 1px;">@</span> ' . $commentInfo['author'] . '</div>';
	}
}

/* 获取侧边栏作者随机文章 */
function _getAsideAuthorNav()
{
	if (Helper::options()->JAside_Author_Nav !== "off") {
		$db = Typecho_Db::get();
		$adapterName = $db->getAdapterName();
		if ($adapterName == 'pgsql' || $adapterName == 'Pdo_Pgsql' || $adapterName == 'Pdo_SQLite' || $adapterName == 'SQLite') {
			$order_by = 'RANDOM()';
		} else {
			$order_by = 'RAND()';
		}
		$result = $db->fetchAll(
			$db->select()
				->from('table.contents')
				->where('table.contents.status = ?', 'publish')
				->where('table.contents.type = ?', 'post')
				->where("table.contents.password IS NULL OR table.contents.password = ''")
				->limit(Helper::options()->JAside_Author_Nav)
				->order($order_by)
		);
		foreach ($result as $item) {
			$obj = Typecho_Widget::widget('Widget_Abstract_Contents');
			$item = $obj->push($item);
			$title = htmlspecialchars($item['title']);
			$permalink = $item['permalink'];
			echo "
                    <li class='item'>
                        <a class='link' href='{$permalink}' title='{$title}'>{$title}</a>
                        <svg class='icon' viewBox='0 0 1024 1024' version='1.1' xmlns='http://www.w3.org/2000/svg' width='16' height='16'>
							<path d='M448.12 320.331a30.118 30.118 0 0 1-42.616-42.586L552.568 130.68a213.685 213.685 0 0 1 302.2 0l38.552 38.551a213.685 213.685 0 0 1 0 302.2L746.255 618.497a30.118 30.118 0 0 1-42.586-42.616l147.034-147.035a153.45 153.45 0 0 0 0-217.028l-38.55-38.55a153.45 153.45 0 0 0-216.998 0L448.12 320.33zM575.88 703.67a30.118 30.118 0 0 1 42.616 42.586L471.432 893.32a213.685 213.685 0 0 1-302.2 0l-38.552-38.551a213.685 213.685 0 0 1 0-302.2l147.065-147.065a30.118 30.118 0 0 1 42.586 42.616L173.297 595.125a153.45 153.45 0 0 0 0 217.027l38.55 38.551a153.45 153.45 0 0 0 216.998 0L575.88 703.64z m-234.256-63.88L639.79 341.624a30.118 30.118 0 0 1 42.587 42.587L384.21 682.376a30.118 30.118 0 0 1-42.587-42.587z' p-id='7351'></path>
						</svg>
                    </li>
                ";
		}
	}
}

function _curl($url)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	if (strpos($url, 'https') !== false) {
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	}
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

/* 判断敏感词是否在字符串内 */
function _checkSensitiveWords($words_str, $str)
{
	$words = explode("||", $words_str);
	if (empty($words)) {
		return false;
	}
	foreach ($words as $word) {
		if (false !== strpos($str, trim($word))) {
			return true;
		}
	}
	return false;
}
