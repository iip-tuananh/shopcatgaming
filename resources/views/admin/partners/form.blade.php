<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group custom-group">
                    <label class="form-label required-label">Tiêu đề</label>
                    <input class="form-control " type="text" ng-model="form.name">
                    <span class="invalid-feedback d-block" role="alert">
                        <strong><% errors.name[0] %></strong>
                    </span>
                </div>
            </div>

{{--            <div class="col-md-12 col-sm-12 col-xs-12">--}}
{{--                <div class="form-group custom-group">--}}
{{--                    <label class="form-label required-label">Số điện thoại liên hệ</label>--}}
{{--                    <input class="form-control" type="text" ng-model="form.phone_number">--}}
{{--                    <span class="invalid-feedback d-block" role="alert">--}}
{{--                        <strong><% errors.phone_number[0] %></strong>--}}
{{--                    </span>--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="col-md-12 col-sm-12 col-xs-12">
                <label class="form-label">Icon ảnh</label>
                <div class="main-img-preview">
                    <p class="help-block-img">* Ảnh định dạng: jpg, png không quá 3MB.</p>
                    <img class="thumbnail img-preview" ng-src="<% form.image.path %>">
                </div>
                <div class="input-group" style="width: 100%; text-align: center">
                    <div class="input-group-btn" style="margin: 0 auto">
                        <div class="fileUpload fake-shadow cursor-pointer">
                            <label class="mb-0" for="<% form.image.element_id %>">
                                <i class="glyphicon glyphicon-upload"></i> Chọn ảnh
                            </label>
                            <input class="d-none" id="<% form.image.element_id %>" type="file" class="attachment_upload" accept=".jpg,.jpeg,.png,.svg">
                        </div>
                    </div>
                </div>
                <span class="invalid-feedback d-block" role="alert">

            </span>
            </div>

        </div>
    </div>
</div>
