<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CacheClearHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\FcmCredentialStoreRequest;
use App\Models\Admin;
use App\Models\FcmCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class FcmCredentialController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:fcm-credential-read');
        $this->middleware('permission:fcm-credential-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:fcm-credential-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:fcm-credential-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if($request->ajax()){

            $fcmCredentials = FcmCredential::query();
            return DataTables::of($fcmCredentials)
                ->addColumn('action', function($fcmCredentials){
                    $edit_button = '<a href="' . route('admin.fcm-credential.edit', [$fcmCredentials->id]) . '" class="btn btn-icon btn-info waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $fcmCredentials->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
                    if($fcmCredentials->status == 'Active'){
                        $status_button = '<button data-id="' . $fcmCredentials->id . '" data-status="InActive" class="status-change btn btn-warning btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.inactive') . '" ><i class="bx bx-refresh font-size-16 align-middle"></i></button>';
                    } else{
                        $status_button = '<button data-id="' . $fcmCredentials->id . '" data-status="Active" class="status-change btn btn-success btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.active') . '" ><i class="bx bx-refresh font-size-16 align-middle"></i></button>';
                    }
                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button . '' . $status_button . '</div>';
                })
                ->addColumn('status', function($fcmCredentials){
                    if($fcmCredentials->status == 'Active'){
                        $status = '<a data-id="' . $fcmCredentials->id . '" data-status="InActive" class="status-change" data-toggle="tooltip" data-placement="top" title="' . config('languageString.inactive') . '" ><span class="badge badge-success">' . config('languageString.active') . '</span></a>';
                    } else{
                        $status = '<span data-id="' . $fcmCredentials->id . '" data-status="Active"  class="status-change badge badge-danger" data-toggle="tooltip" data-placement="top" title="' . config('languageString.active') . '">' . config('languageString.inactive') . '</span>';
                    }
                    return $status;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.fcmCredential.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.fcmCredential.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FcmCredentialStoreRequest $request)
    {
        $validated = $request->validated();
        $id = $request->input('edit_value');
        if($validated){
            if($id == NULL){
                $admin = new FcmCredential();
                $admin->project_name = $validated['project_name'];
                $admin->server_key = $validated['server_key'];
                $admin->sender_id = $validated['sender_id'];
                $admin->save();

                return response()->json(['message' => config('languageString.fcm_credential_added')], 200);
            } else{
                $admin = FcmCredential::find($id);
                $admin->project_name = $validated['project_name'];
                $admin->server_key = $validated['server_key'];
                $admin->sender_id = $validated['sender_id'];
                $admin->save();


                return response()->json(['message' => config('languageString.fcm_credential_updated')], 200);
            }
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $fcmCredential = FcmCredential::find($id);
        return view('admin.fcmCredential.edit', ["fcmCredential" => $fcmCredential]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        FcmCredential::where('id', $id)->delete();


        return response()->json(['message' => config('languageString.fcm_credential_deleted')], 200);
    }

    public function changeStatus($id, $status)
    {
        FcmCredential::where('id', $id)->update(['status' => $status]);

        return response()->json([
            'message' => Config::get('languageString.change_status_message'),
        ], 200);
    }
}
