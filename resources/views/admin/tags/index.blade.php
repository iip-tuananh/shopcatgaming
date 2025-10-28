@extends('layouts.main')
@section('css')

@endsection
@section('page_title')
    Danh mục thẻ Tags
@endsection
@section('title')
    Danh mục thẻ Tags
@endsection

@section('content')
    <div ng-controller="tags" ng-cloak>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-block">
                        <div class="button-tool pb-3 text-right">
                            <a href="javascript:void(0)" class="btn btn-info" data-target="#createModal"
                               data-toggle="modal">
                                <i class="fa fa-plus"></i> Thêm mới</a>
                        </div>
                        <table id="table-list">

                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
            <form action="#" method="POST" role="form" id="editForm">
                @method('PUT')
                @csrf
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="semi-bold">Thẻ tag</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group custom-group">
                                <label class="form-label required-label">Mã</label>
                                <input class="form-control" type="text"
                                       ng-model="editing.code"
                                       ng-class="{'is-invalid': errors && errors.code}">
                                <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors.code">
                                        <strong><% errors.code[0] %></strong>
                                    </span>
                            </div>

                            <div class="form-group custom-group">
                                <label class="form-label required-label">Tên</label>
                                <input class="form-control" type="text"
                                       ng-model="editing.name"
                                       ng-class="{'is-invalid': errors && errors.name}">
                                <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors.name">
                                        <strong><% errors.name[0] %></strong>
                                    </span>
                            </div>

                            <div class="form-group custom-group">
                                <label class="form-label required-label">Loại</label>
                                <select select2 class="select2-in-modal form-control" ng-model="editing.type">
                                    <option value="10" ng-selected="editing.type == 10">Sản phẩm </option>
                                    <option value="20" ng-selected="editing.type == 20">Bài viết </option>
                                </select>
                                <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors.type">
                                        <strong><% errors.type[0] %></strong>
                                </span>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" ng-disabled="loading"><i
                                    class="fa fa-save"></i> Lưu
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" ng-disabled="loading"><i
                                    class="fa fa-remove"></i> Hủy
                            </button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>

            </form>
        </div>

        <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
            <form method="POST" role="form" id="createForm">
                @csrf
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="semi-bold">Thẻ Tag</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group custom-group">
                                <label class="form-label required-label">Mã</label>
                                <input class="form-control" type="text" name="code"
                                       ng-class="{'is-invalid': errors && errors.code}">
                                <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors.code">
                                        <strong><% errors.code[0] %></strong>
                                    </span>
                            </div>

                            <div class="form-group custom-group">
                                <label class="form-label required-label">Tên</label>
                                <input class="form-control" type="text" name="name"
                                       ng-class="{'is-invalid': errors && errors.name}">
                                <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors.name">
                                        <strong><% errors.name[0] %></strong>
                                </span>
                            </div>

                            <div class="form-group custom-group">
                                <label class="form-label required-label">Loại</label>
                                <select class="select2-in-modal form-control" name="type">
                                    <option value="10">Sản phẩm </option>
                                    <option value="20">Bài viết </option>
                                </select>
                                <span class="invalid-feedback d-block" role="alert" ng-if="errors && errors.type">
                                        <strong><% errors.type[0] %></strong>
                                </span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" ng-disabled="loading"><i
                                    class="fa fa-save"></i> Lưu
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" ng-disabled="loading"><i
                                    class="fa fa-remove"></i> Hủy
                            </button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
            </form>
            <!-- /.modal-dialog -->
        </div>


    </div>
@endsection

@section('script')
    @include('partial.confirm');
    <script src="{{ asset('lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        var table = new DATATABLE('table-list', {
            ajax: {
                url: '{!! route('tags.searchData') !!}',
                data: function (d, context) {
                    DATATABLE.mergeSearch(d, context);
                }
            },
            columns: [
                {data: 'DT_RowIndex', orderable: false, title: "STT"},
                {data: 'code', title: "Mã"},
                {data: 'name', title: "Tên"},
                {data: 'type', title: "Loại"},
                {data: 'action', orderable: false, title: "Hành động"}
            ],
            search_columns: [
                {data: 'code', search_type: "text", placeholder: "Mã"},
                {data: 'name', search_type: "text", placeholder: "Tên"},
            ]
        }).datatable;

        app.controller('tags', function ($scope, $http) {

            $('#table-list').on('click', '.edit', function () {
                $scope.tag = table.row($(this).parents('tr')).data();
                $.ajax({
                    type: 'GET',
                    url: "/admin/tags/" + $scope.tag.id + "/getDataForEdit",
                    success: function(response) {
                        if (response.success) {
                            $scope.editing = response.data;
                            console.log($scope.editing);
                        }
                    },
                    error: function(err) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });

                $scope.errors = null;
                $('#editModal').modal('show');
            });

            $('#editForm').submit(function (e) {
                e.preventDefault();
                var url = "/admin/tags/" + $scope.editing.id + "/update";
                var data = $scope.editing;
                $scope.loading = true;
                $scope.$apply();
                $.ajax({
                    url: url,
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            $('#editModal').modal('hide');
                            document.getElementById("editForm").reset();
                            table.draw();
                            toastr.success(response.message);
                        } else {
                            $scope.errors = response.errors;
                            toastr.warning(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.loading = false;
                        $scope.$applyAsync();
                    }
                });
            })

            $('#createForm').submit(function (e) {
                e.preventDefault();
                var url = "{!! route('tags.store') !!}";
                var data = $('#createForm').serialize();

                $scope.loading = true;
                $scope.$apply();
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            $('#createModal').modal('hide');
                            document.getElementById("createForm").reset();
                            table.draw();
                            toastr.success(response.message);
                        } else {
                            $scope.errors = response.errors;
                            toastr.warning(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.loading = false;
                        $scope.$applyAsync();
                    }
                });
            });
        });
    </script>
@endsection
