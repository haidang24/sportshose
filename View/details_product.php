<!-- Open Content -->
<section class="modern-detail-section bg-light">
    <div class="container pb-5">
        <div class="row gy-4">
            <?php
            $product = new Product();
            $id = isset($_GET['id']) ? $_GET['id'] : null; // Khởi tạo biến $id
            $product_result = $product->getOne_DetailProduct($id);
            ?>
            <div class="col-lg-5 mt-5">
                <div class="product-gallery card mb-3">
                    <div class="gallery-main">
                        <img class="card-img img-fluid" data-src="<?php echo $product_result['img'] ?>"
                            src="./View/assets/img/upload/<?php echo $product_result['img'] ?>" alt="<?php echo $product_result['tensp'] ?>"
                            id="product-detail" onerror="this.src='./View/assets/img/placeholder.jpg'">
                        <?php if ($product_result['discount'] > 0): ?>
                            <span class="detail-badge">-
                                <?php echo round((($product_result['price'] - $product_result['discount']) / $product_result['price']) * 100) ?>%
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="gallery-thumbs mt-3">
                        <img class="thumb-item cursor active" src="./View/assets/img/upload/<?php echo $product_result['img'] ?>" alt="thumb"
                             data-src="<?php echo $product_result['img'] ?>" onerror="this.src='./View/assets/img/placeholder.jpg'">
                        <img class="thumb-item cursor" src="./View/assets/img/upload/<?php echo $product_result['img1'] ?>" alt="thumb"
                             data-src="<?php echo $product_result['img1'] ?>" onerror="this.src='./View/assets/img/placeholder.jpg'">
                        <img class="thumb-item cursor" src="./View/assets/img/upload/<?php echo $product_result['img2'] ?>" alt="thumb"
                             data-src="<?php echo $product_result['img2'] ?>" onerror="this.src='./View/assets/img/placeholder.jpg'">
                        <img class="thumb-item cursor" src="./View/assets/img/upload/<?php echo $product_result['img3'] ?>" alt="thumb"
                             data-src="<?php echo $product_result['img3'] ?>" onerror="this.src='./View/assets/img/placeholder.jpg'">
                    </div>
                </div>
            </div>
            <!-- col end -->
            <div class="col-lg-7 mt-5">
                <div class="card modern-detail-card">
                    <div class="card-body p-4">
                        <input type="hidden" id="idsp" value="<?php echo $product_result['id'] ?>">
                        <h4 class="detail-title" id="name_product"><?php echo $product_result['tensp'] ?></h4>
                        <div class="detail-price d-flex align-items-end gap-3">
                            <?php if ($product_result['discount'] == 0) { ?>
                                <span data-value="<?php echo $product_result['discount'] ?>" id="discount"
                                    class="py-2 mx-3 text-danger" style="display: none;"></span>
                                <p data-value="<?php echo $product_result['price'] ?>" id="price"
                                    class="text-danger fw-bold current-price mb-1"><?php echo number_format($product_result['price']) ?>đ</p>
                            <?php } else { ?>
                                <p data-value="<?php echo $product_result['price'] ?>" id="price"
                                    class="text-muted text-decoration-line-through original-price mb-1">
                                    <?php echo number_format($product_result['price']) ?>đ
                                </p>
                                <h4 data-value="<?php echo $product_result['discount'] ?>" id="discount"
                                    class="text-danger fw-bold current-price mb-1"><?php echo number_format($product_result['discount']) ?>đ
                                </h4>
                            <?php } ?>
                        </div>
                        <p class="py-2 detail-rating">
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-secondary"></i>
                        </p>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Loại giày:</h6>
                            </li>
                            <li class="list-inline-item">
                                <p id="shoes_type" value="<?php echo $product_result['tenloai']; ?>"
                                    class="text-secondary">
                                    <strong><?php echo strtoupper($product_result['tenloai']) ?></strong>
                                </p>
                            </li>
                            <li class="list-inline-item">
                                <h6>Thương hiệu:</h6>
                            </li>
                            <li class="list-inline-item">
                                <p id="brand" value="<?php echo $product_result['name_brand']; ?>"
                                    class="text-secondary">
                                    <strong><?php echo strtoupper($product_result['name_brand']) ?></strong>
                                </p>
                            </li>
                        </ul>

                        <p class="detail-desc text-secondary mb-4"><?php echo $product_result['descriptions'] ?></p>

                        <input type="hidden" name="product-title" value="Activewear">
                        <div class="row">
                            <div class="col-auto">
                                <ul class="list-inline pb-3 detail-sizes">
                                    <li class="list-inline-item fw-bolder" style="font-size: 16px!important;">Kích thước:</li>
                                    <?php
                                    $size = new size();
                                    $size_result = $size->getSize_ByDetails($id);
                                    while ($size_set = $size_result->fetch()):
                                        ?>
                                        <li class="list-inline-item"><span class="btn btn-outline-primary btn-size size-chip"
                                                data-size_id="<?php echo $size_set['size_id'] ?>"><?php echo $size_set['size'] ?></span>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            </div>
                            <div class="col-auto">
                                <ul class="list-inline pb-3 detail-qty">
                                    <li class="list-inline-item text-right fw-bolder" style="font-size: 16px!important;">Số lượng</li>
                                    <li class="list-inline-item"><span class="qty-btn" id="btn-minus">-</span></li>
                                    <li class="list-inline-item"><span class="qty-value" id="var-value">1</span></li>
                                    <li class="list-inline-item"><span class="qty-btn" id="btn-plus">+</span></li>
                                    <input type="hidden" name="product-quanity" id="product-quanity" value="1">
                                </ul>
                            </div>
                            <div class="col-auto">
                                <input type="hidden" id="product_id" value="<?php echo $id ?>">
                                <span id="repository" class="text-secondary fs-6 fw-bold"></span>
                            </div>
                        </div>
                        <div class="row pb-3 g-3">
                            <div class="col-md d-grid">
                                <!-- Button trigger modal -->
                                <button id="buy_now" type="button" class="btn btn-primary btn-lg modern-cta d-none" data-bs-toggle="modal">Mua
                                    hàng ngay</button>
                                <input id="product_id" type="hidden" value="<?php echo $_GET['id'] ?>">
                                <!-- Modal -->
                                <div class="modal fade" id="ModalBuy_Now" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Xác nhận mua hàng
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="d-flex mb-4">
                                                    <img style="width: 150px; height: 150px; border-radius: 30px;"
                                                        id="product_img" src="" alt="">
                                                    <div class="mx-3 mt-3">
                                                        <b id="product_name"></b> <br>
                                                        <div class="d-flex">
                                                            <span id="product_price"></span>
                                                            <span class="mx-1 ml-1">x</span>
                                                            <span id="product_quantity"></span>
                                                            <span class="mx-1 ml-1">=</span>
                                                            <span id="product_sum"></span>
                                                        </div>
                                                        <div class="d-flex">
                                                            <span>Size: </span>
                                                            <span class="mx-1" id="product_size"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <input type="hidden" id="user_id"
                                                    value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0 ?>">
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-1">Họ tên khách hàng</label>
                                                    <input type="text"
                                                        value="<?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '' ?>"
                                                        id="fullname" class="form-control"
                                                        placeholder="Điền họ tên của bạn">
                                                    <small id="fullname_error" class="text-danger badge"></small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-1">Số điện thoại</label>
                                                    <input type="text"
                                                        value="<?php echo isset($_SESSION['number_phone']) ? '0' . $_SESSION['number_phone'] : '' ?>"
                                                        id="number_phone" class="form-control"
                                                        placeholder="Điền số điện của bạn">
                                                    <small id="number_phone_error" class="text-danger badge"></small>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="" class="mb-1">Địa chỉ</label>
                                                    <input
                                                        value="<?php echo isset($_SESSION['address']) ? $_SESSION['address'] : '' ?>"
                                                        type="text" id="address" class="form-control"
                                                        placeholder="Điền địa chỉ của bạn">
                                                    <small id="address_error" class="text-danger badge"></small>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div class="form-group">
                                                        <label for="wards">Tỉnh/Thành</label>
                                                        <select style="width: 140px" class="form-control"
                                                            name="province" id="province">
                                                            <option value=>Chọn tỉnh/thành</option>
                                                            <?php
                                                            $Address = new Address_Order();
                                                            $Address_Result = $Address->getAll_Province();
                                                            while ($Address_set = $Address_Result->fetch()):
                                                                ?>
                                                                <option <?php echo (isset($_SESSION['province']) && $_SESSION['province'] == $Address_set['name']) ? 'selected' : '' ?>
                                                                    value="<?php echo $Address_set['province_id'] ?>">
                                                                    <?php echo $Address_set['name'] ?>
                                                                </option>
                                                            <?php endwhile ?>
                                                        </select>
                                                        <small id="province_error" class="text-danger badge"
                                                            style="font-size: 11px;"></small>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="wards">Quận/Huyện</label>
                                                        <select style="width: 140px" class="form-control"
                                                            name="district" id="district">
                                                            <option
                                                                value="<?php echo isset($_SESSION['district_id']) ? $_SESSION['district_id'] : '' ?>">
                                                                <?php echo (isset($_SESSION['district'])) ? $_SESSION['district'] : 'Chọn Quận/Huyện' ?>
                                                            </option>
                                                        </select>
                                                        <small id="district_error" class="text-danger badge"
                                                            style="font-size: 11px;"></small>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="wards">Phường/Xã</label>
                                                        <select style="width: 140px" class="form-control" name="wards"
                                                            id="wards">
                                                            <option
                                                                value="<?php echo isset($_SESSION['wards_id']) ? $_SESSION['wards_id'] : '' ?>">
                                                                <?php echo (isset($_SESSION['wards'])) ? $_SESSION['wards'] : 'Chọn Phường/Xã' ?>
                                                            </option>
                                                        </select>
                                                        <small id="wards_error" class="text-danger badge"
                                                            style="font-size: 11px;"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button id="order_buy_now" type="button" class="btn btn-success">Xác
                                                    nhận</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md d-grid">
                                <button id="addCart" class="btn btn-outline-primary btn-lg modern-cta-outline">Thêm vào giỏ</button>
                            </div>
                        </div>
                        <div class="detail-benefits">
                            <span><i class="fas fa-shipping-fast"></i> Giao nhanh 24-72h</span>
                            <span><i class="fas fa-undo"></i> Đổi trả 7 ngày</span>
                            <span><i class="fas fa-shield-alt"></i> Bảo hành chính hãng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container modern-comments mt-4">
        <div class="d-flex align-items-center mb-3">
            <h3 class="comments-title">Đánh giá sản phẩm</h3>
            <span class="comments-subtitle">Chia sẻ cảm nhận của bạn để mọi người tham khảo</span>
        </div>
        <!-- Lấy id theo đường dẫn -->
        <input id="comment_product_id" type="hidden" value="<?php echo $id ?>">
        <?php if (isset($_SESSION['user_id'])) { ?>
            <div class="row g-3">
                <!-- Nếu đăng nhập mới có session -->
                <input id="comment_user_id" type="hidden" value="<?php echo $_SESSION['user_id'] ?>">
                <?php
                $comment = new Comment();
                $result = $comment->get_avatar($_SESSION['user_id'])
                ?>
                <div class="col-12">
                    <!-- Đánh giá sản phẩm -->
                    <div class="comment-box card p-3 p-md-4">
                        <div class="d-flex gap-3">
                            <img class="comment-avatar"
                                src="./View/assets/img/avatar/<?php echo ($result) ? $result['avatar'] : 'avatar-trang-4.jpg' ?>"
                                alt="avatar">
                            <div class="flex-grow-1">
                                <textarea id="content_comment" placeholder="Hãy chia sẻ trải nghiệm sản phẩm của bạn (tối thiểu 10 ký tự)"
                                    class="comment-input form-control" rows="4"></textarea>
                                <div class="comment-actions d-flex justify-content-between align-items-center mt-2">
                                    <div class="d-flex align-items-center gap-3">
                                        <label for="comment_image" class="btn btn-light btn-sm comment-upload">
                                            <i class="fas fa-image me-1"></i> Tải ảnh
                                        </label>
                                        <input type="file" id="comment_image" class="form-control d-none" accept="image/*">
                                        <small class="preview_comment_error text-danger"></small>
                                    </div>
                                    <button id="send_comment" class="btn btn-primary btn-sm px-4">Gửi đánh giá</button>
                                </div>
                                <img class="comment-preview d-none" id="preview_comment_image" src="" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- Table comment -->
        <div class="comments-list row table_comment"></div>

        <!-- Modal Chỉnh Sửa Bình Luận -->
        <div class="modal fade" id="model_update_comment" tabindex="-1" aria-labelledby="model_update_commentLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-success" id="exampleModalLabel">Chỉnh sửa bình luận</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class='form-group mb-3'>
                            <input type="hidden" id="model_update_comment_id" value="" class="form-control">
                            <label>Nội dung</label>
                            <input id="update_content_comment" type="text" class="form-control">
                        </div>
                        <div class='form-group'>
                            <div class="d-flex justify-content-end">
                                <button data-comment_id="" id="delete_img_comment"
                                    class="btn btn-dark d-none position-absolute"><i class="bi bi-x-lg"></i></button>
                            </div>
                            <img id="update_img_comment" class="d-none" style="width: 100%; height: 300px" src=""
                                alt="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button data-comment_id="${item.id}" type="button" id="update_comment_action"
                            class="btn btn-outline-success">Cập nhật</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


<style>
    .cursor {
        cursor: pointer;
    }
</style>

<script>
    // Thumbnail switcher
    document.addEventListener('DOMContentLoaded', function () {
        const mainImg = document.getElementById('product-detail');
        const thumbs = document.querySelectorAll('.thumb-item');
        thumbs.forEach(t => {
            t.addEventListener('click', () => {
                thumbs.forEach(x => x.classList.remove('active'));
                t.classList.add('active');
                const src = t.getAttribute('data-src');
                if (src && mainImg) {
                    mainImg.src = './View/assets/img/upload/' + src;
                }
            });
        });
    });
</script>