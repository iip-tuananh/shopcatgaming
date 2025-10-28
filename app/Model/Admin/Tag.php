<?php

namespace App\Model\Admin;

use App\Model\BaseModel;
use App\Model\Common\File;
use Illuminate\Database\Eloquent\Model;
use Vanthao03596\HCVN\Models\Province;

class Tag extends Model
{
    protected $table = 'tags';
    protected $fillable = ['id', 'code', 'name', 'type'];
    protected $dates = ['created_at', 'updated_at'];

    const TYPE_PRODUCT = 10;
    const TYPE_POST = 20;

    const TYPES = [
        "10" => "sản phẩm",
        "20" => "bài viết",
    ];

    public static function searchByFilter($request)
    {
        $result = self::query();

        if (!empty($request->name)) {
            $result = $result->where('name', 'like', '%' . $request->name . '%');
        }

        $result = $result->orderBy('created_at', 'desc')->get();
        return $result;
    }

    public static function getDataForEdit($id)
    {
        return self::query()->where('id', $id)
            ->firstOrFail();
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'tagable');
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'tagable');
    }

    public function canDelete()
    {
        if ($this->products()->count() > 0 || $this->posts()->count() > 0) {
            return false;
        }

        return true;
    }

}
