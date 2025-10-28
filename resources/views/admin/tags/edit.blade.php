@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('lib/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('pages/data-table/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('lib/sweetalert/css/sweetalert.css') }}">
@endsection

@section('title')

@endsection

@section('content')
    <div ng-controller="banks">
        @include('admin.tags.form')
        <hr>
        <div class="text-right">
            <button type="button" class="btn btn-success btn-cons" ng-click="submit()" ng-disabled="loading.submit">
                <i ng-if="!loading.submit" class="fa fa-save"></i>
                <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
                Lưu
            </button>
            <a href="{{ route('tags.index') }}" class="btn btn-danger btn-cons">
                <i class="fa fa-remove"></i> Hủy
            </a>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lib/sweetalert/js/sweetalert.min.js') }}"></script>

    <script>
        app.controller('banks', function ($scope) {
            $scope.loading = {};

            $scope.form = new Bank(@json($bank), {mode: 'edit', scope: $scope});

            $scope.submit = function () {
                $scope.loading.submit = true;
                let data = $scope.form.submit_data;
                console.log(data);
                $.ajax({
                    type: 'PUT',
                    url: "{{ route('banks.update', $bank->id) }}",
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            window.location.href = "{{ route('banks.index') }}";
                        } else {
                            $scope.errors = response.errors;
                            toastr.warning(response.message);
                            $scope.loading.submit = false;
                        }
                    },
                    error: function () {
                        toastr.error('Đã có lỗi xảy ra');
                        $scope.loading.submit = false;
                    },
                    complete: function () {

                        $scope.$applyAsync();
                    }
                });
            }

            var table = new DATATABLE('bank-branch-list', {
                ajax: {
                    url: '{!! route('banks.branch.searchData') !!}',
                    data: function (d, context) {
                        d.bank_id = "{{$bank->id}}";
                        DATATABLE.mergeSearch(d, context);
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, title: "STT"},
                    {data: 'code', title: "Mã ngân hàng"},
                    {data: 'name', title: "Tên ngân hàng"},
                    {data: 'international_business_name', title: "Tên giao dịch quốc tế"},
                    {data: 'business_address', title: "Địa chỉ giao dịch"},
                    {data: 'action', orderable: false, title: "Hành động"}
                ],
                search_columns: [
                    {data: 'code', search_type: "text", placeholder: "Mã ngân hàng"},
                    {data: 'name', search_type: "text", placeholder: "Tên ngân hàng"},
                ]
            }).datatable;
        })
    </script>

@endsection
