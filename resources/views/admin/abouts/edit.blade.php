@extends('layouts.main')

@section('css')

@endsection

@section('title')
Chỉnh sửa video giới thiệu
@endsection

@section('page_title')
Chỉnh sửa video giới thiệu
@endsection

@section('content')
<div ng-controller="Post" ng-cloak>
  @include('admin.abouts.form')
</div>
@endsection
@section('script')
@include('admin.abouts.About')
<script>
    window.__ABOUT__ = {
        video_url: {!! json_encode($object->video_path ? asset($object->video_path) : null) !!}
    };
</script>

<script>
  app.controller('Post', function ($scope, $http, $timeout, $sce) {
    $scope.form = new About(@json($object), {scope: $scope});

    $scope.loading = {};
    @include('admin.posts.formJs')

      var existingUrl = (window.__ABOUT__ && window.__ABOUT__.video_url) ? window.__ABOUT__.video_url : null;
      $scope.form.video = {
          element_id: 'aboutVideo',
          file: null,
          path: existingUrl,
          trusted: existingUrl ? $sce.trustAsResourceUrl(existingUrl) : null, // cho <video>
          removed: false,
          size_limit: 10 * 1024 * 1024
      };

    $scope.onVideoChange = function(file) {
        $scope.$applyAsync(function () {
            // clear lỗi cũ
            $scope.errors = $scope.errors || {}
            $scope.errors.video = null;

            // không chọn gì
            if (!file) {
                $scope.form.video.file = null;
                $scope.form.video.path = null;
                return;
            }

            // Validate loại & dung lượng
            if (file.type !== 'video/mp4') {
                $scope.errors.video = ['Tệp phải là định dạng MP4.'];
                return;
            }
            if (file.size > $scope.form.video.size_limit) {
                $scope.errors.video = ['Dung lượng tối đa 10MB.'];
                return;
            }

            // Tạo preview
            if ($scope.form.video.path && $scope.form.video.path.startsWith('blob:')) {
                URL.revokeObjectURL($scope.form.video.path);
            }

            const url = URL.createObjectURL(file);
            $scope.form.video.file = file;
            $scope.form.video.path = url;
            $scope.form.video.trusted = $sce.trustAsResourceUrl(url);
            $scope.form.video.removed = false;
        });
    };

   $scope.removeVideo = function () {
       if ($scope.form.video.path && $scope.form.video.path.startsWith('blob:')) {
           URL.revokeObjectURL($scope.form.video.path);
       }
       $scope.form.video.file = null;
       $scope.form.video.path = null;
       $scope.form.video.trusted = null;
       $scope.form.video.removed = true;

       const el = document.getElementById($scope.form.video.element_id);
       if (el) el.value = '';
      };

    $scope.submit = function() {
      $scope.loading.submit = true;
      let data = $scope.form.submit_data;

        if ($scope.form.video && $scope.form.video.file) {
            data.append('video', $scope.form.video.file);
        }

        if ($scope.form.video.removed) {
            data.append('remove_video', '1');
        }

      $.ajax({
        type: 'POST',
        url: "/admin/about-video/update",
        headers: {
          'X-CSRF-TOKEN': CSRF_TOKEN
        },
        data: data,
        processData: false,
        contentType: false,
        success: function(response) {
          if (response.success) {
            toastr.success(response.message);
          } else {
            toastr.warning(response.message);
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
