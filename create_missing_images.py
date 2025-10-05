#!/usr/bin/env python3
"""
Script tạo ảnh placeholder cho các sản phẩm còn thiếu
"""

from PIL import Image, ImageDraw, ImageFont
import os

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
    "nike": ("#000000", "#FFFFFF"),  # Đen trắng
    "adidas": ("#0066CC", "#FFFFFF"),  # Xanh dương trắng
    "puma": ("#000000", "#FFFFFF"),  # Đen trắng
    "new_balance": ("#0066CC", "#FFFFFF"),  # Xanh dương trắng
    "under_armour": ("#000000", "#FFFFFF"),  # Đen trắng
}

def create_placeholder_image(filename, brand_name, product_name):
    """Tạo ảnh placeholder cho sản phẩm"""
    # Kích thước ảnh
    width, height = 400, 400
    
    # Lấy màu sắc cho thương hiệu
    bg_color, text_color = brand_colors.get(brand_name.lower(), ("#2563eb", "#FFFFFF"))
    
    # Tạo ảnh mới
    img = Image.new('RGB', (width, height), bg_color)
    draw = ImageDraw.Draw(img)
    
    # Thêm gradient effect
    for i in range(height):
        alpha = int(255 * (1 - i / height * 0.3))
        color = tuple(int(bg_color[j:j+2], 16) for j in (1, 3, 5))
        draw.line([(0, i), (width, i)], fill=color)
    
    # Thêm pattern
    for i in range(0, width, 20):
        for j in range(0, height, 20):
            if (i + j) % 40 == 0:
                draw.ellipse([i, j, i+3, j+3], fill=text_color, width=0)
    
    # Thêm text
    try:
        # Thử sử dụng font mặc định
        font_large = ImageFont.truetype("arial.ttf", 32)
        font_medium = ImageFont.truetype("arial.ttf", 20)
        font_small = ImageFont.truetype("arial.ttf", 16)
    except:
        # Nếu không có font, sử dụng font mặc định
        font_large = ImageFont.load_default()
        font_medium = ImageFont.load_default()
        font_small = ImageFont.load_default()
    
    # Vẽ text
    brand_text = brand_name.upper()
    product_text = product_name.replace(f"{brand_name} ", "").upper()
    
    # Tính toán vị trí text
    brand_bbox = draw.textbbox((0, 0), brand_text, font=font_large)
    brand_width = brand_bbox[2] - brand_bbox[0]
    brand_x = (width - brand_width) // 2
    
    product_bbox = draw.textbbox((0, 0), product_text, font=font_medium)
    product_width = product_bbox[2] - product_bbox[0]
    product_x = (width - product_width) // 2
    
    # Vẽ brand name
    draw.text((brand_x, 120), brand_text, fill=text_color, font=font_large)
    
    # Vẽ product name
    draw.text((product_x, 180), product_text, fill=text_color, font=font_medium)
    
    # Vẽ "PREMIUM QUALITY"
    quality_text = "PREMIUM QUALITY"
    quality_bbox = draw.textbbox((0, 0), quality_text, font=font_small)
    quality_width = quality_bbox[2] - quality_bbox[0]
    quality_x = (width - quality_width) // 2
    draw.text((quality_x, 220), quality_text, fill=text_color, font=font_small)
    
    # Lưu ảnh
    filepath = os.path.join(upload_dir, filename)
    img.save(filepath, 'JPEG', quality=90)
    
    return filepath

def main():
    """Hàm chính"""
    print("🎨 Bắt đầu tạo ảnh placeholder...")
    print(f"📁 Thư mục đích: {upload_dir}")
    print("-" * 50)
    
    success_count = 0
    
    for filename in missing_images:
        try:
            # Xác định thương hiệu và tên sản phẩm
            if filename.startswith("nike_"):
                brand = "Nike"
                product = filename.replace("nike_", "").replace(".jpg", "").replace("_", " ").title()
            elif filename.startswith("adidas_"):
                brand = "Adidas"
                product = filename.replace("adidas_", "").replace(".jpg", "").replace("_", " ").title()
            elif filename.startswith("puma_"):
                brand = "Puma"
                product = filename.replace("puma_", "").replace(".jpg", "").replace("_", " ").title()
            elif filename.startswith("new_balance_"):
                brand = "New Balance"
                product = filename.replace("new_balance_", "").replace(".jpg", "").replace("_", " ").title()
            elif filename.startswith("under_armour_"):
                brand = "Under Armour"
                product = filename.replace("under_armour_", "").replace(".jpg", "").replace("_", " ").title()
            else:
                brand = "Brand"
                product = filename.replace(".jpg", "").replace("_", " ").title()
            
            # Tạo ảnh
            filepath = create_placeholder_image(filename, brand, product)
            print(f"✅ Đã tạo: {filename}")
            success_count += 1
            
        except Exception as e:
            print(f"❌ Lỗi tạo {filename}: {str(e)}")
    
    print("-" * 50)
    print(f"📊 Kết quả: {success_count}/{len(missing_images)} ảnh đã tạo thành công")
    
    if success_count == len(missing_images):
        print("🎉 Tất cả ảnh placeholder đã được tạo thành công!")
    else:
        print("⚠️ Một số ảnh không thể tạo. Vui lòng kiểm tra lại.")

if __name__ == "__main__":
    main()
