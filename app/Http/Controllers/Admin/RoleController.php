<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignRoleRequest;
use App\Http\Requests\RoleStoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */

    function __construct()
    {
        $this->middleware('permission:role-list');
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if($request->ajax()){

            $roles = Role::select(['id', 'name'])->where('name', '!=', 'Master Admin')->get();
            return DataTables::of($roles)
                ->addColumn('action', function($admins){
                    $edit_button = '<a href="' . route('admin.role.edit', [$admins->id]) . '" class="btn btn-icon btn-info waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $admins->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button . '</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $permissions = Permission::get()->unique('module_name');
        return view('admin.role.create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleStoreRequest $request)
    {
        $validated = $request->validated();
        $id = $request->input('edit_value');
        if($validated){
            if($id == NULL){
                $role = Role::create(['name' => $request->input('name')]);
                $role->syncPermissions($request->input('permission'));

                return response()->json(['success' => true, 'message' => Config::get('languageString.role_added')]);
            } else{
                $role = Role::find($id);
                $role->name = $request->input('name');
                $role->save();
                $role->syncPermissions($request->input('permission'));
                return response()->json(['success' => true, 'message' => Config::get('languageString.role_updated')]);
            }
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Screen $screen
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $role = Role::find($id);
        $permissions = Permission::get()->unique('module_name');

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('admin.role.edit',
            [
                "role"            => $role,
                "permissions"     => $permissions,
                "rolePermissions" => $rolePermissions,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Screen $screen
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        Role::where('id', $id)->delete();
        return response()->json(['success' => true, 'status_code' => 200, 'message' => Config::get('languageString.role_deleted')]);
    }

}
