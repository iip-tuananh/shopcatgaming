<style>
    #searchProduct .modal-dialog {
        /* nếu bạn muốn rộng hơn modal-xl, tăng max-width */
        max-width: 60vw;
        width: auto;
    }
    #searchProduct .modal-content {
        height: 80vh;              /* cho modal cao 80% viewport */
        display: flex;
        flex-direction: column;
    }
    #searchProduct .modal-body {
        overflow-y: auto;          /* scroll khi nội dung vượt */
        flex: 1 1 auto;
        padding: 1rem;
    }
    #searchProduct .modal-header,
    #searchProduct .modal-footer {
        flex: 0 0 auto;
    }

    #search-product-table_wrapper .dataTables_length {
        float: right !important;
    }
</style>



<div class="modal fade products" id="searchProduct" tabindex="-1" role="dialog" aria-labelledby="searchProductLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="myModalLabel" class="semi-bold">Tìm kiếm sản phẩm</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-2">
                        <input class="form-control" placeholder="Tên sản phẩm" type="text"
                               ng-model="searchProduct.keyword" ng-keyup="$event.keyCode === 13 && submitSearchProduct()">
                    </div>

                    <div class="col-md-2">
                        <select class="select2l form-control"
                                ng-model="searchProduct.cate_id">
                            <option value="">Danh mục</option>
                            <option ng-repeat="category in categories" ng-value="category.id">
                                <% category.name %>
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-info h-100" ng-click="submitSearchProduct()">
                            <i class="fa fa-search"></i>
                        </button>
                        <button type="button" class="btn btn-success h-100" ng-click="resetSearchProduct()">
                            <i class="fas fa-sync"></i>
                        </button>
                    </div>
                </div>
                <table class="table table-bordered no-more-tables table-head-border hover" id="search-product-table">
                    <thead>
                    <tr>
                        <th class="text-center v-align-middle">STT</th>
                        <th class="text-center v-align-middle">Sản phẩm</th>
                        <th class="text-center v-align-middle">Danh mục</th>
                        <th class="text-center v-align-middle">Giá tiền</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fa fa-remove"></i> Đóng
                </button>
            </div>
        </div>
    </div>
</div>
