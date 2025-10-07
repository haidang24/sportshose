<!-- Start Modern Shop Section -->
<section class="modern-shop-section">
    <div class="container">
        <!-- Shop Header -->
        <div class="shop-header text-center mb-5">
            <h1 class="shop-title">Bộ Sưu Tập Giày Thể Thao</h1>
            <p class="shop-subtitle">Khám phá những mẫu giày thể thao cao cấp từ các thương hiệu hàng đầu thế giới</p>
        </div>

        <!-- Advanced Filters -->
        <div class="modern-filters mb-5">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-filter me-2"></i>Loại giày
                        </label>
                        <select id="shoes_type_id" class="modern-select">
                            <option value="">Tất cả loại giày</option>
                            <?php
                            $shoes_type = new Shoes_Type();
                            $shoes_type_result = $shoes_type->getAll_Shoes_Type();
                            while ($shoes_type_set = $shoes_type_result->fetch()):
                                ?>
                                <option value="<?php echo $shoes_type_set['id'] ?>"><?php echo $shoes_type_set['name'] ?></option>
                            <?php endwhile ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-tags me-2"></i>Thương hiệu
                        </label>
                        <select id="brand_id" class="modern-select">
                            <option value="">Tất cả thương hiệu</option>
                            <?php
                            $brand = new Brand();
                            $brand_result = $brand->getAll_Brand();
                            while ($brand_set = $brand_result->fetch()):
                                ?>
                                <option value="<?php echo $brand_set['id'] ?>"><?php echo $brand_set['name_brand'] ?></option>
                            <?php endwhile ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-sort-amount-down me-2"></i>Sắp xếp
                        </label>
                        <select id="sort_by" class="modern-select">
                            <option value="default">Mặc định</option>
                            <option value="price_asc">Giá: Thấp đến cao</option>
                            <option value="price_desc">Giá: Cao đến thấp</option>
                            <option value="name_asc">Tên: A-Z</option>
                            <option value="name_desc">Tên: Z-A</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-search me-2"></i>Tìm kiếm
                        </label>
                        <div class="search-input-group">
                            <input type="text" id="search_input" class="modern-search" placeholder="Nhập tên sản phẩm...">
                            <button class="search-btn" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tags -->
        <div class="filter-tags mb-4" id="filter_tags" style="display: none;">
            <div class="d-flex flex-wrap gap-2">
                <span class="filter-tag">
                    <span class="tag-text"></span>
                    <button class="tag-remove" type="button">
                        <i class="fas fa-times"></i>
                    </button>
                </span>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="products-container">
            <div class="row g-4" id="product_table">
                <!-- Products will be loaded here -->
            </div>
        </div>

        <!-- Loading Spinner -->
        <div class="loading-spinner text-center py-5" id="loading_spinner" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Đang tải sản phẩm...</p>
        </div>

        <!-- No Results -->
        <div class="no-results text-center py-5" id="no_results" style="display: none;">
            <div class="no-results-icon mb-3">
                <i class="fas fa-search fa-3x text-muted"></i>
            </div>
            <h4 class="text-muted">Không tìm thấy sản phẩm</h4>
            <p class="text-muted">Hãy thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
            <button class="btn btn-primary" onclick="clearAllFilters()">
                <i class="fas fa-refresh me-2"></i>Xóa bộ lọc
            </button>
        </div>
    </div>
</section>
<!-- End Modern Shop Section -->


<!-- Đổ dữ liệu ra và lọc bằng filter -->
<?php
    $product = new Product();
    $goods_sold = new Goods_sold();
    $product_result = $product->getProduct_ByNamePriceDiscount()->fetchAll();
?>

<script>
    const products = <?php echo json_encode($product_result) ?>;
    let filteredProducts = [...products];
    let currentFilters = {
        shoes_type: '',
        brand: '',
        sort: 'default',
        search: ''
    };

    // Show loading spinner
    function showLoading() {
        $('#loading_spinner').show();
        $('#product_table').hide();
        $('#no_results').hide();
    }

    // Hide loading spinner
    function hideLoading() {
        $('#loading_spinner').hide();
        $('#product_table').show();
    }

    // Update filter tags
    function updateFilterTags() {
        const tagsContainer = $('#filter_tags');
        const tags = [];
        
        if (currentFilters.shoes_type) {
            const shoesTypeName = $('#shoes_type_id option:selected').text();
            tags.push({ type: 'shoes_type', text: shoesTypeName, value: currentFilters.shoes_type });
        }
        
        if (currentFilters.brand) {
            const brandName = $('#brand_id option:selected').text();
            tags.push({ type: 'brand', text: brandName, value: currentFilters.brand });
        }
        
        if (currentFilters.search) {
            tags.push({ type: 'search', text: `"${currentFilters.search}"`, value: currentFilters.search });
        }

        if (tags.length > 0) {
            tagsContainer.show();
            tagsContainer.find('.d-flex').html('');
            tags.forEach(tag => {
                const tagElement = `
                    <span class="filter-tag">
                        <span class="tag-text">${tag.text}</span>
                        <button class="tag-remove" type="button" data-type="${tag.type}">
                            <i class="fas fa-times"></i>
                        </button>
                    </span>
                `;
                tagsContainer.find('.d-flex').append(tagElement);
            });
        } else {
            tagsContainer.hide();
        }
    }

    // Clear all filters
    function clearAllFilters() {
        $('#shoes_type_id').val('');
        $('#brand_id').val('');
        $('#sort_by').val('default');
        $('#search_input').val('');
        currentFilters = { shoes_type: '', brand: '', sort: 'default', search: '' };
        updateFilterTags();
        displayProducts(products);
    }

    // Sort products
    function sortProducts(products, sortBy) {
        switch(sortBy) {
            case 'price_asc':
                return products.sort((a, b) => (a.discount || a.price) - (b.discount || b.price));
            case 'price_desc':
                return products.sort((a, b) => (b.discount || b.price) - (a.discount || a.price));
            case 'name_asc':
                return products.sort((a, b) => a.name.localeCompare(b.name));
            case 'name_desc':
                return products.sort((a, b) => b.name.localeCompare(a.name));
            default:
                return products;
        }
    }

    // Filter and display products
    function filterProduct() {
        showLoading();
        
        setTimeout(() => {
            // Get current filter values
            currentFilters.shoes_type = $('#shoes_type_id').val();
            currentFilters.brand = $('#brand_id').val();
            currentFilters.sort = $('#sort_by').val();
            currentFilters.search = $('#search_input').val().toLowerCase();

            // Filter products
            filteredProducts = products.filter(product => {
                const matchesShoesType = !currentFilters.shoes_type || product.shoes_type_id == currentFilters.shoes_type;
                const matchesBrand = !currentFilters.brand || product.brand_id == currentFilters.brand;
                const matchesSearch = !currentFilters.search || product.name.toLowerCase().includes(currentFilters.search);
                
                return matchesShoesType && matchesBrand && matchesSearch;
            });

            // Sort products
            filteredProducts = sortProducts(filteredProducts, currentFilters.sort);

            // Update filter tags
            updateFilterTags();

            // Display products
            displayProducts(filteredProducts);
            
            hideLoading();
        }, 300);
    }

    // Display products
    function displayProducts(products) {
        const tableBody = $('#product_table');
        tableBody.empty();

        if (products.length === 0) {
            $('#no_results').show();
            return;
        }

        $('#no_results').hide();

        products.forEach(product => {
            const formattedPrice = numeral(product.price).format('0,0');
            const formattedDiscount = numeral(product.discount).format('0,0');
            const hasDiscount = product.discount > 0;
            const finalPrice = hasDiscount ? product.discount : product.price;
            const discountPercent = hasDiscount ? Math.round(((product.price - product.discount) / product.price) * 100) : 0;

            const productItem = `
                <div class="col-lg-3 col-md-6">
                    <div class="modern-product-card">
                        <div class="product-image-container">
                            <a href="index.php?action=details_product&id=${product.id}">
                                <img class="product-image" src="./View/assets/img/upload/${product.img}" alt="${product.name}">
                            </a>
                            <div class="product-overlay">
                                <div class="product-actions">
                                    <a href="index.php?action=details_product&id=${product.id}" class="action-btn view-btn">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="action-btn cart-btn" data-product-id="${product.id}">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                    <button class="action-btn wishlist-btn" data-product-id="${product.id}">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                            ${hasDiscount ? `
                                <div class="product-badge">
                                    <span class="badge discount-badge">-${discountPercent}%</span>
                                </div>
                            ` : ''}
                        </div>
                        <div class="product-info">
                            <h5 class="product-name">
                                <a href="index.php?action=details_product&id=${product.id}">${product.name}</a>
                            </h5>
                            <div class="product-price">
                                ${hasDiscount ? `
                                    <span class="current-price">${formattedDiscount}đ</span>
                                    <span class="original-price">${formattedPrice}đ</span>
                                ` : `
                                    <span class="current-price">${formattedPrice}đ</span>
                                `}
                            </div>
                            <div class="product-features">
                                <span class="feature-badge">
                                    <i class="fas fa-check-circle"></i>
                                    Chính hãng 100%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            tableBody.append(productItem);
        });
    }

    // Event listeners
    $('#shoes_type_id, #brand_id, #sort_by').change(filterProduct);
    $('#search_input').on('input', debounce(filterProduct, 300));

    // Filter tag removal
    $(document).on('click', '.tag-remove', function() {
        const type = $(this).data('type');
        switch(type) {
            case 'shoes_type':
                $('#shoes_type_id').val('');
                break;
            case 'brand':
                $('#brand_id').val('');
                break;
            case 'search':
                $('#search_input').val('');
                break;
        }
        filterProduct();
    });

    // Debounce function for search
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // Initialize - Show all products without filters
    displayProducts(products);
</script>

