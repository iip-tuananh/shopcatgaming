@extends('layouts.main')

@section('css')

@endsection

@section('title')
    Cấu hình gợi ý cho sản phẩm
@endsection

@section('page_title')
    Cấu hình gợi ý cho sản phẩm
@endsection

@section('content')
    <div ng-controller="EditProduct" ng-cloak>
        @include('admin.product_suggest.form')
        @include('partial.modal.searchProductModal')

    </div>
@endsection


@section('script')
    <script>
        app.controller('EditProduct', function ($scope, $http) {
            var searchProductTable;
            $scope.categories =  @json(App\Model\Admin\Category::getForSelect());
            $scope.product = @json($product);
            $scope.form = {};
            $scope.form.suggestions = @json($suggestions);

            // Biến tạm ghi nhóm hiện tại khi mở modal
            $scope.currentSuggestionType = null;
            // 2) Hàm mở modal, truyền vào type
            $scope.openProductModal = function(type) {
                $scope.currentSuggestionType = type;
                $('#searchProduct').modal('show');
                $scope.submitSearchProduct();
            };


            $scope.searchProduct = {
                keyword: "",
                cate_id: "",
            };


            $scope.submitSearchProduct = function () {
                if (!searchProductTable) {
                    searchProductTable = $('#search-product-table').DataTable({
                        processing: true,
                        serverSide: true,
                        searching: false,
                        lengthChange: false,
                        order: [],
                        ajax: {
                            url: '/admin/products/searchData',
                            data: function (d) {
                                d.name = $scope.searchProduct.keyword;
                                d.cate_id = $scope.searchProduct.cate_id;
                            }
                        },
                        language: i18nDataTable,
                        columns: [
                            {data: 'DT_RowIndex', orderable: false, title: "STT", className: "text-center"},
                            {data: 'name',       title: 'Sản phẩm'},
                            {data: 'cate_id',  title: 'Danh mục'},
                            {data: 'price',      title: "Đơn giá bán", className: 'text-center'},
                        ],
                        search_columns: [
                            {data: 'name', search_type: "text", placeholder: "Tên sản phẩm"},
                            {
                                data: 'cate_id', search_type: "select", placeholder: "Danh mục",
                                column_data: @json(App\Model\Admin\Category::getForSelect())
                            },
                        ],
                    });


                    // Bắt sự kiện click vào 1 dòng
                    $('#search-product-table tbody').on('click', 'tr', function () {
                        const rowData = searchProductTable.row(this).data();

                        if (!rowData || !$scope.currentSuggestionType) return;

                        $scope.$applyAsync(function() {
                            if($scope.currentSuggestionType == 'base_product') {
                                $scope.product = rowData;
                            } else {
                                const arr = $scope.form.suggestions[$scope.currentSuggestionType];
                                // tránh trùng
                                if (!arr.find(p => p.id === rowData.id)) {
                                    arr.push({
                                        id:    rowData.id,
                                        name:  rowData.name,
                                        image: rowData ? rowData.image.path : '',  // nếu có
                                        price: rowData.price
                                    });
                                }
                            }
                        });
                        // Đóng modal
                        $('#searchProduct').modal('hide');
                    });

                } else {
                    searchProductTable.ajax.reload();
                }
            };
            $scope.removeSuggestion = function(type, item) {
                // Lấy mảng tương ứng với type
                var arr = $scope.form.suggestions[type];
                if (!Array.isArray(arr)) return;

                // Tìm index của item cần xóa
                for (var i = 0; i < arr.length; i++) {
                    if (arr[i].id === item.id) {
                        arr.splice(i, 1);
                        break;
                    }
                }
            };


            $scope.resetSearchProduct = function() {
                $scope.searchProduct = {
                    keyword: "",
                    cate_id: "",
                };
                setTimeout(() => {
                    $('.select2l').trigger('change');
                })
                $scope.submitSearchProduct();
            }

            $scope.loading = {}
            $scope.saveSuggest = function() {
                $scope.loading.submit = true;
                const payload = {
                    product_id: $scope.product.id,
                    suggestions: {
                        upsell:            $scope.form.suggestions.upsell.map(i => i.id),
                    }
                };
                $.ajax({
                    type: 'POST',
                    url: "{!! route('products-suggest.submitProductSuggest') !!}",
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: payload,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                        } else {
                            toastr.warning('Thao tác thất bại');
                            $scope.errors = response.errors;
                        }
                    },
                    error: function(e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function() {
                        $scope.loading.submit = false;
                        $scope.$applyAsync();
                    }
                });
            }
        });




    </script>
@endsection

