$scope.loading = {};
$scope.getFileName = getFileName;

$(document).on('change', '#gallery-chooser', function(e) {
    Array.from(this.files).forEach(file => {
        let item = $scope.form.addGallery({});
        console.log(item);
        setTimeout(() => {
            let e = document.getElementById(item.image.element_id);
            let dataTransfer = new DataTransfer()
            dataTransfer.items.add(file)
            e.files = dataTransfer.files
            $(e).trigger('change');
        })
    });
    $scope.$apply();
})


$scope.addition_attachments = [];

$scope.addFile = function() {
if (!$scope.addition_attachments) $scope.addition_attachments = [];
$scope.addition_attachments.push({});
}

$scope.removeFile = function(index) {
$scope.addition_attachments.splice(index, 1);
}

$(document).on('change', '.attachments', function (e) {
let index = $(this).data('index');
let filename = e.target.files[0].name;
$scope.addition_attachments[index].name = filename;
$scope.$apply();
})

// Giữ nguyên mảng gốc
var items = ($scope.form.all_categories || []);

// Tính số con theo parent_id
var childCount = {};
items.forEach(function (c) {
if (c.parent_id && c.parent_id !== 0) {
childCount[c.parent_id] = (childCount[c.parent_id] || 0) + 1;
}
});

// Gắn cờ cho từng item
items.forEach(function (it) {
it._child_count = childCount[it.id] || 0;
// Cha có con => disable; còn lại chọn bình thường
it._disabled = (it.parent_id === 0 && it._child_count > 0);
// (tuỳ chọn) đặt nhãn hiển thị
it._label_suffix = (it.parent_id === 0)
? (it._child_count > 0 ? '' : '')
: '';
});

$scope.form.all_categories_marked = items;
