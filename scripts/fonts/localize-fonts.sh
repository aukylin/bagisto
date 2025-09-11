#!/bin/bash

# 创建字体文件目录
mkdir -p public/fonts/files

echo "正在下载 Poppins 字体文件..."
# Poppins 字体文件
curl -o public/fonts/files/poppins-400.woff2 "https://fonts.gstatic.com/s/poppins/v23/pxiEyp8kv8JHgFVrFJXUdVNF.woff2"
curl -o public/fonts/files/poppins-500.woff2 "https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLGT9V15vEv-L.woff2"
curl -o public/fonts/files/poppins-600.woff2 "https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLEj6V15vEv-L.woff2"
curl -o public/fonts/files/poppins-700.woff2 "https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLCz7V15vEv-L.woff2"
curl -o public/fonts/files/poppins-800.woff2 "https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLDD4V15vEv-L.woff2"

echo "正在下载 DM Serif Display 字体文件..."
# DM Serif Display 字体文件
curl -o public/fonts/files/dm-serif-display-400.ttf "https://fonts.gstatic.com/s/dmserifdisplay/v16/-nFnOHM81r4j6k0gjAW3mujVU2B2K_c.ttf"

echo "正在下载 Inter 字体文件..."
# Inter 字体文件
curl -o public/fonts/files/inter-400.ttf "https://fonts.gstatic.com/s/inter/v19/UcCO3FwrK3iLTeHuS_nVMrMxCp50SjIw2boKoduKmMEVuLyfMZg.ttf"
curl -o public/fonts/files/inter-500.ttf "https://fonts.gstatic.com/s/inter/v19/UcCO3FwrK3iLTeHuS_nVMrMxCp50SjIw2boKoduKmMEVuI6fMZg.ttf"
curl -o public/fonts/files/inter-600.ttf "https://fonts.gstatic.com/s/inter/v19/UcCO3FwrK3iLTeHuS_nVMrMxCp50SjIw2boKoduKmMEVuGKYMZg.ttf"
curl -o public/fonts/files/inter-700.ttf "https://fonts.gstatic.com/s/inter/v19/UcCO3FwrK3iLTeHuS_nVMrMxCp50SjIw2boKoduKmMEVuFuYMZg.ttf"

echo "字体文件下载完成！"
echo "正在更新CSS文件以使用本地路径..."