<style>
    .gallery-item {
        padding: 5px;
        padding-bottom: 0;
        border-radius: 2px;
        border: 1px solid #bbb;
        min-height: 100px;
        height: 100%;
        position: relative;
    }

    .gallery-item .remove {
        position: absolute;
        top: 5px;
        right: 5px;
    }

    .gallery-item .drag-handle {
        position: absolute;
        top: 5px;
        left: 5px;
        cursor: move;
    }

    .gallery-item:hover {
        background-color: #eee;
    }

    .gallery-item .image-chooser img {
        max-height: 150px;
    }

    .gallery-item .image-chooser:hover {
        border: 1px dashed green;
    }
</style>
<style>
    /* ===== Base ===== */
    .variant-group { margin-top: 8px; }

    .variant-head,
    .variant-row{
        display: grid;
        grid-template-columns:
    2.2fr                     /* Tên phân loại (rộng) */
    minmax(120px,1fr)         /* Giá gốc */
    minmax(120px,1fr)         /* Giá bán */
    67px;                    /* Thao tác (cố định để đặt 2 nút) */
        gap: 14px;
        align-items: center;
    }

    .variant-head{
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .02em;
        color: #6b7280;
        padding: 8px 12px;
        border: 1px dashed #e5e7eb;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .variant-row{
        padding: 12px;
        border: 1px solid #eef1f5;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 2px 6px rgba(16,24,40,.04);
        margin-bottom: 10px;
    }
    .variant-row:hover{ box-shadow: 0 4px 14px rgba(16,24,40,.08); }

    .variant-footer{ margin-top: 8px; }

    .cell{ display:flex; flex-direction:column; gap:6px; }
    .cell.-full{ grid-column: 1 / -1; }

    .form-control{ height:40px; }
    .ta-right{ text-align:right; }
    .ta-center{ text-align:center; }
    .no-wrap{ white-space:nowrap; }

    /* Suffix “₫” */
    .input-affix{ position:relative; }
    .input-affix[data-suffix]::after{
        content: attr(data-suffix);
        position:absolute; right:10px; top:50%; transform:translateY(-50%);
        font-size:13px; color:#6b7280; pointer-events:none;
    }
    .input-affix > .form-control{ padding-right:28px; }

    /* Buttons (fallback nếu không dùng BS5) */
    .btn{ display:inline-flex; align-items:center; gap:6px; height:36px; padding:0 12px; border-radius:8px; border:1px solid transparent; cursor:pointer; }
    .btn-light{ background:#f3f4f6; color:#111827; }
    .btn-light:hover{ background:#e5e7eb; }
    .btn-success{ background:#10b981; color:#fff; }
    .btn-success:hover{ background:#059669; }
    .btn-danger{ background:#ef4444; color:#fff; }
    .btn-danger:hover{ background:#dc2626; }

    /* Cột thao tác: xếp dọc 2 nút trên desktop */
    .variant-row .cell.actions{
        display:flex;
        flex-direction:column;
        gap:8px;
    }
    .variant-row .cell.actions .btn{
        width:100%;
        justify-content:center;
        height:36px;
        border-radius:10px;
    }

    /* ===== Responsive ===== */
    @media (max-width: 992px){
        /* Tablet: Tên tràn full hàng, giá gốc & giá bán nằm hàng dưới, thao tác full hàng */
        .variant-head{ display:none; }
        .variant-row{
            grid-template-columns: 1fr 1fr;
            grid-auto-rows: auto;
        }
        .variant-row > .cell:nth-child(1){ grid-column: 1 / -1; } /* Tên */
        .variant-row .cell.actions{
            grid-column: 1 / -1;
            flex-direction: row;
        }
        .variant-row .cell.actions .btn{ flex:1; }
    }

    @media (max-width: 576px){
        /* Mobile: mỗi dòng 1 cột cho dễ bấm */
        .variant-row{ grid-template-columns: 1fr; }
        .no-wrap{ white-space: normal; }
    }

</style>
<div class="row">
    <div class="col-sm-8">
        <div class="form-group custom-group mb-4">
            <label class="form-label required-label">Danh mục sản phẩm</label>
            <ui-select remove-selected="true" ng-model="form.cate_id" theme="select2">
                <ui-select-match placeholder="Chọn danh mục">
                    <% $select.selected.name %>
                    <small class="text-muted ms-1" ng-if="$select.selected._label_suffix">
                        <% $select.selected._label_suffix %>
                    </small>
                </ui-select-match>

                <!-- Hiển thị tất cả, nhưng khoá các cha có con -->
                <ui-select-choices
                    repeat="t.id as t in (form.all_categories_marked | filter:$select.search) track by t.id"
                    ui-disable-choice="t._disabled">
                    <div class="d-flex align-items-center">
                        <span ng-bind="t.name"></span>
                        <small class="text-muted ms-2" ng-if="t._label_suffix"><% t._label_suffix %></small>
                    </div>
                </ui-select-choices>
            </ui-select>

            <span class="invalid-feedback d-block" role="alert">
                <strong>
                    <% errors.cate_id[0] %>
                </strong>
            </span>
        </div>

        <div class="form-group custom-group mb-4">
            <label class="form-label required-label">Tên hàng hóa</label>
            <input class="form-control " type="text" ng-model="form.name">
            <span class="invalid-feedback d-block" role="alert">
                <strong>
                    <% errors.name[0] %>
                </strong>
            </span>
        </div>

        <div class="form-group custom-group mb-4">
            <label class="form-label">Mô tả ngắn</label>
            <textarea class="form-control ck-editor" ck-editor rows="5" ng-model="form.intro"></textarea>
            <span class="invalid-feedback d-block" role="alert">
                <strong>
                    <% errors.intro[0] %>
                </strong>
            </span>
        </div>

        <div class="form-group custom-group mb-4">
            <label class="form-label">Chi tiết sản phẩm</label>
            <textarea class="form-control ck-editor" ck-editor rows="5" ng-model="form.body"></textarea>
            <span class="invalid-feedback d-block" role="alert">
                <strong>
                    <% errors.body[0] %>
                </strong>
            </span>
        </div>

        <div class="form-group custom-group mb-4">
            <label class="form-label">Hướng dẫn cài đặt</label>
            <textarea class="form-control ck-editor" ck-editor rows="5" ng-model="form.hdcd"></textarea>
            <span class="invalid-feedback d-block" role="alert">
                <strong>
                    <% errors.hdcd[0] %>
                </strong>
            </span>
        </div>


    </div>
    <div class="col-sm-4">
        <div class="form-group custom-group mb-4">
            <label class="form-label">Giá trước giảm</label>
            <input class="form-control " type="text" ng-model="form.base_price">
            <span class="invalid-feedback d-block" role="alert">
                <strong>
                    <% errors.base_price[0] %>
                </strong>
            </span>
        </div>
        <div class="form-group custom-group mb-4">
            <label class="form-label">Giá bán</label>
            <input class="form-control " type="text" ng-model="form.price">
            <span class="invalid-feedback d-block" role="alert">
                <strong>
                    <% errors.price[0] %>
                </strong>
            </span>
        </div>

        <div class="form-group custom-group mb-4">
            <label class="form-label required-label">Trạng thái</label>
            <select id="my-select" class="form-control custom-select" ng-model="form.status">
                <option value="">Chọn trạng thái</option>
                <option value="0">Lưu nháp</option>
                <option value="1">Xuất bản</option>
            </select>
            <span class="invalid-feedback d-block" role="alert">
                <strong>
                    <% errors.status[0] %>
                </strong>
            </span>
        </div>



{{--        <div class="form-group">--}}
{{--            <label class="form-label">Phân loại sản phẩm</label>--}}

{{--            <div ng-repeat="(idx, item) in form.types" class="result-item">--}}
{{--                <input type="text"--}}
{{--                       class="form-control form-control--small"--}}
{{--                       placeholder="Nhập tên"--}}
{{--                       ng-model="item.title" />--}}

{{--                <input type="text"--}}
{{--                       class="form-control"--}}
{{--                       placeholder="Nhập giá trước giảm"--}}
{{--                       ng-model="item.base_price" />--}}

{{--                <input type="text"--}}
{{--                       class="form-control"--}}
{{--                       placeholder="Nhập giá bán"--}}
{{--                       ng-model="item.price" />--}}

{{--                <button type="button"--}}
{{--                        class="btn btn-success"--}}
{{--                        ng-if="idx === form.types.length - 1"--}}
{{--                        ng-click="form.addType()">--}}
{{--                    <i class="fa fa-plus"></i>--}}
{{--                </button>--}}

{{--                <button type="button"--}}
{{--                        class="btn btn-danger"--}}
{{--                        ng-if="form.types.length > 1"--}}
{{--                        ng-click="form.removeType(idx)">--}}
{{--                    <i class="fa fa-times"></i>--}}
{{--                </button>--}}
{{--            </div>--}}

{{--            <div class="invalid-feedback d-block"><% errors.types %></div>--}}
{{--        </div>--}}

        <!-- ====== Product Types (Variants) ====== -->
        <div class="form-group variant-group">
            <label class="form-label">Phân loại sản phẩm</label>

            <!-- Header row -->
            <div class="variant-head" aria-hidden="true">
                <div>Tên phân loại</div>
                <div>Giá gốc</div>
                <div>Giá bán</div>
                <div class="ta-right">Thao tác</div>
            </div>

            <!-- Rows -->
            <div class="variant-row"
                 ng-repeat="(idx, item) in form.types track by idx">

                <!-- Title -->
                <div class="cell">
                    <input type="text"
                           class="form-control"
                           ng-model="item.title" />
                </div>

                <!-- Base price -->
                <div class="cell">
                    <div class="input-affix" data-suffix="₫">
                        <input type="text"
                               class="form-control ta-right"
                               ng-model="item.base_price"
                               />
                    </div>

                </div>

                <!-- Price -->
                <div class="cell">
                    <div class="input-affix" data-suffix="₫">
                        <input type="text"
                               class="form-control ta-right"
                               ng-model="item.price"
                              />
                    </div>
                </div>


                <!-- Actions -->
                <div class="cell ta-right no-wrap">
                    <button type="button"
                            class="btn btn-light"
                            title="Thêm dòng"
                            ng-if="idx === form.types.length - 1"
                            ng-click="form.addType()">
                        <i class="fa fa-plus"></i>
                    </button>
                    <button type="button"
                            class="btn btn-danger"
                            title="Xóa dòng"
                            ng-if="form.types.length > 1"
                            ng-click="form.removeType(idx)">
                        <i class="fa fa-times"></i>
                    </button>
                </div>

                <!-- Optional row note / error -->
                <div class="cell -full" ng-if="item.error">
                    <div class="invalid-feedback d-block"><% item.error %></div>
                </div>
            </div>

            <!-- Global add button (tiện cho mobile) -->
            <div class="variant-footer">
                <button type="button" class="btn btn-success" ng-click="form.addType()">
                    <i class="fa fa-plus"></i> Thêm phân loại
                </button>
            </div>

            <div class="invalid-feedback d-block" ng-if="errors && errors.types"><% errors.types %></div>
        </div>


        <div class="form-group text-center">
            <div class="main-img-preview">
                <label for="">Ảnh sản phẩm</label>
                <p class="help-block-img">* Ảnh định dạng: jpg, png</p>
                <img class="thumbnail img-preview" ng-src="<% form.image.path %>">
            </div>
            <div class="input-group" style="width: 100%; text-align: center">
                <div class="input-group-btn" style="margin: 0 auto">
                    <div class="fileUpload fake-shadow cursor-pointer">
                        <label class="mb-0" for="<% form.image.element_id %>">
                            <i class="glyphicon glyphicon-upload"></i> Chọn ảnh
                        </label>
                        <input class="d-none" id="<% form.image.element_id %>" type="file" class="attachment_upload" accept=".jpg,.jpeg,.png,.webp">
                    </div>
                </div>
            </div>
            <span class="invalid-feedback d-block" role="alert">
                <strong>
                    <% errors.image[0] %>
                </strong>
            </span>
        </div>

        <hr>
        <div class="form-group text-center">
            <label for="">Thư viện ảnh sản phẩm</label>
            <div class="row gallery-area border">
                <div class="col-md-4 p-2" ng-repeat="g in form.galleries">
                    <div class="gallery-item">
                        <button class="btn btn-sm btn-danger remove" ng-click="form.removeGallery($index)">
                            <i class="fa fa-times mr-0"></i>
                        </button>
                        <div class="form-group">
                            <div class="img-chooser" title="Chọn ảnh">
                                <label for="<% g.image.element_id %>">
                                    <img ng-src="<% g.image.path %>">
                                    <input class="d-none" type="file" accept=".jpg,.png,.jpeg,.webp" id="<% g.image.element_id %>">
                                </label>
                            </div>
                            <span class="invalid-feedback d-block" role="alert" ng-if="!errors['galleries.' + $index + '.image_obj']">
                                <strong>
                                    <% errors['galleries.' + $index + '.image' ][0] %>
                                </strong>
                            </span>
                            <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors['galleries.' + $index + '.image_obj']">
                                <strong>
                                    <% errors['galleries.' + $index + '.image_obj' ][0] %>
                                </strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-2">
                    <label class="gallery-item d-flex align-items-center justify-content-center cursor-pointer" for="gallery-chooser">
                        <i class="fa fa-plus fa-2x text-secondary"></i>
                    </label>
                    <input class="d-none" type="file" accept=".jpg,.png,.jpeg" id="gallery-chooser" multiple>
                </div>
            </div>
            <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors['galleries']">
                <strong>
                    <% errors.galleries[0] %>
                </strong>
            </span>
        </div>
    </div>
</div>
<hr>
<div class="text-right">
    <button type="submit" class="btn btn-success btn-cons" ng-click="submit()" ng-disabled="loading.submit">
        <i ng-if="!loading.submit" class="fa fa-save"></i>
        <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
        Lưu
    </button>
    <a href="{{ route('Category.index') }}" class="btn btn-danger btn-cons">
        <i class="fa fa-remove"></i> Hủy
    </a>
</div>
