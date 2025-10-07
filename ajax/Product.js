// Chức năng lọc sản phẩm theo select
function filter_product(shoes_type_id, brand_id) {
   filtered_Products = product.filter(product => {
      return shoes_type_id == product.shoes_type_id && brand_id == product.brand_id;
   });
   return filtered_Products;
}

// Function hiển thị sản phẩm theo dạng table
function display_product_table(products) {
   $('#table_product').empty();
   products.forEach(item => {
      const row = `
           <tr>
               <td>
                   <input type="checkbox" class="form-check-input product-checkbox" value="${item.id}">
               </td>
               <td>
                   <img class="product-image" src="View/assets/img/upload/${item.img}" alt="${item.name}" onerror="this.src='View/assets/img/placeholder.jpg'">
               </td>
               <td>
                   <div class="product-info">
                       <div class="product-name">${item.name}</div>
                       <div class="product-id">ID: ${item.id}</div>
                   </div>
               </td>
               <td>
                   <div class="product-description">${item.descriptions || 'Không có mô tả'}</div>
               </td>
               <td>
                   <div class="product-category">
                       <small>Loại: ${getShoesTypeName(item.shoes_type_id)}</small><br>
                       <small>Thương hiệu: ${getBrandName(item.brand_id)}</small>
                   </div>
               </td>
               <td>
                   <span class="badge ${item.hidden == 1 ? 'badge-warning' : 'badge-success'}">
                       ${item.hidden == 1 ? 'Ẩn' : 'Hiện'}
                   </span>
               </td>
               <td>
                  <div class="btn-group" role="group">
                     <a href="admin.php?action=product&act=product_details&id=${item.id}" class="btn btn-outline-primary btn-sm" title="Xem chi tiết">
                        <i class="fas fa-eye"></i>
                     </a>
                     <button class="btn btn-outline-danger btn-sm" onclick="toggleProductVisibility(${item.id}, ${item.hidden})" title="${item.hidden == 1 ? 'Hiện sản phẩm' : 'Ẩn sản phẩm'}">
                        <i class="fas fa-${item.hidden == 1 ? 'eye' : 'eye-slash'}"></i>
                     </button>
                     <button class="btn btn-outline-danger btn-sm" onclick="deleteProduct(${item.id})" title="Xóa sản phẩm">
                        <i class="fas fa-trash"></i>
                     </button>
                  </div>               
               </td>
           </tr>`;
      $('#table_product').append(row);
   });
}

// Function hiển thị sản phẩm theo dạng grid
function display_product_grid(products) {
   $('#grid_products').empty();
   products.forEach(item => {
      const card = `
           <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
               <div class="grid-product-card">
                   <img class="grid-product-image" src="View/assets/img/upload/${item.img}" alt="${item.name}" onerror="this.src='View/assets/img/placeholder.jpg'">
                   <div class="grid-product-name">${item.name}</div>
                   <div class="grid-product-description">${item.descriptions || 'Không có mô tả'}</div>
                   <div class="d-flex justify-content-between align-items-center mb-2">
                       <span class="badge ${item.hidden == 1 ? 'badge-warning' : 'badge-success'}">
                           ${item.hidden == 1 ? 'Ẩn' : 'Hiện'}
                       </span>
                       <small class="text-muted">ID: ${item.id}</small>
                   </div>
                   <div class="btn-group w-100" role="group">
                       <a href="admin.php?action=product&act=product_details&id=${item.id}" class="btn btn-outline-primary btn-sm">
                           <i class="fas fa-eye"></i>
                       </a>
                       <button class="btn btn-outline-danger btn-sm" onclick="toggleProductVisibility(${item.id}, ${item.hidden})">
                           <i class="fas fa-${item.hidden == 1 ? 'eye' : 'eye-slash'}"></i>
                       </button>
                       <button class="btn btn-outline-danger btn-sm" onclick="deleteProduct(${item.id})">
                           <i class="fas fa-trash"></i>
                       </button>
                   </div>
               </div>
           </div>`;
      $('#grid_products').append(card);
   });
}

// Function cũ để tương thích
function display_product(shoes_type_id, brand_id) {
   const filteredProducts = filter_product(shoes_type_id, brand_id);
   update_product_count(filteredProducts.length);
   
   if (currentView === 'list') {
      display_product_table(filteredProducts);
   } else {
      display_product_grid(filteredProducts);
   }
}


$(document).ready(() => {
   product = [];
   let currentView = 'list'; // Default view
   
   // Đổ sản phẩm 
   function get_all_product() {
      $('#loading_state').show();
      $('#empty_state').addClass('d-none');
      $('#table_view').hide();
      $('#grid_view').addClass('d-none');
      
      $.ajax({
         url: 'Controller/Admin/product.php?act=get_all_product',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            product = res;
            $('#loading_state').hide();
            
            // Hiển thị tất cả sản phẩm khi vào trang (không lọc mặc định)
            display_all_products();
            update_product_count();
         },
         error: function() {
            $('#loading_state').hide();
            $('#empty_state').removeClass('d-none');
         }
      })
   }
   get_all_product();

   // Hiển thị tất cả sản phẩm
   function display_all_products() {
      if (product.length === 0) {
         $('#empty_state').removeClass('d-none');
         $('#table_view').hide();
         $('#grid_view').addClass('d-none');
         return;
      }
      
      $('#empty_state').addClass('d-none');
      
      if (currentView === 'list') {
         display_product_table(product);
         $('#table_view').show();
         $('#grid_view').addClass('d-none');
      } else {
         display_product_grid(product);
         $('#table_view').hide();
         $('#grid_view').removeClass('d-none');
      }
   }

   // Xử lý sự kiện khi click nút lọc
   $('#filter_btn').on('click', function () {
      var shoes_type_id = $('#shoes_type_id').val();
      var brand_id = $('#brand_id').val();
      
      if (!shoes_type_id && !brand_id) {
         display_all_products();
         return;
      }
      
      display_product(shoes_type_id, brand_id);
   });

   // Xử lý sự kiện khi click nút xóa lọc
   $('#clear_filter_btn').on('click', function () {
      $('#shoes_type_id').val('');
      $('#brand_id').val('');
      display_all_products();
   });

   // Xử lý sự kiện khi thay đổi giá trị của select (auto filter)
   $('#shoes_type_id, #brand_id').on('change', function () {
      var shoes_type_id = $('#shoes_type_id').val();
      var brand_id = $('#brand_id').val();
      
      if (!shoes_type_id && !brand_id) {
         display_all_products();
      } else {
         display_product(shoes_type_id, brand_id);
      }
   });

   // Xử lý toggle view (list/grid)
   $('#view_list').on('click', function() {
      currentView = 'list';
      $(this).addClass('active');
      $('#view_grid').removeClass('active');
      
      if (product.length > 0) {
         display_all_products();
      }
   });

   $('#view_grid').on('click', function() {
      currentView = 'grid';
      $(this).addClass('active');
      $('#view_list').removeClass('active');
      
      if (product.length > 0) {
         display_all_products();
      }
   });

   // Xử lý select all checkbox
   $('#select_all').on('change', function() {
      $('.product-checkbox').prop('checked', this.checked);
   });

   // Thêm sản phẩm 
   $(document).on('submit', '#form_add_product', function (event) {
      event.preventDefault();
      var form_add_product = new FormData(this);

      // Kiểm tra trống 
      name_product = check_empty('#name_product');
      img = check_empty('#img');
      descriptions = check_empty('#descriptions');

      if (name_product == false && img == false && descriptions == false) {
         $.ajax({
            url: 'Controller/Admin/product.php?act=add_action',
            method: 'post',
            data: form_add_product,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: (res) => {
               if (res.status == 200) {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: res.message,
                     showConfirmButton: false,
                     timer: 1500
                  });
                  $('#name_product').val('')
                  $('#descriptions').val('')
                  $('#img').val('')
                  $('#preview_img').addClass('d-none');
                  display_product(4, 2); // Hiển thị sản phẩm ngay khi tải trang

               } else if (res.status == 404) {
                  Swal.fire({
                     icon: "error",
                     text: res.message,
                  });
               }
            },
            error: (error) => console.log(error)
         })
      }
   })

   // Thực hiện việc xóa sản phẩm
   $(document).on('click', '#delete_product', function () {
      let product_id = $(this).data('product_id');

      if (checkFeature('Xóa sản phẩm', (result) => {
         if (result) {
            Swal.fire({
               title: "Bạn có chắc chắn?",
               text: "Bạn sẽ bị mất tất cả chi tiết sản phẩm!",
               icon: "warning",
               showCancelButton: true,
               confirmButtonColor: "#3085d6",
               cancelButtonColor: "#d33",
               confirmButtonText: "Xóa!",
               cancelButtonText: "Hủy!"
            }).then((result) => {
               if (result.isConfirmed) {
                  $.ajax({
                     url: 'Controller/Admin/product.php?act=delete_product',
                     method: 'POST',
                     data: { product_id },
                     dataType: 'json',
                     success: (res) => {
                        Swal.fire({
                           position: "top-center",
                           icon: "success",
                           title: res.message,
                           showConfirmButton: false,
                           timer: 1500
                        });
                        get_all_product()
                     }
                  });
               }
            });
         } else {
            Swal.fire("Bạn không có quyền sử dụng chức năng này!");
         }
      }));
   });


   // Chỉnh sửa sản phẩm
   $(document).on('submit', '#form_Product', function (event) {
      event.preventDefault();
      let id = $('#id_product').val();
      let name = $('#name_product').val();
      let shoes_type_id = $('#shoes_type').val();
      let brand_id = $('#brand').val();
      let descriptions = $('#descriptions_product').val();
      let img = $('#preview_img').attr('src').slice(25); // Lấy giá trị của files khi form được submit

      // Check validate trống
      checkValidate = ['#name_product', '#descriptions_product']; // Thêm ký tự "#" để tham chiếu đến id của từng trường nhập liệu
      var flag = false;
      checkValidate.forEach(field => {
         let value = $(field).val(); // Lấy giá trị của từng trường nhập liệu
         if (value.trim() == '') {
            flag = true;
            $(field + '_error').text(`Giá trị không được để trống`);
         }
      });

      if (flag == false) {
         $.ajax({
            url: 'Controller/Admin/product.php?act=update_actionPro',
            method: 'POST',
            data: {
               id,
               name,
               shoes_type_id,
               brand_id,
               descriptions,
               img,
            },
            dataType: 'json',
            success: (res) => {
               if (res.status == 400) {
                  Swal.fire({
                     icon: "error",
                     text: res.message,
                  });
               } else if (res.status == 200) {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: "Dự liệu đã được thay đổi",
                     showConfirmButton: false,
                     timer: 1500
                  });
               }
            }
         })
      }
   })

   // hiển modal thêm chi tiết
   $(document).on('click', '#add_product_details', function () {
      if (checkFeature('Thêm chi tiết sản phẩm', (result) => {
         if (result) {
            $('#modal_add_product_details').modal('show')
         } else {
            Swal.fire("Bạn không có quyền sử dụng chức năng này!");
         }
      }));
   })

   // Thêm chi tiết sản phẩm
   $(document).on('submit', '#add_product_details', function (event) {
      event.preventDefault();
      flag = false;
      // Kiểm tra trống
      result_empty = check_empty('#price', '#img1', '#img2', '#img3');
      // Giảm giá không được lớn hơn đơn giá
      if ($('#price').val() <= $('#discount').val()) {
         $('#discount_error').text('Giảm giá phải nhỏ hơn đơn giá')
         flag = true;
      } else {
         $('#discount_error').text('')
         flag = false;
      }

      if (flag == false && result_empty == false) {
         form_product = new FormData(this);
         $.ajax({
            url: "Controller/Admin/product.php?act=add_product_details_action",
            method: 'POST',
            data: form_product,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: (res) => {
               if (res.status == 200) {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: res.message,
                     showConfirmButton: false,
                     timer: 1500
                  }).then(() => {
                     window.location.reload();
                  });
                  $('#price').val('');
                  $('#discount').val(0);
                  $('#img1').val('');
                  $('#img2').val('');
                  $('#img3').val('');
                  $('#preview_img1').addClass('d-none');
                  $('#preview_img2').addClass('d-none');
                  $('#preview_img3').addClass('d-none');

               } else if (res.status == 404) {
                  $('#size_error').text(res.message);
               }
            }
         })
      }
   })

   // Xóa chi tiết sản phẩm
   $(document).on('click', '#delete_product_details', function () {
      product_details_id = $(this).data('product_details_id');
      if (checkFeature('Xóa chi tiết sản phẩm', (result) => {
         if (result) {
            Swal.fire({
               title: "Bạn có chắc chắn?",
               text: "Bạn sẽ không khôi phục được dữ liệu!",
               icon: "warning",
               showCancelButton: true,
               confirmButtonColor: "#3085d6",
               cancelButtonColor: "#d33",
               confirmButtonText: "Xóa!",
               cancelButtonText: "Hủy!"
            }).then((result) => {
               if (result.isConfirmed) {
                  $.ajax({
                     url: 'Controller/Admin/product.php?act=delete_ProductDetails',
                     method: 'post',
                     data: { product_details_id },
                     dataType: 'json',
                     success: (res) => {
                        console.log(res);
                        Swal.fire({
                           position: "top-center",
                           icon: "success",
                           title: res.message,
                           showConfirmButton: false,
                           timer: 1500
                        });
                        setTimeout(() => {
                           window.location.reload();
                        }, 1500);
                     }, error: (error) => console.log(error)
                  });
               }
            });
         } else {
            Swal.fire("Bạn không có quyển sử dụng chức năng này!");
         }
      }));
   })

   // Chỉnh sửa chi tiết sản phẩm
   $(document).on('submit', '#formProduct_Details', function (event) {
      event.preventDefault();

      if (checkFeature('Chỉnh sửa chi tiết sản phẩm', (result) => {
         if (result) {
            let id = $('#id').val();
            let price = parseFloat($('#price').val().replace(/[^0-9]/g, ""));
            let discount = parseFloat($('#discount').val().replace(/[^0-9]/g, ""));
            let quantity = $('#quantity').val();
            let size = $('#size').val();
            let img1 = $('#img1')[0].files[0];
            let img2 = $('#img2')[0].files[0];
            let img3 = $('#img3')[0].files[0];

            // Check validate trống và phải là số
            checkValidate = ['#price', '#discount', '#quantity']; // Thêm ký tự "#" để tham chiếu đến id của từng trường nhập liệu
            var flag = false;

            // Giảm giá phải nhỏ hơn đơn giá
            if (price <= discount) {
               $('#discount_error').text('Giảm giá phải nhỏ hơn đơn giá');
               flag = true;
            }

            // tối ưu chỗ này bằng vòng lặp 
            let hinh1; // Khai báo biến hinh1 trước khi sử dụng
            if (img1 == undefined) {
               hinh1 = $('#preview_img1').val();
            } else {
               hinh1 = img1.name;
            }

            let hinh2; // Khai báo biến hinh2 trước khi sử dụng
            if (img2 == undefined) {
               hinh2 = $('#preview_img2').val();
            } else {
               hinh2 = img2.name;
            }

            let hinh3; // Khai báo biến hinh3 trước khi sử dụng
            if (img3 == undefined) {
               hinh3 = $('#preview_img3').val();
            } else {
               hinh3 = img3.name;
            }

            if (flag == false) {
               $.ajax({
                  url: 'Controller/Admin/product.php?act=update_action',
                  method: 'POST',
                  data: {
                     id,
                     price,
                     discount,
                     quantity,
                     size,
                     hinh1,
                     hinh2,
                     hinh3
                  },
                  success: (res) => {
                     let data = JSON.parse(res);
                     console.log(data.status);
                     if (data.status == 200) {
                        Swal.fire({
                           position: "top-center",
                           icon: "success",
                           title: "Chỉnh sửa thành công",
                           showConfirmButton: false,
                           timer: 1500
                        });
                        $('#img1').val('');
                        $('#img2').val('');
                        $('#img3').val('');
                     } else if (data.status == 404) {
                        Swal.fire({
                           icon: "error",
                           title: "Lỗi...",
                           text: "Tệp không phải là ảnh!",
                        });
                        $('#img_error').text(data.message);
                     }
                  }
               })
            }
         } else {
            Swal.fire("Bạn không có quyền sử dụng chức năng này!");
         }
      }));

   });

   // Đổ sản phẩm phần brand
   function getAll_Brand() {
      $.ajax({
         url: 'Controller/Admin/product.php?act=getAll_Brand',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            var stt = 1
            $('#table_brand').empty();
            res.forEach(item => {
               var row = `
               <tr>
                  <td>${stt++}</td>
                  <td>${item.name_brand}</td>
                  <td>
                     <button class="btn btn-outline-danger bi bi-trash3-fill brand_id" data-brand_id="${item.id}"></button>
                  </td>
               </tr>
               `;
               $('#table_brand').append(row);
            })
         }
      })
   }
   getAll_Brand();
   // Thêm phần brand
   $(document).on('submit', '#form_Brand', function (event) {
      event.preventDefault();

      if (checkFeature('Thêm, xóa thương hiệu', (result) => {
         if (result) {
            name_brand = $('#name_brand').val();
            flag = false;
            if (name_brand.trim() == '') {
               flag = true;
               $('#name_brand_error').text('Thương hiệu không được để trống');
            } else {
               $('#name_brand_error').text('');
            }

            if (flag == false) {
               $.ajax({
                  url: 'Controller/Admin/product.php?act=add_brand',
                  method: 'POST',
                  data: { name_brand: name_brand },
                  dataType: 'json',
                  success: (res) => {
                     if (res.status == 200) {
                        Swal.fire({
                           position: "top-center",
                           icon: "success",
                           title: res.message,
                           showConfirmButton: false,
                           timer: 1500
                        });
                        $('#name_brand').val('');
                        getAll_Brand();
                     } else if (res.status == 403) {
                        $('#name_brand_error').text(res.message);
                     }
                  }
               })
            }
         } else {
            Swal.fire("Bạn không có quyền sử dụng tính năng này");
         }
      }));
   })

   // Xóa phần brand

   $(document).on('click', '.brand_id', function () {
      var brand_id = $(this).data('brand_id');

      if (checkFeature('Thêm, xóa thương hiệu', (result) => {
         if (result) {
            Swal.fire({
               title: "Bạn có chắn chắn?",
               text: "Bạn sẽ không thể khôi phục nó!",
               icon: "warning",
               showCancelButton: true,
               confirmButtonColor: "#3085d6",
               cancelButtonColor: "#d33",
               confirmButtonText: "Xóa!",
               cancelButtonText: "Hủy!"
            }).then((result) => {
               if (result.isConfirmed) {
                  $.ajax({
                     url: 'Controller/Admin/product.php?act=delete_brand',
                     method: 'POST',
                     data: { brand_id: brand_id },
                     dataType: 'json',
                     success: (res) => {
                        if (res.status = 200) {
                           Swal.fire({
                              position: "top-center",
                              icon: "success",
                              title: res.message,
                              showConfirmButton: false,
                              timer: 1500
                           });
                           getAll_Brand()
                        }
                     },
                     error: (xhr, status, error) => {
                        // Xử lý lỗi nếu cần thiết
                        Swal.fire({
                           position: "top-center",
                           icon: "error",
                           title: "Không Thể Xóa!",
                           text: "Tên thương hiệu đang tồn tại sản phẩm",
                           showConfirmButton: true,
                        });
                     }
                  })
               }
            });
         } else {
            Swal.fire("Bạn không có quyền sử dụng tính năng này");
         }
      }));
   });

   // Đổ sản phẩm phần brand
   function getAll_ShoesType() {
      $.ajax({
         url: 'Controller/Admin/product.php?act=getAll_ShoesType',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            var stt = 1
            $('#table_shoes_type').empty();
            res.forEach(item => {
               var row = `
               <tr>
                  <td>${stt++}</td>
                  <td>${item.name}</td>
                  <td>
                     <button class="btn btn-outline-danger bi bi-trash3-fill shoes_type_id" data-shoes_type_id="${item.id}"></button>
                  </td>
               </tr>
               `;
               $('#table_shoes_type').append(row);
            })
         }
      })
   }
   getAll_ShoesType();

   // Thêm phần shoes_type
   $(document).on('submit', '#form_shoes_type', function (event) {
      event.preventDefault();

      if (checkFeature('Thêm, xóa loại giày', (result) => {
         if (result) {
            name_shoes_type = $('#name_shoes_type').val();
            flag = false;
            if (name_shoes_type.trim() == '') {
               flag = true;
               $('#name_shoes_type_error').text('Loại giày không được để trống');
            } else {
               $('#name_shoes_type_error').text('');
            }

            if (flag == false) {
               $.ajax({
                  url: 'Controller/Admin/product.php?act=add_shoes_type',
                  method: 'POST',
                  data: { name_shoes_type: name_shoes_type },
                  dataType: 'json',
                  success: (res) => {
                     if (res.status == 200) {
                        Swal.fire({
                           position: "top-center",
                           icon: "success",
                           title: res.message,
                           showConfirmButton: false,
                           timer: 1500
                        });
                        $('#name_shoes_type').val('');
                        getAll_ShoesType();
                     } else if (res.status == 403) {
                        $('#name_shoes_type_error').text(res.message);
                     }
                  }
               })
            }
         } else {
            Swal.fire("Bạn không có quyền sử dụng tính năng này");
         }
      }));
   });

   // Xóa phần shoes_type_id
   $(document).on('click', '.shoes_type_id', function () {
      var shoes_type_id = $(this).data('shoes_type_id');
      if (checkFeature('Thêm, xóa loại giày', (result) => {
         if (result) {
            Swal.fire({
               title: "Bạn có chắc chắn?",
               text: "Bạn sẽ không thể khôi phục nó!",
               icon: "warning",
               showCancelButton: true,
               confirmButtonColor: "#3085d6",
               cancelButtonColor: "#d33",
               confirmButtonText: "Xóa!",
               cancelButtonText: "Hủy!"
            }).then((result) => {
               if (result.isConfirmed) {
                  $.ajax({
                     url: 'Controller/Admin/product.php?act=delete_shoes_type',
                     method: 'POST',
                     data: { shoes_type_id: shoes_type_id },
                     dataType: 'json',
                     success: (res) => {
                        if (res.status = 200) {
                           Swal.fire({
                              position: "top-center",
                              icon: "success",
                              title: res.message,
                              showConfirmButton: false,
                              timer: 1500
                           });
                           getAll_ShoesType();
                        }
                     },
                     error: (xhr, status, error) => {
                        // Xử lý lỗi nếu cần thiết
                        Swal.fire({
                           position: "top-center",
                           icon: "error",
                           title: "Không Thể Xóa!",
                           text: "Loại giày đang tồn tại sản phẩm",
                           showConfirmButton: true,
                        });
                     }
                  })
               }
            });
         } else {
            Swal.fire("Bạn không có quyền sử dụng tính năng này");
         }
      }));
   });

   // Đổ sản phẩm phần brand
   function getAll_Size() {
      $.ajax({
         url: 'Controller/Admin/product.php?act=getAll_Size',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            var stt = 1
            // console.log(res);
            $('#table_size').empty();
            res.forEach(item => {
               var row = `
               <tr>
                  <td>${stt++}</td>
                  <td>${item.size}</td>
                  <td>
                     <button class="btn btn-outline-danger bi bi-trash3-fill size_id" data-size_id="${item.id}"></button>
                  </td>
               </tr>
               `;
               $('#table_size').append(row);
            })
         }
      })
   }
   getAll_Size();

   // Thêm phần size
   $(document).on('submit', '#form_Size', function (event) {
      event.preventDefault();
      size = $('#size').val();

      if (checkFeature('Thêm, xóa size', (result) => {
         if (result) {
            flag = false;
            // Kiểm tra trống
            if (size.length === 0) {
               flag = true;
               $('#size_error').text('Size không được để trống');
            } else {
               $('#size_error').text('');
               // Kiểm tra có phải số hay không
               if (isNaN(size)) {
                  flag = true;
                  $('#size_error').text('Size phải là số');
               } else {
                  $('#size_error').text('');
               }
            }

            if (flag == false) {
               $.ajax({
                  url: 'Controller/Admin/product.php?act=add_size',
                  method: 'POST',
                  data: { size: size },
                  dataType: 'json',
                  success: (res) => {
                     if (res.status == 200) {
                        Swal.fire({
                           position: "top-center",
                           icon: "success",
                           title: res.message,
                           showConfirmButton: false,
                           timer: 1500
                        });
                        $('#size').val('')
                        getAll_Size();
                     } else if (res.status == 403) {
                        $('#size_error').text(res.message);
                     }
                  }
               })
            }
         } else {
            Swal.fire("Bạn không có quyền sử dụng tính năng này");
         }
      }));
   })
   // Xóa phần size
   $(document).on('click', '.size_id', function () {
      var size_id = $(this).data('size_id');

      if (checkFeature('Thêm, xóa size', (result) => {
         if (result) {
            Swal.fire({
               title: "Bạn có chắc chắn?",
               text: "Bạn sẽ không thể khôi phục nó!",
               icon: "warning",
               showCancelButton: true,
               confirmButtonColor: "#3085d6",
               cancelButtonColor: "#d33",
               confirmButtonText: "Xóa!",
               cancelButtonText: "Hủy!"
            }).then((result) => {
               if (result.isConfirmed) {
                  $.ajax({
                     url: 'Controller/Admin/product.php?act=delete_size',
                     method: 'POST',
                     data: { size_id: size_id },
                     dataType: 'json',
                     success: (res) => {
                        if (res.status = 200) {
                           Swal.fire({
                              position: "top-center",
                              icon: "success",
                              title: res.message,
                              showConfirmButton: false,
                              timer: 1500
                           });
                           getAll_Size();
                        }
                     },
                     error: (xhr, status, error) => {
                        // Xử lý lỗi nếu cần thiết
                        Swal.fire({
                           position: "top-center",
                           icon: "error",
                           title: "Không Thể Xóa!",
                           text: "Size đang tồn tại sản phẩm",
                           showConfirmButton: true,
                        });
                     }
                  })
               }
            });
         } else {
            Swal.fire("Bạn không có quyền sử dụng tính năng này");
         }
      }));
   });

   // Ẩn hiện sản phẩm
   $(document).on('click', '#hidden_product', function () {
      let product_id = $(this).closest('tr').find('.product_id').data('product_id');
      let hidden = $(this).data('hidden');

      // console.log("Chuẩn bị vô");

      if (checkFeature('Ẩn hiện sản phẩm', (result) => {
         if (result) {
            // console.log("vô 1");return;
            if (hidden === 1) {
               $(this).text('Ẩn sản phẩm').data('hidden', 0);
            } else {
               $(this).text('Hiện sản phẩm').data('hidden', 1);
            }
            $.ajax({
               url: 'Controller/Admin/product.php?act=hidden_product',
               method: 'POST',
               data: { product_id, hidden },
               dataType: 'json',
               success: (res) => {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: res.message,
                     showConfirmButton: false,
                     timer: 1500
                  });
               }
            })
         } else {
            // console.log("vô 2");return;
            Swal.fire("Bạn không có quyền sử dụng chức năng này!");
         }
      }));
   })
});

// Load dữ liệu sản phẩm khi vào trang update
$(document).ready(function() {
   // Kiểm tra xem có phải trang update không
   if (window.location.href.includes('update_Product') && window.location.href.includes('id=')) {
      const urlParams = new URLSearchParams(window.location.search);
      const productId = urlParams.get('id');
      
      if (productId) {
         loadProductData(productId);
      }
   }
});

// Function để load dữ liệu sản phẩm
function loadProductData(productId) {
   $.ajax({
      url: `Controller/Admin/product.php?act=get_product_by_id&id=${productId}`,
      method: 'GET',
      dataType: 'json',
      success: function(response) {
         if (response.status === 200) {
            const product = response.data;
            
            // Điền dữ liệu vào form
            $('#id_product').val(product.id);
            $('#name_product').val(product.name);
            $('#shoes_type').val(product.shoes_type_id);
            $('#brand').val(product.brand_id);
            $('#descriptions_product').val(product.descriptions);
            
            // Hiển thị hình ảnh hiện tại
            if (product.img) {
               $('#current_image').attr('src', `View/assets/img/upload/${product.img}`);
               $('#current_image').removeClass('d-none');
               $('#no_image').addClass('d-none');
            } else {
               $('#current_image').addClass('d-none');
               $('#no_image').removeClass('d-none');
            }
            
            // Ẩn thông báo lỗi nếu có
            $('.text-danger').text('');
            
         } else {
            Swal.fire({
               icon: 'error',
               title: 'Lỗi',
               text: response.message || 'Không thể tải dữ liệu sản phẩm'
            });
         }
      },
      error: function() {
         Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: 'Không thể kết nối đến server'
         });
      }
   });
}

// Helper functions
function update_product_count(count = null) {
   if (count === null) {
      count = product.length;
   }
   $('#product_count').text(`${count} sản phẩm`);
}

function getShoesTypeName(id) {
   const shoesTypes = {
      1: 'Giày đá bóng',
      2: 'Giày chạy bộ',
      3: 'Giày tennis',
      4: 'Giày cỏ nhân tạo',
      5: 'Giày bóng rổ'
   };
   return shoesTypes[id] || 'Không xác định';
}

function getBrandName(id) {
   const brands = {
      1: 'Nike',
      2: 'Adidas',
      3: 'Puma',
      4: 'New Balance',
      5: 'Under Armour'
   };
   return brands[id] || 'Không xác định';
}

function toggleProductVisibility(productId, currentHidden) {
   const newHidden = currentHidden == 1 ? 0 : 1;
   const action = newHidden == 1 ? 'Ẩn' : 'Hiện';
   
   Swal.fire({
      title: `Xác nhận ${action} sản phẩm`,
      text: `Bạn có chắc chắn muốn ${action.toLowerCase()} sản phẩm này?`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: `Có, ${action}!`,
      cancelButtonText: 'Hủy'
   }).then((result) => {
      if (result.isConfirmed) {
         $.ajax({
            url: 'Controller/Admin/product.php?act=hidden_product',
            method: 'POST',
            data: { product_id: productId },
            dataType: 'json',
            success: function(response) {
               if (response.status === 'hidden' || response.status === 'show') {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: response.message,
                     showConfirmButton: false,
                     timer: 1500
                  });
                  // Reload products
                  get_all_product();
               }
            }
         });
      }
   });
}

function deleteProduct(productId) {
   Swal.fire({
      title: 'Xác nhận xóa sản phẩm',
      text: "Bạn có chắc chắn muốn xóa sản phẩm này? Hành động này không thể hoàn tác!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Có, xóa!',
      cancelButtonText: 'Hủy'
   }).then((result) => {
      if (result.isConfirmed) {
         $.ajax({
            url: 'Controller/Admin/product.php?act=delete_product',
            method: 'POST',
            data: { product_id: productId },
            dataType: 'json',
            success: function(response) {
               if (response.status === 200) {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: response.message,
                     showConfirmButton: false,
                     timer: 1500
                  });
                  // Reload products
                  get_all_product();
               } else {
                  Swal.fire({
                     icon: 'error',
                     title: 'Lỗi',
                     text: response.message || 'Không thể xóa sản phẩm'
                  });
               }
            }
         });
      }
   });
}
