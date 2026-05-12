-- File SQL để thêm dữ liệu sản phẩm mẫu
-- Import vào database phpMyAdmin

-- Thêm categories nếu chưa có
INSERT IGNORE INTO tbl_category (cate_id, cate_name) VALUES 
(1, 'Xe Bé Gái'),
(2, 'Xe Bé Trai'),
(3, 'Xe Trẻ Em'),
(4, 'Xe Thể Thao'),
(5, 'Xe Địa Hình');

-- Thêm sản phẩm mẫu
INSERT IGNORE INTO tbl_product (prd_name, cate_id, prd_price, prd_image, prd_description, prd_quantity) VALUES 
('Xe Đạp Bé Gái Pink Princess', 1, 890000, 'xedapbegai.jpg', 'Xe đạp bé gái màu hồng với thiết kế công chúa, phù hợp cho bé từ 3-6 tuổi. Khung sắt chắc chắn, bánh xe cao su an toàn.', 15),
('Xe Đạp Bé Trai Super Hero', 2, 950000, 'xedapchobetrai.webp', 'Xe đạp bé trai với thiết kế siêu anh hùng, màu xanh dương đậm. Phù hợp cho bé từ 4-7 tuổi.', 12),
('Xe Đạp Trẻ Em Happy Kids', 3, 750000, 'xedapchobe1.jpg', 'Xe đạp trẻ em màu xanh lá cây, thiết kế đơn giản và an toàn. Phù hợp cho bé mới học đi xe.', 20),
('Xe Đạp Thể Thao Pro Sport', 4, 1250000, 'xedapthethao.jpg', 'Xe đạp thể thao chuyên nghiệp cho trẻ em, nhiều tốc độ, phanh đĩa an toàn. Phù hợp cho bé từ 8-12 tuổi.', 8),
('Xe Đạp Địa Hình Adventure', 5, 1850000, 'xedapdiahinh.jpg', 'Xe đạp địa hình cho trẻ em, khung nhôm siêu nhẹ, lốp xe gai, hệ thống treo tốt. Phù hợp cho địa hình đa dạng.', 6),
('Xe Đạp Bé Gái Flower Garden', 1, 820000, 'xedapnu.jpg', 'Xe đạp bé gái với hoa văn vườn hoa, màu pastel nhẹ nhàng. Giỏ xe nhỏ phía trước để bé đựng đồ chơi.', 18),
('Xe Đạp Trẻ Em Sunny Day', 3, 680000, 'xedapchobe2.jpg', 'Xe đạp trẻ em màu vàng tươi, thiết kế vui nhộn. Bánh xe phụ giúp bé giữ thăng bằng tốt hơn.', 25),
('Xe Đạp Thể Thao Speed Racer', 4, 1450000, 'xedaptroluc.jpg', 'Xe đạp thể thao tốc độ cao, thiết kế đua xe, 21 tốc độ. Phù hợp cho bé yêu thích thể thao.', 10),
('Xe Đạp Gap Junior', 2, 1680000, 'xedapgap.jpg', 'Xe đạp Gap phiên bản trẻ em, thương hiệu Mỹ chất lượng cao. Thiết kế hiện đại, màu sắc thời trang.', 7);
