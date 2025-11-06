<style>
    .bank-card{background:#fff;border:1px solid #e9ecef;border-radius:10px;padding:16px}
    .bank-card__header{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:12px}
    .bank-card__title{font-weight:600}
    .bank-card__grid{display:grid;grid-template-columns:1fr;gap:12px}
    @media (min-width:768px){.bank-card__grid{grid-template-columns:1fr 1fr}}
    .bank-card .form-label{margin-bottom:6px;font-weight:500}

</style>
<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-8 col-xs-12">
				<div class="form-group custom-group">
					<label class="form-label required-label">Tiêu đề website</label>
					<input class="form-control" ng-model="form.web_title" type="text">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.web_title[0] %></strong>
					</span>
				</div>
                <div class="form-group custom-group">
                    <label class="form-label">Tên công ty viết gọn</label>
                    <input class="form-control" ng-model="form.short_name_company" type="text">
                    <span class="invalid-feedback d-block" role="alert">
						<strong><% errors.web_title[0] %></strong>
					</span>
                </div>
				<div class="form-group custom-group">
					<label class="form-label required-label">Số hotline</label>
					<input class="form-control" ng-model="form.hotline" type="text">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.hotline[0] %></strong>
					</span>
				</div>
				<div class="form-group custom-group">
					<label class="form-label required-label">Số Zalo</label>
					<input class="form-control" ng-model="form.zalo" type="text">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.zalo[0] %></strong>
					</span>
				</div>
                <div class="form-group custom-group">
                    <label class="form-label">Địa chỉ công ty</label>
                    <input class="form-control" ng-model="form.address_company" type="text">
                </div>
                <div class="form-group custom-group">
                    <label class="form-label">Mã số thuế</label>
                    <input class="form-control" ng-model="form.tax_code" type="text">
                </div>
				<div class="form-group custom-group">
					<label class="form-label required-label">Email</label>
					<input class="form-control" ng-model="form.email" type="text">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.email[0] %></strong>
					</span>
				</div>
                <div class="form-group custom-group">
                    <label class="form-label">Link Messenger Facebook</label>
                    <input class="form-control" ng-model="form.facebook_mess" type="text">
                    <span class="invalid-feedback d-block" role="alert">
						<strong><% errors.facebook_mess[0] %></strong>
					</span>
                </div>
				<div class="form-group custom-group">
					<label class="form-label required-label">Fanpage Facebook</label>
					<input class="form-control" ng-model="form.facebook" type="text">
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.facebook[0] %></strong>
					</span>
				</div>
                <div class="form-group custom-group">
                    <label class="form-label">Tiktok</label>
                    <input class="form-control" ng-model="form.twitter" type="text">
                </div>
                <div class="form-group custom-group">
                    <label class="form-label">Instagram</label>
                    <input class="form-control" ng-model="form.instagram" type="text">
                </div>
                <div class="form-group custom-group">
                    <label class="form-label">Youtube</label>
                    <input class="form-control" ng-model="form.youtube" type="text">
                </div>
                <div class="form-group custom-group">
                    <label class="form-label">Link nhúng iframe (Map google)</label>
                    <input class="form-control" ng-model="form.location" type="text">
                    <span class="invalid-feedback d-block" role="alert">
						<strong><% errors.location[0] %></strong>
					</span>
                </div>

                <div class="form-group custom-group">
                    <label class="form-label">Giới thiệu ngắn</label>
                    <textarea id="my-textarea" class="form-control"  ng-model="form.introduction" rows="5"></textarea>
                    <span class="invalid-feedback d-block" role="alert">
						<strong><% errors.introduction[0] %></strong>
					</span>
                </div>


				<div class="form-group custom-group">
					<label class="form-label">Giới thiệu (Footer)</label>
					<textarea id="my-textarea" class="form-control" ck-editor ng-model="form.hdmh" rows="3"></textarea>
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.hdmh[0] %></strong>
					</span>
				</div>

                <div class="form-group custom-group">
                    <label class="form-label">Bài viết giới thiệu</label>
                    <textarea id="my-textarea" class="form-control" ck-editor ng-model="form.web_des" rows="3"></textarea>
                    <span class="invalid-feedback d-block" role="alert">
						<strong><% errors.web_des[0] %></strong>
					</span>
                </div>

                <div class="bank-card">
                    <div class="bank-card__header">
                        <span class="bank-card__title">Thông tin ngân hàng</span>
                        <small class="text-muted">Dùng để nhận chuyển khoản</small>
                    </div>

                    <div class="bank-card__grid">
                        <div class="form-group custom-group">
                            <label class="form-label">Ngân hàng</label>
                            <input class="form-control" ng-model="form.nganhang" type="text" placeholder="VD: Vietcombank">
                        </div>

                        <div class="form-group custom-group">
                            <label class="form-label">Chủ tài khoản</label>
                            <input class="form-control" ng-model="form.chutaikhoan" type="text" placeholder="VD: Nguyễn Văn A">
                        </div>

                        <div class="form-group custom-group">
                            <label class="form-label">Số tài khoản</label>
                            <input class="form-control" ng-model="form.sotaikhoan" type="text"
                                   inputmode="numeric" pattern="[0-9]*" placeholder="VD: 0123456789">
                        </div>

                        <div class="form-group custom-group">
                            <label class="form-label">Chi nhánh</label>
                            <input class="form-control" ng-model="form.chinhanh" type="text" placeholder="VD: CN Hà Nội">
                        </div>
                    </div>
                </div>

                <div class="form-group custom-group">
                    <label class="form-label">Ghi chú đặt cọc</label>
                    <textarea id="my-textarea" class="form-control"  ng-model="form.notedatcoc" rows="5"></textarea>
                    <span class="invalid-feedback d-block" role="alert">
						<strong><% errors.notedatcoc[0] %></strong>
					</span>
                </div>

			</div>
			<div class="col-md-4 col-xs-12">
				<div class="form-group text-center mb-4">
					<label class="form-label required-label">Logo</label>
					<div class="main-img-preview">
						<p class="help-block-img">* Ảnh định dạng: jpg, png không quá 1MB.</p>
						<img class="thumbnail img-preview" ng-src="<% form.image.path %>">
					</div>
					<div class="input-group" style="width: 100%; text-align: center">
						<div class="input-group-btn" style="margin: 0 auto">
							<div class="fileUpload fake-shadow cursor-pointer">
								<label class="mb-0" for="<% form.image.element_id %>">
									<i class="glyphicon glyphicon-upload"></i> Chọn ảnh
								</label>
								<input class="d-none" id="<% form.image.element_id %>" type="file" class="attachment_upload" accept=".jpg,.jpeg,.png">
							</div>
						</div>
					</div>
					<span class="invalid-feedback d-block" role="alert">
						<strong><% errors.image[0] %></strong>
					</span>
				</div>

                <div class="form-group text-center mb-4">
                    <label class="form-label required-label">Logo(Footer)</label>
                    <div class="main-img-preview">
                        <p class="help-block-img">* Ảnh định dạng: jpg, png không quá 1MB.</p>
                        <img class="thumbnail img-preview" ng-src="<% form.image_back.path %>">
                    </div>
                    <div class="input-group" style="width: 100%; text-align: center">
                        <div class="input-group-btn" style="margin: 0 auto">
                            <div class="fileUpload fake-shadow cursor-pointer">
                                <label class="mb-0" for="<% form.image_back.element_id %>">
                                    <i class="glyphicon glyphicon-upload"></i> Chọn ảnh
                                </label>
                                <input class="d-none" id="<% form.image_back.element_id %>" type="file" class="attachment_upload" accept=".jpg,.jpeg,.png">
                            </div>
                        </div>
                    </div>
                    <span class="invalid-feedback d-block" role="alert">
						<strong><% errors.image_back[0] %></strong>
					</span>
                </div>

                <div style=""></div>

                <div class="form-group text-center mb-4">
                    <label class="form-label required-label">Favicon</label>
                    <div class="main-img-preview">
                        <p class="help-block-img">* Ảnh định dạng: jpg, png không quá 1MB, kích thước 16x16 </p>
                        <img class="thumbnail img-preview" ng-src="<% form.favicon.path %>">
                    </div>
                    <div class="input-group" style="width: 100%; text-align: center">
                        <div class="input-group-btn" style="margin: 0 auto">
                            <div class="fileUpload fake-shadow cursor-pointer">
                                <label class="mb-0" for="<% form.favicon.element_id %>">
                                    <i class="glyphicon glyphicon-upload"></i> Chọn ảnh
                                </label>
                                <input class="d-none" id="<% form.favicon.element_id %>" type="file" class="attachment_upload" accept=".jpg,.jpeg,.png">
                            </div>
                        </div>
                    </div>
                    <span class="invalid-feedback d-block" role="alert">
						<strong><% errors.favicon[0] %></strong>
					</span>
                </div>

                <div class="form-group text-center mb-4">
                    <label class="form-label required-label">QR thanh toán</label>
                    <div class="main-img-preview">
                        <p class="help-block-img">* Ảnh định dạng: jpg, png </p>
                        <img class="thumbnail img-preview" ng-src="<% form.qr.path %>">
                    </div>
                    <div class="input-group" style="width: 100%; text-align: center">
                        <div class="input-group-btn" style="margin: 0 auto">
                            <div class="fileUpload fake-shadow cursor-pointer">
                                <label class="mb-0" for="<% form.qr.element_id %>">
                                    <i class="glyphicon glyphicon-upload"></i> Chọn ảnh
                                </label>
                                <input class="d-none" id="<% form.qr.element_id %>" type="file" class="attachment_upload" accept=".jpg,.jpeg,.png">
                            </div>
                        </div>
                    </div>
                    <span class="invalid-feedback d-block" role="alert">
						<strong><% errors.qr[0] %></strong>
					</span>
                </div>


			</div>
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
</div>

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
