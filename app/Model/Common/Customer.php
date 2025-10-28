<?php

namespace App\Model\Common;

use App\Model\BaseModel;
use App\Model\Uptek\G7Info;
use Vanthao03596\HCVN\Models\Province;
use Vanthao03596\HCVN\Models\District;
use Vanthao03596\HCVN\Models\Ward;
use App\Model\Common\User;
use Auth;
use App\Model\Common\Version;
use App\Model\Common\History;
use App\Http\Traits\HistoryTrait;
use \Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Customer extends BaseModel
{
	use HistoryTrait;

    protected $ignoreProperties = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'g7_id', 'accumulate_point', 'current_point'];

    protected $fillable = ['current_point','accumulate_point'];

	public const GENDERS = [
		0 => 'Nữ',
		1 => 'Nam'
	];

    public CONST HOAT_DONG = 1;
    public CONST DA_KHOA = 0;

    public CONST STATUSES = [
		[
			'id' => self::HOAT_DONG,
            'name' => 'Hoạt động',
            'type' => 'success'
        ],
        [
			'id' => self::DA_KHOA,
            'name' => 'Đã khóa',
            'type' => 'danger'
			]
		];

	public function canDelete()
	{
		return true;
	}

	public function canEdit()
	{
		return Auth::user()->type == User::SUPER_ADMIN || Auth::user()->type == User::QUAN_TRI_VIEN || (Auth::user()->g7_id == $this->g7_id && Auth::user()->type == User::G7);
	}

	public function versions()
	{
		return $this->morphMany(Version::class, 'model');
	}

	public function g7Info()
	{
		return $this->belongsTo(G7Info::class, 'g7_id','id');
	}

	public function group()
    {
        return $this->belongsTo(CustomerGroup::class, 'customer_group_id','id');
    }

    public function recipient()
    {
        return $this->morphOne(PaymentVoucher::class, 'recipientale');
    }

    public function cars()
    {
        return $this->belongsToMany('App\Model\Cars')->withTimestamps();
    }

    public function province()
    {
        return $this->belongsTo(Province::class,'province_id','id');
    }

    public function district()
    {
        return $this->belongsTo(District::class,'district_id','id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class,'ward_id','id');
    }

    public function bills()
    {
        return $this->hasMany('App\Model\G7\Bill','customer_id','id');
    }

    public function getFullAdressAttribute($value)
    {
        return ($this->adress ? $this->adress.", " : "").
            ($this->ward ? $this->ward->name.", " : "").
            ($this->district ? $this->district->name.", " : "").
            ($this->province ? $this->province->name.", " : "");
    }

    public static function searchByFilter($request) {
        $result = self::with(['user_update','user_create']);

        if(empty($request->name_mobile)) {

            if(Auth::user()->type == User::G7 || Auth::user()->type == User::NHAN_VIEN_G7) {
                $result = $result->where('g7_id', Auth::user()->g7_id);
            }
            if(Auth::user()->type == User::NHOM_G7) {
                $g7_ids = User::find(Auth::user()->id)->g7s->pluck('id');
                $result = $result->whereIn('g7_id',$g7_ids);
            }
        } else {
            $result = $result->where('name', $request->name_mobile)->orWhere('mobile',$request->name_mobile);
        }

        if (!empty($request->name)) {
            $result = $result->where('name', 'like', '%'.$request->name.'%');
        }

        if (!empty($request->mobile)) {
            $result = $result->where('mobile', 'like', '%'.$request->mobile.'%');
        }

        if (!empty($request->email)) {
            $result = $result->where('email', 'like', '%'.$request->email.'%');
        }

        if (!empty($request->province)) {
            $result = $result->where('province_id', $request->province);
        }

        if (!empty($request->district)) {
            $result = $result->where('district_id', $request->district);
        }

        if (!empty($request->ward)) {
            $result = $result->where('ward_id', $request->ward);
        }

        if ($request->status === 0 || $request->status === '0' || !empty($request->status)) {
            $result = $result->where('status', $request->status);
        }

        $result = $result->orderBy('created_at','desc');
        return $result;
    }

    public static function getDataForEdit($id)
    {
        return self::where('id',$id)
        ->with([
            'group'
        ])->firstOrFail();
    }

    public static function getForSelect() {
        return self::select(['id', 'name'])
            ->orderBy('name', 'asc')
            ->get();
    }

	public static function getDataForShow($id)
    {
        return self::where('id',$id)
			->with([
				'group',
                'bills',
				'versions' => function($q) {
					$q->select(['id', 'created_at as time', 'model_id', 'created_by'])
						->with([
							'histories',
							'user' => function($q) {
								$q->select(['id', 'name', 'avatar']);
							}
						])
						->orderBy('id', 'DESC');
				}
			])->firstOrFail();
    }


    public function generateCode() {
        $this->code = "KH.".generateCode(7, $this->id);
        $this->save();
    }

	public static function getDataForVersion($id) {
        return self::where('id', $id)
			->with([
				'group',
				'province',
				'district',
				'ward'
			])
			->first();
    }

    public function createHistoryRecord($version_id, $column_name, $old_value, $new_value) {
		switch ($column_name) {
            case "gender":
                if ($old_value) $old_value = self::GENDERS[$old_value];
                if ($new_value) $new_value = self::GENDERS[$new_value];
                break;
			case "status":
				if ($old_value) {
					$obj = array_find_el(self::STATUSES, function($el) use ($old_value) {
						return $el['id'] == $old_value;
					});
					$old_value = $obj['name'];
				}
                if ($new_value) {
					$obj = array_find_el(self::STATUSES, function($el) use ($new_value) {
						return $el['id'] == $new_value;
					});
					$new_value = $obj['name'];
				}
                break;
			case "customer_group_id":
				if ($old_value) $old_value = CustomerGroup::findOrFail($old_value)->name;
                if ($new_value) $new_value = CustomerGroup::findOrFail($new_value)->name;
                break;
			case "province_id":
				if ($old_value) $old_value = Province::findOrFail($old_value)->name;
				if ($new_value) $new_value = Province::findOrFail($new_value)->name;
				break;
			case "district_id":
				if ($old_value) $old_value = District::findOrFail($old_value)->name;
				if ($new_value) $new_value = District::findOrFail($new_value)->name;
				break;
			case "ward_id":
				if ($old_value) $old_value = Ward::findOrFail($old_value)->name;
				if ($new_value) $new_value = Ward::findOrFail($new_value)->name;
				break;
        }
        $history = new History();
        $history->version_id = $version_id;
        $history->column_name = $column_name;
        $history->old_value = $old_value;
        $history->new_value = $new_value;
        $history->model_id = $this->id;
        $history->model_type = self::class;
        $history->save();
    }
}
