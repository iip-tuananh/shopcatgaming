@extends('layouts.main')

@section('css')
@endsection

@section('page_title')
    Chi tiết đơn hàng
@endsection

@section('title')
    Chi tiết đơn hàng
@endsection

@section('buttons')
@endsection

@section('content')

<div ng-controller="Order" ng-cloak>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6>Thông tin chung</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Khách hàng: <% form.customer_name %> </label>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email: <% form.customer_email %></label>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">SĐT: <% form.customer_phone %></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Địa chỉ: <% form.customer_address %> </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Tổng tiền: <% form.total_price | number %></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Phương thức thanh toán: <% form.payment_method_name %></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Trạng thái: <% getStatus(form.status) %></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Yêu cầu khác: </label>
                                <textarea id="my-textarea" class="form-control" rows="3"><% form.customer_required %></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Chi tiết</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên hàng hóa</th>
                                <th>Phân loại</th>
                                <th>Giá tiền</th>
                                <th>Số lượng đặt mua</th>
                                <th>Thành tiền</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="detail in form.details track by $index">
                                <td class="text-center"><% $index + 1 %></td>
                                <td class="text-center"><% detail.product.name %></td>
                                <td class="text-center"><% detail.type %></td>
                                <td class="text-center" ng-if="detail.price > 0"><% detail.price | number %></td>
                                <td class="text-center" ng-if="detail.price <= 0">Liên hệ</td>
                                <td class="text-center"><% detail.qty | number %></td>
                                <td class="text-right" ng-if="detail.price > 0"><% (detail.qty * detail.price) | number %></td>
                                <td class="text-right" ng-if="detail.price <= 0">Liên hệ</td>

                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><b>Tổng thành tiền: </b></td>
                                <td class="text-right"><b><% form.total_price | number %></b></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><b>Giảm giá: </b><br>
                                    <span ng-if="form.discount_code" class="text-danger">
                                        <i class="fa fa-tag"></i> <% form.discount_code ? 'Voucher: ' + form.discount_code : '' %>
                                    </span>
                                </td>
                                <td class="text-right"><b><% form.discount_value | number %></b></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><b>Thành tiền sau giảm: </b></td>
                                <td class="text-right"><b><% form.total_price | number %></b></td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <div class="text-right">
        <a href="{{ route('orders.index') }}" class="btn btn-danger btn-cons">
            <i class="fa fa-remove"></i> Quay lại
        </a>
    </div>
</div>
@endsection

@section('script')
    @include('admin.orders.Order')

    <script>
        app.controller('Order', function ($scope, $http) {
            $scope.form = new Order(@json($order), {scope: $scope});
            $scope.statuses = @json(\App\Model\Admin\Order::STATUSES);
            $scope.$applyAsync();

            $scope.getStatus = function (status) {
                let obj = $scope.statuses.find(val => val.id == status);
                return obj.name;
            }

        });
    </script>
@endsection
