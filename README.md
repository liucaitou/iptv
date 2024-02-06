# IPTV 链接获取方式

## 方法一：固定URL（mirror.ghproxy.com）

使用以下固定URL获取IPTV链接，但请注意，mirror.ghproxy.com 可能会被 CFW 防住：

https://mirror.ghproxy.com/https://raw.githubusercontent.com/liucaitou/iptv/master/cn.m3u

## 方法二：GitHub 固定URL（国内访问较慢）

使用 GitHub 的固定URL获取IPTV链接，但在国内访问可能较慢：

https://raw.githubusercontent.com/liucaitou/iptv/master/cn.m3u

## 方法三：GitHub + jsDelivr

### 1 固定URL（jsDelivr 不会实时更新）

使用以下固定URL，但请注意 jsDelivr 不会实时更新。你可以尝试使用以下链接刷新缓存，但不一定有效：

https://cdn.jsdelivr.net/gh/liucaitou/iptv/cn.m3u

刷新缓存链接： [https://purge.jsdelivr.net/gh/liucaitou/iptv/cn.m3u](https://purge.jsdelivr.net/gh/liucaitou/iptv/cn.m3u)

### 2 每次更新文件发布新版本

每次更新文件时，发布一个新版本，并使用版本号获取链接：

https://cdn.jsdelivr.net/gh/liucaitou/iptv@版本号/cn.m3u
