#!/usr/bin/env python3
"""
Script để tải ảnh sản phẩm mẫu từ internet
Chạy script này để tải ảnh cho các sản phẩm mới
"""

import requests
import os
from urllib.parse import urlparse

# Tạo thư mục upload nếu chưa có
upload_dir = "View/assets/img/upload"
if not os.path.exists(upload_dir):
    os.makedirs(upload_dir)

# Danh sách ảnh sản phẩm cần tải
product_images = {
    # Nike
    "nike_air_max_270.jpg": "https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/b7d9211c-26e7-431a-ac24-b0540fb3c00f/air-max-270-mens-shoes-KkLcGR.png",
    "nike_mercurial_vapor_14.jpg": "https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/4f37fca8-6bce-43e7-ad07-f57ae3c13142/mercurial-vapor-14-elite-fg-firm-ground-soccer-cleat-4q1j7Z.png",
    "nike_react_infinity.jpg": "https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/61d2b7ad-2b7c-4c65-9c5a-4f0a0b8c8d8e/react-infinity-run-flyknit-3-mens-road-running-shoes-2Mcz7r.png",
    "nike_air_force_1.jpg": "https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/b7d9211c-26e7-431a-ac24-b0540fb3c00f/air-force-1-07-mens-shoes-5QFp5Z.png",
    "nike_zoom_freak_3.jpg": "https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/4f37fca8-6bce-43e7-ad07-f57ae3c13142/zoom-freak-3-mens-basketball-shoes-2Mcz7r.png",
    "nike_dunk_low.jpg": "https://static.nike.com/a/images/t_PDP_1728_v1/f_auto,q_auto:eco/b7d9211c-26e7-431a-ac24-b0540fb3c00f/dunk-low-mens-shoes-4q1j7Z.png",
    
    # Adidas
    "adidas_ultraboost_22.jpg": "https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/fbaf991a78bc4896a3e9ad7800abcec6_9366/Ultraboost_22_Shoes_Black_GZ0127_01_standard.jpg",
    "adidas_predator_edge.jpg": "https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/4f37fca8-6bce-43e7-ad07-f57ae3c13142/Predator_Edge.3_FG_Black_GZ0127_01_standard.jpg",
    "adidas_stan_smith.jpg": "https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/fbaf991a78bc4896a3e9ad7800abcec6_9366/Stan_Smith_Shoes_White_EE6463_01_standard.jpg",
    "adidas_harden_vol_6.jpg": "https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/4f37fca8-6bce-43e7-ad07-f57ae3c13142/Harden_Vol_6_Shoes_Black_GZ0127_01_standard.jpg",
    "adidas_copa_sense.jpg": "https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/fbaf991a78bc4896a3e9ad7800abcec6_9366/Copa_Sense.3_FG_Black_GZ0127_01_standard.jpg",
    "adidas_yeezy_boost_350.jpg": "https://assets.adidas.com/images/h_840,f_auto,q_auto,fl_lossy,c_fill,g_auto/4f37fca8-6bce-43e7-ad07-f57ae3c13142/Yeezy_Boost_350_V2_Black_GZ0127_01_standard.jpg",
    
    # Puma
    "puma_future_z_4.3.jpg": "https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,w_2000,h_2000/global/376650/01/sv01/fnd/PNA/fmt/png/Future-Z-4.3-FG-AG-Men's-Football-Boots",
    "puma_rs_x_reinvention.jpg": "https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,w_2000,h_2000/global/376650/01/sv01/fnd/PNA/fmt/png/RS-X-Reinvention-Men's-Sneakers",
    "puma_deviate_nitro.jpg": "https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,w_2000,h_2000/global/376650/01/sv01/fnd/PNA/fmt/png/Deviate-Nitro-Men's-Running-Shoes",
    "puma_suede_classic.jpg": "https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,w_2000,h_2000/global/376650/01/sv01/fnd/PNA/fmt/png/Suede-Classic-Men's-Sneakers",
    "puma_court_rider.jpg": "https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,w_2000,h_2000/global/376650/01/sv01/fnd/PNA/fmt/png/Court-Rider-Men's-Tennis-Shoes",
    "puma_cali_sport.jpg": "https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,w_2000,h_2000/global/376650/01/sv01/fnd/PNA/fmt/png/Cali-Sport-Men's-Sneakers",
    
    # New Balance
    "new_balance_990v5.jpg": "https://nb.scene7.com/is/image/NB/m990gl5_nb_02_i?$pdpflexf2$&qlt=80&fmt=webp&wid=440&hei=440",
    "new_balance_327.jpg": "https://nb.scene7.com/is/image/NB/m327gl_nb_02_i?$pdpflexf2$&qlt=80&fmt=webp&wid=440&hei=440",
    "new_balance_550.jpg": "https://nb.scene7.com/is/image/NB/m550wh1_nb_02_i?$pdpflexf2$&qlt=80&fmt=webp&wid=440&hei=440",
    "new_balance_fuelcell_rebel.jpg": "https://nb.scene7.com/is/image/NB/mfuelcr2_nb_02_i?$pdpflexf2$&qlt=80&fmt=webp&wid=440&hei=440",
    "new_balance_2002r.jpg": "https://nb.scene7.com/is/image/NB/m2002rg_nb_02_i?$pdpflexf2$&qlt=80&fmt=webp&wid=440&hei=440",
    "new_balance_574.jpg": "https://nb.scene7.com/is/image/NB/m574wh1_nb_02_i?$pdpflexf2$&qlt=80&fmt=webp&wid=440&hei=440",
    
    # Under Armour
    "under_armour_curry_9.jpg": "https://underarmour.scene7.com/is/image/Underarmour/3024040-001_HF?$pdpflexf2$&qlt=80&fmt=webp&wid=440&hei=440",
    "under_armour_hovr_sonic_4.jpg": "https://underarmour.scene7.com/is/image/Underarmour/3024040-001_HF?$pdpflexf2$&qlt=80&fmt=webp&wid=440&hei=440",
    "under_armour_project_rock_4.jpg": "https://underarmour.scene7.com/is/image/Underarmour/3024040-001_HF?$pdpflexf2$&qlt=80&fmt=webp&wid=440&hei=440",
    "under_armour_charged_assert_9.jpg": "https://underarmour.scene7.com/is/image/Underarmour/3024040-001_HF?$pdpflexf2$&qlt=80&fmt=webp&wid=440&hei=440",
    "under_armour_spawn_3.jpg": "https://underarmour.scene7.com/is/image/Underarmour/3024040-001_HF?$pdpflexf2$&qlt=80&fmt=webp&wid=440&hei=440",
    "under_armour_charged_bandit_6.jpg": "https://underarmour.scene7.com/is/image/Underarmour/3024040-001_HF?$pdpflexf2$&qlt=80&fmt=webp&wid=440&hei=440",
}

def download_image(url, filename):
    """Tải ảnh từ URL và lưu vào thư mục upload"""
    try:
        response = requests.get(url, timeout=30)
        response.raise_for_status()
        
        filepath = os.path.join(upload_dir, filename)
        with open(filepath, 'wb') as f:
            f.write(response.content)
        
        print(f"✅ Đã tải: {filename}")
        return True
    except Exception as e:
        print(f"❌ Lỗi tải {filename}: {str(e)}")
        return False

def main():
    """Hàm chính để tải tất cả ảnh"""
    print("🚀 Bắt đầu tải ảnh sản phẩm...")
    print(f"📁 Thư mục đích: {upload_dir}")
    print("-" * 50)
    
    success_count = 0
    total_count = len(product_images)
    
    for filename, url in product_images.items():
        if download_image(url, filename):
            success_count += 1
    
    print("-" * 50)
    print(f"📊 Kết quả: {success_count}/{total_count} ảnh đã tải thành công")
    
    if success_count == total_count:
        print("🎉 Tất cả ảnh đã được tải thành công!")
    else:
        print("⚠️ Một số ảnh không thể tải. Vui lòng kiểm tra lại URL.")

if __name__ == "__main__":
    main()
