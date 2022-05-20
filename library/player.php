<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8" />
    <meta name="renderer" content="webkit" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no, viewport-fit=cover" />
    <title>M3U8 - Player</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            -webkit-tap-highlight-color: transparent;
            outline: none;
            text-decoration: none;
        }

        html,
        body,
        #dplayer {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <div id="dplayer"></div>
    <script src="https://fastly.jsdelivr.net/npm/hls.js@0.14.16/dist/hls.min.js"></script>
    <script src="https://fastly.jsdelivr.net/npm/dplayer@1.26.0/dist/DPlayer.min.js"></script>
    <script>
        new DPlayer({
            container: document.getElementById('dplayer'), // 播放器容器元素
            autoplay: false, // 视频自动播放
            theme: '#409eff', // 主题色
            loop: false, // 视频循环播放
            screenshot: false, // 开启截图，如果开启，视频和视频封面需要允许跨域
            airplay: true, // 在 Safari 中开启 AirPlay
            volume: 0.5, // 默认音量，请注意播放器会记忆用户设置，用户手动设置音量后默认音量即失效
            playbackSpeed: [2, 1.5, 1.25, 1], // 可选的播放速率，可以设置成自定义的数组
            video: {
                url: '<?php echo $_GET['url'] ?>',
            }
        })
    </script>
</body>

</html>