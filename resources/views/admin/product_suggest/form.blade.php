<style>
    /* CHUNG CHO CÁC CARD */
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        transition: box-shadow 0.2s ease;
    }
    .card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .card-header {
        background: #f8f9fa;
        border-bottom: none;
        padding: 0.75rem 1rem;
    }
    .card-header h5 {
        margin: 0;
        font-weight: 600;
    }

    /* NÚT CHỌN FILE */
    .btn-outline-secondary {
        border-radius: 20px;
        padding: 0.35rem 0.8rem;
        font-size: 0.9rem;
    }
    .btn-outline-secondary:hover {
        background: #e2e6ea;
    }

    /* GALLERY AREA */
    .gallery-area .border {
        width: 80px;
        height: 80px;
        overflow: hidden;
    }
    .gallery-area img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* NÚT LƯU/HỦY CỐ ĐỊNH */
    .form-actions {
        position: sticky;
        bottom: 0;
        background: #fff;
    }

    .required-label::after {
        content: ' *';
        color: #e74c3c;        /* đỏ bắt mắt */
        margin-left: 2px;
        font-weight: bold;
    }

    /* Đặt rộng 100% cho ui-select */
    .ui-select-container {
        width: 100%;
    }
    /* Tùy chỉnh ô đang đóng gói các tag đã chọn */
    .ui-select-multiple .ui-select-match-item {
        background-color: #f1f3f5;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 0.25rem 0.5rem;
        margin-right: 0.25rem;
    }
    /* Tùy chỉnh khung dropdown khi chưa chọn gì */
    .ui-select-toggle {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        min-height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
    }
    /* Khi focus thì viền xanh nhẹ */
    .ui-select-toggle:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        border-color: #80bdff;
    }
    /* Hoá “dấu x” gỡ tag nhìn nhẹ nhàng hơn */
    .ui-select-multiple .ui-select-match-close {
        color: #6c757d;
        margin-left: 0.25rem;
    }


    /* Container flex cho các thumbnail */
    .suggestion-list {
        gap: 1rem;               /* khoảng cách giữa các thumb */
    }

    /* Mỗi thumb */
    .item-thumb {
        width: 120px;            /* độ rộng cố định */
        flex: 0 0 auto;
    }

    /* Ảnh */
    .thumb-img {
        display: block;
        width: 100%;
        height: 100px;           /* cao cố định hoặc auto nếu muốn tỷ lệ */
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #e0e0e0;
    }

    /* Nút xóa góc trên phải */
    .remove-btn {
        position: absolute;
        top: 4px;
        right: 4px;
        background: rgba(0,0,0,0.6);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        line-height: 18px;
        font-size: 14px;
        cursor: pointer;
    }

    /* Tên sản phẩm bên dưới */
    .thumb-name {
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: #333;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-rounded {
        border-radius: 0.5rem;   /* bo góc to hơn */
        padding: 0.25rem 0.75rem;
    }

    /* Giới hạn độ rộng input */
    .base-product-group .input-group {
        max-width: 500px;      /* hoặc bất kỳ width bạn muốn */
    }
</style>
<form name="productForm" >


    <div class="row base-product-group mb-4 align-items-center">
        <label class="col-sm-4 col-form-label required-label">Sản phẩm gốc</label>
        <div class="col-sm-8 col-md-6">
            <div class="input-group input-group-sm">
      <span class="input-group-text">
        <i class="fa fa-box"></i>
      </span>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Chưa chọn sản phẩm gốc"
                    ng-model="product.name"
                    disabled
                >
                <button
                    class="btn btn-outline-secondary"
                    type="button"
                    ng-click="openProductModal('base_product')"
                    disabled
                >
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </div>
    </div>


    <div class="row gx-3 gy-4">

        <div class="col-2 col-md-4">
        </div>

        <div class="col-8 col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Gợi ý mua kèm</h5>

                    <button class="btn btn-outline-secondary btn-sm"
                            ng-click="openProductModal('upsell')">
                        <i class="fa fa-plus"></i> Thêm
                    </button>

                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap suggestion-list">
                        <div class="item-thumb position-relative text-center"
                             ng-repeat="item in form.suggestions.upsell">

                            <!-- Ảnh -->
                            <img ng-src="<%item.image%>"
                                 alt="<%item.name%>"
                                 class="thumb-img">

                            <!-- Nút xóa -->
                            <button type="button"
                                    class="remove-btn"
                                    ng-click="removeSuggestion('upsell', item)">
                                &times;
                            </button>

                            <!-- Tên bên dưới -->
                            <div class="thumb-name"><%item.name%></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-2 col-md-4">
        </div>

        <!-- Upsell -->


    </div>

    <!-- Nút Lưu / Hủy cố định đáy -->
    <div class="form-actions text-end py-3 border-top bg-light text-right">
        <button type="button" class="btn btn-success" ng-disabled="loading.submit" ng-click="saveSuggest()">
            <i ng-if="!loading.submit" class="fa fa-save"></i>
            <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
            Lưu
        </button>


    </div>

</form>
