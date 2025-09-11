<?php

echo "=== 字体文件验证脚本 ===\n\n";

// 检查字体文件是否存在
$fontFiles = [
    'Poppins 400' => 'public/fonts/files/poppins-400.woff2',
    'Poppins 500' => 'public/fonts/files/poppins-500.woff2',
    'Poppins 600' => 'public/fonts/files/poppins-600.woff2',
    'Poppins 700' => 'public/fonts/files/poppins-700.woff2',
    'Poppins 800' => 'public/fonts/files/poppins-800.woff2',
    'DM Serif Display' => 'public/fonts/files/dm-serif-display-400.ttf',
    'Inter 400' => 'public/fonts/files/inter-400.ttf',
    'Inter 500' => 'public/fonts/files/inter-500.ttf',
    'Inter 600' => 'public/fonts/files/inter-600.ttf',
    'Inter 700' => 'public/fonts/files/inter-700.ttf',
];

$cssFiles = [
    'Poppins CSS' => 'public/fonts/poppins-local.css',
    'DM Serif CSS' => 'public/fonts/dm-serif-display-local.css',
    'Inter CSS' => 'public/fonts/inter-local.css',
];

echo "1. 检查字体文件:\n";
foreach ($fontFiles as $name => $path) {
    if (file_exists($path)) {
        $size = round(filesize($path) / 1024, 2);
        echo "   ✅ $name: 存在 ({$size} KB)\n";
    } else {
        echo "   ❌ $name: 缺失\n";
    }
}

echo "\n2. 检查CSS文件:\n";
foreach ($cssFiles as $name => $path) {
    if (file_exists($path)) {
        echo "   ✅ $name: 存在\n";
    } else {
        echo "   ❌ $name: 缺失\n";
    }
}

echo "\n3. 检查环境配置:\n";
if (file_exists('.env')) {
    $envContent = file_get_contents('.env');
    if (strpos($envContent, 'FONT_STRATEGY=local') !== false) {
        echo "   ✅ 字体策略: 本地模式\n";
    } elseif (strpos($envContent, 'FONT_STRATEGY=cdn') !== false) {
        echo "   ⚠️  字体策略: CDN模式\n";
    } elseif (strpos($envContent, 'FONT_STRATEGY=hybrid') !== false) {
        echo "   ⚠️  字体策略: 混合模式\n";
    } else {
        echo "   ❌ 字体策略: 未配置\n";
    }
} else {
    echo "   ❌ .env 文件不存在\n";
}

echo "\n4. 检查配置文件:\n";
if (file_exists('config/fonts.php')) {
    echo "   ✅ 字体配置文件: 存在\n";
} else {
    echo "   ❌ 字体配置文件: 缺失\n";
}

echo "\n=== 验证完成 ===\n";
echo "\n建议的测试步骤:\n";
echo "1. 访问: http://bagisto.test/font-test.html\n";
echo "2. 点击 '测试本地字体' 按钮\n";
echo "3. 检查字体是否正确显示\n";
echo "4. 在开发者工具中查看网络请求，确认没有外部字体请求\n";
echo "\n相关文档:\n";
echo "- 字体优化指南: docs/development/performance/font-optimization.md\n";
echo "- 字体配置文档: docs/configuration/fonts.md\n";

?>