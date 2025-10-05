#!/usr/bin/env python3
"""
Script tạo ảnh placeholder đơn giản bằng HTML/CSS
"""

import os
import base64

# Tạo thư mục upload nếu chưa có
upload_dir = "View/assets/img/upload"
if not os.path.exists(upload_dir):
    os.makedirs(upload_dir)

# Danh sách ảnh cần tạo
missing_images = [
    # Nike
    "nike_react_infinity.jpg",
    
    # Adidas
    "adidas_predator_edge.jpg",
    "adidas_harden_vol_6.jpg", 
    "adidas_yeezy_boost_350.jpg",
    
    # Puma
    "puma_future_z_4.3.jpg",
    "puma_rs_x_reinvention.jpg",
    "puma_deviate_nitro.jpg",
    "puma_suede_classic.jpg",
    "puma_court_rider.jpg",
    "puma_cali_sport.jpg",
    
    # New Balance
    "new_balance_327.jpg",
    "new_balance_550.jpg",
    "new_balance_fuelcell_rebel.jpg",
    "new_balance_574.jpg",
    
    # Under Armour
    "under_armour_curry_9.jpg",
    "under_armour_hovr_sonic_4.jpg",
    "under_armour_project_rock_4.jpg",
    "under_armour_charged_assert_9.jpg",
    "under_armour_spawn_3.jpg",
    "under_armour_charged_bandit_6.jpg",
]

# Màu sắc cho từng thương hiệu
brand_colors = {
    "nike": "#000000",
    "adidas": "#0066CC", 
    "puma": "#000000",
    "new_balance": "#0066CC",
    "under_armour": "#000000",
}

def create_svg_placeholder(filename, brand_name, product_name):
    """Tạo SVG placeholder"""
    brand_color = brand_colors.get(brand_name.lower(), "#2563eb")
    
    svg_content = f'''<?xml version="1.0" encoding="UTF-8"?>
<svg width="400" height="400" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:{brand_color};stop-opacity:1" />
      <stop offset="100%" style="stop-color:{brand_color}88;stop-opacity:1" />
    </linearGradient>
  </defs>
  
  <!-- Background -->
  <rect width="400" height="400" fill="url(#grad1)"/>
  
  <!-- Pattern -->
  <g opacity="0.1">
    <circle cx="50" cy="50" r="2" fill="white"/>
    <circle cx="150" cy="80" r="1.5" fill="white"/>
    <circle cx="250" cy="60" r="2.5" fill="white"/>
    <circle cx="350" cy="90" r="1" fill="white"/>
    <circle cx="80" cy="150" r="2" fill="white"/>
    <circle cx="180" cy="180" r="1.5" fill="white"/>
    <circle cx="280" cy="160" r="2.5" fill="white"/>
    <circle cx="380" cy="190" r="1" fill="white"/>
    <circle cx="60" cy="250" r="2" fill="white"/>
    <circle cx="160" cy="280" r="1.5" fill="white"/>
    <circle cx="260" cy="260" r="2.5" fill="white"/>
    <circle cx="360" cy="290" r="1" fill="white"/>
    <circle cx="90" cy="350" r="2" fill="white"/>
    <circle cx="190" cy="380" r="1.5" fill="white"/>
    <circle cx="290" cy="360" r="2.5" fill="white"/>
    <circle cx="390" cy="390" r="1" fill="white"/>
  </g>
  
  <!-- Brand Name -->
  <text x="200" y="150" font-family="Arial, sans-serif" font-size="28" font-weight="bold" 
        text-anchor="middle" fill="white">{brand_name.upper()}</text>
  
  <!-- Product Name -->
  <text x="200" y="200" font-family="Arial, sans-serif" font-size="18" 
        text-anchor="middle" fill="white">{product_name.replace(f"{brand_name} ", "").upper()}</text>
  
  <!-- Quality Text -->
  <text x="200" y="250" font-family="Arial, sans-serif" font-size="14" 
        text-anchor="middle" fill="white">PREMIUM QUALITY</text>
  
  <!-- Decorative elements -->
  <rect x="150" y="280" width="100" height="2" fill="white" opacity="0.5"/>
  <circle cx="200" cy="320" r="3" fill="white" opacity="0.7"/>
</svg>'''
    
    return svg_content

def create_html_generator():
    """Tạo file HTML để generate ảnh"""
    html_content = '''<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Ảnh Placeholder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2563eb;
            text-align: center;
            margin-bottom: 30px;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .product-item {
            text-align: center;
            padding: 20px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            background: #f9fafb;
        }
        .product-image {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .product-name {
            font-weight: bold;
            color: #374151;
            margin-bottom: 10px;
        }
        .download-btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.3s;
        }
        .download-btn:hover {
            background: #1d4ed8;
        }
        .instructions {
            background: #eff6ff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid #2563eb;
        }
        .instructions h3 {
            color: #2563eb;
            margin-top: 0;
        }
        .instructions ol {
            margin: 10px 0;
            padding-left: 20px;
        }
        .instructions li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛍️ Tạo Ảnh Placeholder cho Sản Phẩm Còn Thiếu</h1>
        
        <div class="instructions">
            <h3>📋 Hướng dẫn sử dụng:</h3>
            <ol>
                <li>Click vào nút "Tải ảnh" bên dưới mỗi sản phẩm</li>
                <li>Ảnh sẽ được tải về máy tính của bạn</li>
                <li>Copy các ảnh này vào thư mục <code>View/assets/img/upload/</code></li>
                <li>Chạy file <code>add_new_products.sql</code> trong database</li>
                <li>Refresh trang web để xem sản phẩm mới</li>
            </ol>
        </div>

        <div class="product-grid" id="productGrid">
            <!-- Sản phẩm sẽ được tạo bằng JavaScript -->
        </div>
    </div>

    <script>
        // Danh sách sản phẩm cần tạo ảnh
        const products = [
            // Nike
            { name: 'Nike React Infinity', filename: 'nike_react_infinity.jpg', brand: 'Nike', color: '#000000' },
            
            // Adidas
            { name: 'Adidas Predator Edge', filename: 'adidas_predator_edge.jpg', brand: 'Adidas', color: '#0066CC' },
            { name: 'Adidas Harden Vol 6', filename: 'adidas_harden_vol_6.jpg', brand: 'Adidas', color: '#0066CC' },
            { name: 'Adidas Yeezy Boost 350', filename: 'adidas_yeezy_boost_350.jpg', brand: 'Adidas', color: '#0066CC' },
            
            // Puma
            { name: 'Puma Future Z 4.3', filename: 'puma_future_z_4.3.jpg', brand: 'Puma', color: '#000000' },
            { name: 'Puma RS-X Reinvention', filename: 'puma_rs_x_reinvention.jpg', brand: 'Puma', color: '#000000' },
            { name: 'Puma Deviate Nitro', filename: 'puma_deviate_nitro.jpg', brand: 'Puma', color: '#000000' },
            { name: 'Puma Suede Classic', filename: 'puma_suede_classic.jpg', brand: 'Puma', color: '#000000' },
            { name: 'Puma Court Rider', filename: 'puma_court_rider.jpg', brand: 'Puma', color: '#000000' },
            { name: 'Puma Cali Sport', filename: 'puma_cali_sport.jpg', brand: 'Puma', color: '#000000' },
            
            // New Balance
            { name: 'New Balance 327', filename: 'new_balance_327.jpg', brand: 'New Balance', color: '#0066CC' },
            { name: 'New Balance 550', filename: 'new_balance_550.jpg', brand: 'New Balance', color: '#0066CC' },
            { name: 'New Balance FuelCell Rebel', filename: 'new_balance_fuelcell_rebel.jpg', brand: 'New Balance', color: '#0066CC' },
            { name: 'New Balance 574', filename: 'new_balance_574.jpg', brand: 'New Balance', color: '#0066CC' },
            
            // Under Armour
            { name: 'Under Armour Curry 9', filename: 'under_armour_curry_9.jpg', brand: 'Under Armour', color: '#000000' },
            { name: 'Under Armour HOVR Sonic 4', filename: 'under_armour_hovr_sonic_4.jpg', brand: 'Under Armour', color: '#000000' },
            { name: 'Under Armour Project Rock 4', filename: 'under_armour_project_rock_4.jpg', brand: 'Under Armour', color: '#000000' },
            { name: 'Under Armour Charged Assert 9', filename: 'under_armour_charged_assert_9.jpg', brand: 'Under Armour', color: '#000000' },
            { name: 'Under Armour Spawn 3', filename: 'under_armour_spawn_3.jpg', brand: 'Under Armour', color: '#000000' },
            { name: 'Under Armour Charged Bandit 6', filename: 'under_armour_charged_bandit_6.jpg', brand: 'Under Armour', color: '#000000' }
        ];

        // Tạo canvas để vẽ ảnh placeholder
        function createPlaceholderImage(filename, brand, productName, color) {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = 400;
            canvas.height = 400;

            // Tạo gradient background
            const gradient = ctx.createLinearGradient(0, 0, 400, 400);
            gradient.addColorStop(0, color);
            gradient.addColorStop(1, color + '88');
            
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, 400, 400);

            // Thêm pattern
            ctx.fillStyle = 'rgba(255,255,255,0.1)';
            for (let i = 0; i < 20; i++) {
                ctx.beginPath();
                ctx.arc(Math.random() * 400, Math.random() * 400, Math.random() * 3, 0, Math.PI * 2);
                ctx.fill();
            }

            // Thêm text
            ctx.fillStyle = 'white';
            ctx.font = 'bold 24px Arial';
            ctx.textAlign = 'center';
            ctx.fillText(brand, 200, 150);
            
            ctx.font = '16px Arial';
            ctx.fillText(productName.replace(brand + ' ', ''), 200, 200);
            
            ctx.font = '14px Arial';
            ctx.fillText('PREMIUM QUALITY', 200, 250);

            return canvas.toDataURL('image/jpeg', 0.9);
        }

        // Tạo grid sản phẩm
        function createProductGrid() {
            const grid = document.getElementById('productGrid');
            
            products.forEach(product => {
                const productItem = document.createElement('div');
                productItem.className = 'product-item';
                
                const imageDataUrl = createPlaceholderImage(product.filename, product.brand, product.name, product.color);
                
                productItem.innerHTML = `
                    <div class="product-image" style="background-image: url(${imageDataUrl}); background-size: cover; background-position: center;">
                    </div>
                    <div class="product-name">${product.name}</div>
                    <button class="download-btn" onclick="downloadImage('${product.filename}', '${imageDataUrl}')">
                        📥 Tải ảnh
                    </button>
                `;
                
                grid.appendChild(productItem);
            });
        }

        // Tải ảnh về máy
        function downloadImage(filename, dataUrl) {
            const link = document.createElement('a');
            link.download = filename;
            link.href = dataUrl;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Hiển thị thông báo
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '✅ Đã tải';
            btn.style.background = '#10b981';
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.style.background = '#2563eb';
            }, 2000);
        }

        // Khởi tạo
        createProductGrid();
    </script>
</body>
</html>'''
    
    return html_content

def main():
    """Hàm chính"""
    print("🎨 Tạo file HTML để generate ảnh placeholder...")
    
    # Tạo file HTML
    html_content = create_html_generator()
    html_file = "create_missing_placeholders.html"
    
    with open(html_file, 'w', encoding='utf-8') as f:
        f.write(html_content)
    
    print(f"✅ Đã tạo file: {html_file}")
    print("📋 Hướng dẫn:")
    print("1. Mở file create_missing_placeholders.html trong trình duyệt")
    print("2. Click 'Tải ảnh' cho từng sản phẩm")
    print("3. Copy các ảnh vào thư mục View/assets/img/upload/")
    print("4. Chạy add_new_products.sql trong database")

if __name__ == "__main__":
    main()
