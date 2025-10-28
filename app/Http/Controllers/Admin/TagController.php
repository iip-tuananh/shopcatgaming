<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Tag;
use Illuminate\Http\Request;
use App\Model\Admin\Tag as ThisModel;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use \stdClass;
use Rap2hpoutre\FastExcel\FastExcel;
use PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    protected $view = 'admin.tags';
    protected $route = 'tags';

    public function index()
    {
        return view($this->view . '.index');
    }

    public function searchData(Request $request)
    {
        $objects = ThisModel::searchByFilter($request);
        return Datatables::of($objects)
            ->editColumn('updated_at', function ($object) {
                return formatDate($object->updated_at);
            })
            ->editColumn('type', function ($object) {
                return Tag::TYPES[$object->type];
            })
            ->addColumn('action', function ($object) {
                return '<a href="javascript:void(0)" title="Sửa" class="btn btn-sm btn-primary edit"><i class="fas fa-pencil-alt"></i></a> ' .
                    '<a href="' . route('tags.delete',
                        $object->id) . '" title="Xóa" class="btn btn-sm btn-danger delete confirm"><i class="fas fa-times"></i></a>';
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'type' => 'required|in:10,20',
                'code' => 'required|unique:tags,code',
            ]
        );

        $json = new stdClass();

        if ($validate->fails()) {
            $json->success = false;
            $json->errors = $validate->errors();
            $json->message = "Thao tác thất bại!";
            return Response::json($json);
        }

        DB::beginTransaction();
        try {
            $object = new ThisModel();
            $object->fill($request->all());
            $object->save();

            DB::commit();
            $json->success = true;
            $json->message = "Thao tác thành công!";
            $json->data = $object;
            return Response::json($json);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        $object = ThisModel::findOrFail($id);
        if (!$object->canview()) return view('not_found');
        $object = ThisModel::getDataForShow($id);
        return view($this->view . '.show', compact('object'));
    }

    public function edit(Request $request, $id)
    {
        $object = ThisModel::getDataForEdit($id);

        return view($this->view . '.edit', compact('object'));
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'type' => 'required|in:10,20',
                'code' => 'required|unique:tags,code,'.$id.',id',
            ]
        );
        $json = new stdClass();

        if ($validate->fails()) {
            $json->success = false;
            $json->errors = $validate->errors();
            $json->message = "Thao tác thất bại!";
            return Response::json($json);
        }

        DB::beginTransaction();
        try {
            $object = ThisModel::findOrFail($id);
            $object->fill($request->all());

            $object->save();

            DB::commit();
            $json->success = true;
            $json->message = "Thao tác thành công!";
            $json->data = $object;
            return Response::json($json);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        $object = ThisModel::findOrFail($id);
        if (!$object->canDelete()) {
            $message = array(
                "message" => "Không thể xóa!",
                "alert-type" => "warning"
            );
        } else {
            $object->delete();
            $message = array(
                "message" => "Thao tác thành công!",
                "alert-type" => "success"
            );
        }


        return redirect()->route($this->route . '.index')->with($message);
    }

    public function getDataForEdit($id)
    {
        $json = new stdclass();
        $json->success = true;
        $json->data = ThisModel::getDataForEdit($id);
        return Response::json($json);
    }

    // Xuất Excel
    public function exportExcel(Request $request)
    {
        return (new FastExcel(ThisModel::searchByFilter($request)))->download('danh_sach_lich_hen.xlsx', function ($object) {
            return [
                'Khách hàng' => $object->customer->name,
                'SĐT khách' => $object->customer->mobile,
                'Giờ hẹn' => \Carbon\Carbon::parse($object->booking_time)->format('H:m d/m/Y'),
                'Ghi chú' => $object->note,
                'Trạng thái' => $object->status == 0 ? 'Khóa' : 'Hoạt động',
            ];
        });
    }

    // Xuất PDF
    public function exportPDF(Request $request)
    {
        $data = ThisModel::searchByFilter($request);
        $pdf = \Barryvdh\DomPDF\PDF::loadView($this->view . '.pdf', compact('data'));
        return $pdf->download('danh_sach_lich_hen.pdf');
    }


}
