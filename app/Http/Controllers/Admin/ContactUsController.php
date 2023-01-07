<?php

namespace App\Http\Controllers\Admin;


use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ContactUsController extends Controller
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
            $contactus = ContactUs::with('user')->select('contact_us.*');
            // dd(DB::getQueryLog());
            return Datatables::of($contactus)
                ->addColumn('action', function($contactus){
                    $delete_button = '<button data-id="' . $contactus->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
                    return '<div class="btn-icon-list">' . $delete_button . '</div>';
                })
                ->addColumn('name', function($contactus){
                    return $contactus->user->name;
                })
                ->addColumn('message',function($contactus){
                    return implode(PHP_EOL, str_split($contactus->message, 50));
                })
                ->addColumn('creation_time', function ($users) {
                    return date('d-m-Y H:i:s', strtotime($users->created_at));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        ContactUs::where('is_seen', 0)->update([
            'is_seen' => 1,
        ]);
        return view('admin.contactus.index');
    }

    public function destroy($id)
    {
        ContactUs::where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => config('languageString.contact_us_request_deleted')]);
    }

}
