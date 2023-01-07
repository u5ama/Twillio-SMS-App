<?php

namespace App\Http\Controllers\Admin;


use App\Models\SMSLogs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DriverNotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Modelslication|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            //DB::enableQueryLog();
            $sms = SMSLogs::where('type', 'driver')->get();
            // dd(DB::getQueryLog());
            return Datatables::of($sms)

                ->addColumn('action', function($sms){
                    $delete_button = '<button data-id="' . $sms->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="Delete"><i class="bx bx-trash font-size-16 align-middle"></i></button>';

                    return '<div class="btn-icon-list">' . $delete_button . '</div>';
                })
                ->addColumn('creation_time', function ($sms) {
                    return date('d-m-Y H:i:s', strtotime($sms->created_at));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.drivers_notifications.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Modelslication|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.appControl.create');
    }


    public function destroy($id)
    {
        SMSLogs::where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => 'Driver Log Deleted']);
    }
}
