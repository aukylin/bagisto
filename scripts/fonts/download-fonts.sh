#!/bin/bash

# 创建字体目录
mkdir -p public/fonts

echo "正在下载 Poppins 字体..."
# 下载 Poppins 字体 CSS
curl -o public/fonts/poppins.css "https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"

echo "正在下载 DM Serif Display 字体..."
# 下载 DM Serif Display 字体 CSS  
curl -o public/fonts/dm-serif-display.css "https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap"

echo "正在下载 Inter 字体..."
# 下载 Inter 字体 CSS
curl -o public/fonts/inter.css "https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"

echo "字体CSS文件已下载到 public/fonts/ 目录"
echo "接下来需要手动下载字体文件并更新CSS中的URL路径"