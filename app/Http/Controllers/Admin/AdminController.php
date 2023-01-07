<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CacheClearHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminStoreRequest;
use App\Models\Admin;
use App\Models\User;
use App\Models\UserVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin-list');
        $this->middleware('permission:admin-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if($request->ajax()){

            $admins = DB::table('admins')->join('model_has_roles', 'admins.id', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', 'roles.id')
                ->where('admins.id','!=', 1)
                ->select('roles.name as role', 'admins.*');
            return DataTables::of($admins)
                ->addColumn('action', function($admins){
                    $edit_button = '<a href="' . route('admin.admin.edit', [$admins->id]) . '" class="btn btn-icon btn-info waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $admins->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
                    if($admins->status == 'Active'){
                        $status_button = '<button data-id="' . $admins->id . '" data-status="InActive" class="status-change btn btn-warning btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.inactive') . '" ><i class="bx bx-refresh font-size-16 align-middle"></i></button>';
                    } else{
                        $status_button = '<button data-id="' . $admins->id . '" data-status="Active" class="status-change btn btn-success btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.active') . '" ><i class="bx bx-refresh font-size-16 align-middle"></i></button>';
                    }
                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button . '' . $status_button . '</div>';
                })
                ->addColumn('status', function($admins){
                    if($admins->status == 'Active'){
                        $status = '<a data-id="' . $admins->id . '" data-status="InActive" class="status-change" data-toggle="tooltip" data-placement="top" title="' . config('languageString.inactive') . '" ><span class="badge badge-success">' . config('languageString.active') . '</span></a>';
                    } else{
                        $status = '<span data-id="' . $admins->id . '" data-status="Active"  class="status-change badge badge-danger" data-toggle="tooltip" data-placement="top" title="' . config('languageString.active') . '">' . config('languageString.inactive') . '</span>';
                    }
                    return $status;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.admin.index');
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'Master Admin')->get();
        return view('admin.admin.create', ['roles' => $roles]);
    }

    public function store(AdminStoreRequest $request)
    {
        $validated = $request->validated();
        $id = $request->input('edit_value');
        if($validated){
            if($id == NULL){
                $admin = new Admin();
                $admin->name = $validated['name'];
                $admin->email = $validated['email'];
                $admin->mobile_no = $validated['mobile_no'];
                $admin->password = Hash::make($request['password']);
                $admin->save();

                $admin->assignRole($validated['role_id']);

                return response()->json(['message' => config('languageString.admin_added')], 200);
            } else{
                $admin = Admin::find($id);
                $admin->name = $validated['name'];
                $admin->email = $validated['email'];
                $admin->mobile_no = $validated['mobile_no'];
                $admin->save();

                DB::table('model_has_roles')->where('model_id', $id)->delete();
                $admin->assignRole($validated['role_id']);

                return response()->json(['message' => config('languageString.admin_updated')], 200);
            }
        }

    }

    public function show(int $id)
    {
        //
    }

    public function edit(int $id)
    {
        $admin = DB::table('admins')->join('model_has_roles', 'admins.id', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', 'roles.id')
            ->select('roles.id as role_id', 'admins.*')->where('admins.id', $id)->first();

        $roles = Role::where('name', '!=', 'Master Admin')->get();
        return view('admin.admin.edit', ["admin" => $admin, 'roles' => $roles]);
    }

    public function update(Request $request, int $id)
    {
        //
    }

    public function destroy(int $id)
    {
        Admin::where('id', $id)->delete();
        CacheClearHelper::languageCacheClear();

        return response()->json(['message' => config('languageString.admin_deleted')], 200);
    }

    public function changeStatus($id, $status)
    {
        Admin::where('id', $id)->update(['status' => $status]);

        return response()->json([
            'message' => Config::get('languageString.change_status_message'),
        ], 200);
    }

    public function getChart(Request $request): \Illuminate\Http\JsonResponse
    {
        $monthName = [];
        for($i = 1; $i <= 12; $i++){
            $monthName[] = \Carbon\Carbon::create()->month($i)->startOfMonth()->format('F');
        }
        $month = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach($month as $a){
            $userVehicle = UserVehicle::whereMonth('created_at', '0' . $a)
                ->whereYear('created_at', $request->input('year'))
                ->count();
            $vehicle[] = $userVehicle;
        }
        return response()->json([
            'month' => $monthName,
            'data'  => $vehicle,
        ]);
    }

    public function getUserChart(Request $request): \Illuminate\Http\JsonResponse
    {
        $monthName = [];
        for($i = 1; $i <= 12; $i++){
            $monthName[] = \Carbon\Carbon::create()->month($i)->startOfMonth()->format('F');
        }
        $month = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        foreach($month as $a){
            $user = User::whereMonth('created_at', '0' . $a)
                ->whereYear('created_at', $request->input('year'))
                ->count();
            $users[] = $user;
        }
        return response()->json([
            'month' => $monthName,
            'data'  => $users,
        ]);
    }

}
