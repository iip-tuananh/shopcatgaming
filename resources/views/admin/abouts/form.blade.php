<style>
    /* Card wrapper cho mỗi section để nổi khối */
    .custom-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .custom-card .form-label {
        font-weight: 600;
    }

    .custom-card .required-label::after {
        content: "*";
        color: #e74c3c;
        margin-left: 4px;
    }

    /* Kết quả đạt được */
    .result-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 6px;
    }
    .result-item input {
        flex: 1;
        margin-right: 0.5rem;
    }
    .result-item .btn {
        min-width: 36px;
    }

    /* Thumbnail preview */
    .thumb-wrapper {
        text-align: center;
    }
    .thumb-wrapper img {
        max-width: 100%;
        border-radius: 6px;
        margin-bottom: 0.5rem;
        border: 1px solid #ccc;
    }
    .thumb-wrapper .btn-upload {
        width: 100%;
    }


    .result-item input {
        flex: 1;
        margin-right: 0.5rem; /* khoảng cách giữa các input và giữa input với button */
    }

    .result-item input:last-of-type {
        margin-right: 0.75rem; /* nới rộng ít hơn trước khi tới button */
    }

    .result-item .btn {
        min-width: 36px;
        margin-left: 0;      /* đảm bảo nút sát vào khung */
    }

    .result-item .btn + .btn {
        margin-left: 0.25rem; /* khoảng cách giữa 2 nút */
    }

    .form-control--small {
        max-width: 150px;
    }
</style>

<div class="row">
    <div class="col-lg-8">
        <div class="custom-card">
            <h5 class="mb-4">Thông tin chung</h5>

            <div class="form-group mb-4">
                <label class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" ng-model="form.service_title">
                <div class="invalid-feedback d-block"><% errors.service_title[0] %></div>
            </div>


            <div class="form-group mb-4">
                <label class="form-label">Intro</label>
                <textarea  rows="10" class="form-control" ng-model="form.intro"></textarea>
                <div class="invalid-feedback d-block"><% errors.intro[0] %></div>
            </div>

            <div class="form-group mb-4">
                <label class="form-label">Link liên kết</label>
                <input type="text" class="form-control" ng-model="form.title">
                <div class="invalid-feedback d-block"><% errors.title[0] %></div>
            </div>

        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header text-center ">
                <h5>Video</h5>
            </div>
            <div class="card-body">
                <div class="form-group text-center">
                    <div class="main-video-preview">
                        <label class="required-label">Video (MP4)</label>
                        <p class="help-block-img">* Chỉ chấp nhận .mp4 (tối đa 10MB)</p>

                        <video class="video-preview"
                            ng-if="form.video.trusted"
                            ng-src="<% form.video.trusted %>"
                            controls preload="metadata"
                            style="max-width:100%;height:auto;border:1px dashed #ddd;border-radius:8px">
                        </video>
                        <div ng-if="!form.video.trusted" class="text-muted">Chưa chọn video</div>
                    </div>

                    <div class="input-group" style="width: 100%; text-align: center">
                        <div class="input-group-btn" style="margin: 0 auto">
                            <div class="fileUpload fake-shadow cursor-pointer">
                                <label class="mb-0" for="<% form.video.element_id %>">
                                    <i class="glyphicon glyphicon-film"></i> Chọn video MP4
                                </label>
                                <input class="d-none"
                                       id="<% form.video.element_id %>"
                                       type="file"
                                       accept="video/mp4"
                                       onchange="angular.element(this).scope().onVideoChange(this.files && this.files[0])">
                            </div>
                        </div>
                    </div>

                    <button type="button"
                            class="btn btn-sm btn-outline-danger mt-2"
                            ng-if="form.video.path"
                            ng-click="removeVideo()">
                        Xóa video
                    </button>

                    <span class="invalid-feedback d-block" role="alert">
    <strong><% errors.video && errors.video[0] %></strong>
  </span>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="text-right mt-3">
    <button type="submit" class="btn btn-success px-4" ng-click="submit(0)" ng-disabled="loading.submit">
        <i ng-if="!loading.submit" class="fa fa-save"></i>
        <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
        Lưu
    </button>
</div>
