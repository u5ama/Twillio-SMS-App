<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\AppControlStoreRequest;
use App\Models\AppControl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AppControlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\App\Modelslication|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            //DB::enableQueryLog();
            $appControl = AppControl::query();
            // dd(DB::getQueryLog());
            return Datatables::of($appControl)
                ->addColumn('status', function($appControl){
                    if($appControl->status == 'Active'){
                        $status = '<span class=" badge badge-success">' . config('languageString.active') . '</span>';
                    } else{
                        $status = '<span  class=" badge badge-danger">' . config('languageString.inactive') . '</span>';
                    }
                    return $status;
                })
                ->addColumn('action', function($appControl){
                    $edit_button = '<a href="' . route('admin.app-control.edit', [$appControl->id]) . '" class="btn btn-info btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $appControl->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
                    $status = 'Active';

                    if($appControl->status == 'Active'){
                        $status = 'InActive';

                    }
                    $status_button = '<button data-id="' . $appControl->id . '" data-status="' . $status . '"
                     class="status-change btn btn-warning btn-icon" data-effect="effect-fall"
                      data-toggle="tooltip" data-placement="top" title="' . $status . '">
                      <i class="bx bx-refresh font-size-16 align-middle"></i>
                      </button>';

                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button . '  ' . $status_button . '</div>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.appControl.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\App\Modelslication|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.appControl.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AppControlStoreRequest $request)
    {
        $id = $request->input('edit_value');
        $validated = $request->validated();

        if($id == NULL){
            AppControl::create([
                'controls_key'     => $validated['controls_key'],
                'controls_value'   => $validated['controls_value'],
                'controls_message' => $validated['controls_message'],
            ]);

            return response()->json(['success' => true, 'message' => config('languageString.app_control_added')]);
        } else{
            AppControl::where('id', $id)->update([
                'controls_key'     => $validated['controls_key'],
                'controls_value'   => $validated['controls_value'],
                'controls_message' => $validated['controls_message'],
            ]);
            return response()->json(['success' => true, 'message' => config('languageString.app_control_updated')]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\App\Modelslication|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $appControl = AppControl::find($id);
        if($appControl){
            return view('admin.appControl.edit', ['appControl' => $appControl]);
        } else{
            abort(404);
        }
    }

    public function appControlChangeStatus($id, $status)
    {
        AppControl::where('id', $id)->update(['status' => $status]);
        return response()->json(['success' => true, 'message' => config('languageString.change_status_message')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        AppControl::where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => config('languageString.app_control_deleted')]);
    }
}
