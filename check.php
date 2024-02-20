<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

// 读取 M3U 文件内容
$m3u_file = 'D:\iptv\cn.m3u';
$m3u_content = file_get_contents($m3u_file);

// 解析 M3U 文件内容，获取所有链接和相关信息
$lines = explode("\n", $m3u_content);
$media_entries = array();
$current_entry = array();
foreach ($lines as $line) {
    $line = trim($line);
    if (!empty($line)) {
        if ($line[0] === '#') {
            if (strpos($line, '#EXTINF') === 0) {
                // 处理 #EXTINF 标签，提取相关信息
                preg_match('/#EXTINF:(-?\d+) tvg-name="([^"]+)" tvg-logo="([^"]+)" group-title="([^"]+)",(.+)/', $line, $matches);
                $current_entry['duration'] = $matches[1];
                $current_entry['tvg-name'] = $matches[2];
                $current_entry['tvg-logo'] = $matches[3];
                $current_entry['group-title'] = $matches[4];
                $current_entry['title'] = $matches[5];
            } elseif (strpos($line, '#EXTM3U') === false) {
                // 处理其他自定义标签，如 x-tvg-url
                // 这里你可以根据需要进行相应的处理
            }
        } else {
            // 处理频道链接
            $current_entry['url'] = $line;
            $media_entries[] = $current_entry;
            $current_entry = array();
        }
    }
}

// 检查频道
function check_channel($url) {
    // 使用 FFmpeg 检查频道是否有效
    $cmd = "ffmpeg -i \"$url\" -t 1 -f null - 2>&1";
    exec($cmd, $output, $return_var);
    return $return_var === 0;
}

// 将有效链接重新写入文件，保持M3U文件格式
$file_content = "#EXTM3U x-tvg-url=\"https://live.fanmingming.com/e.xml\"\n";
foreach ($media_entries as $entry) {
    if (check_channel($entry['url'])) {
        $file_content .= "#EXTINF:{$entry['duration']} tvg-name=\"{$entry['tvg-name']}\" tvg-logo=\"{$entry['tvg-logo']}\" group-title=\"{$entry['group-title']}\",{$entry['title']}\n{$entry['url']}\n";
    }
}
file_put_contents($m3u_file, $file_content);

//git status 判断cn.m3u是否有修改，有修改则提交
$cmd = "git status cn.m3u";
exec($cmd, $output, $return_var);
if (strpos($output[2], 'nothing to commit') === false) {
    $cmd = "git add cn.m3u";
    exec($cmd, $output, $return_var);
    $cmd = "git commit -m update m3u";
    exec($cmd, $output, $return_var);
    $cmd = "git push";
    exec($cmd, $output, $return_var);
}