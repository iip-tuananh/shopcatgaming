<style>

    .icon-remove-column {
        position: absolute;
        top: -3px;
        right: 2px;
        cursor: pointer;
    }

    .form-tag .tags {
        border-radius: 5px;
    }

    .form-tag .tags .tag-list li {
        /* background-color: #e4e4e4;
        background: none; */
        background: -webkit-linear-gradient(top, #e4e4e4 0, #e4e4e4 47%, #e4e4e4 100%)
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Thông tin chung</h4>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mã ngân hàng</label>
                            <span class="text-danger">(*)</span>
                            <input class="form-control" ng-model="form.code">
                            <span class="invalid-feedback d-block" role="alert">
                                <strong><% errors.code[0] %></strong>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Tên ngân hàng</label>
                            <span class="text-danger">(*)</span>
                            <div class="input-group">
                                <div class="input-group mb-0">
                                    <input class="form-control" type="text" ng-model="form.name">
                                </div>
                            </div>
                            <span class="invalid-feedback d-block" role="alert">
                                <strong><% errors.name[0] %></strong>
                            </span>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tên giao dịch quốc tế</label>
                            <input class="form-control" ng-model="form.international_business_name">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Địa chỉ giao dịch</label>
                            <div class="input-group">
                                <div class="input-group mb-0">
                                    <input class="form-control" type="text" ng-model="form.business_address">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-lg-12">

        <div class="card">
            <div class="card-header">
                <h4>Chi nhánh</h4>
            </div>
            <div class="card-block">
                <div class="button-tool pb-3 text-right">
                    <a href="javascript:void(0)" class="btn btn-info" data-target="#createModal"
                       data-toggle="modal">
                        <i class="fa fa-plus"></i> Thêm mới</a>
                </div>
                <table id="bank-branch-list">

                </table>
            </div>
        </div>
    </div>
</div>
