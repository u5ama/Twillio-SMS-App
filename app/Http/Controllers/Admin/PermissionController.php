<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignRoleRequest;
use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\RoleStoreRequest;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
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
        $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
    }

    public function create()
    {
        $array = [
            'create' => 'create',
            'read'   => 'read',
            'update' => 'update',
            'delete' => 'delete',
        ];
        return view('admin.permission.create', ['array' => $array]);
    }

    public function store(PermissionStoreRequest $request)
    {
        $validated = $request->validated();
        $array = [
            'create' => 'create',
            'read'   => 'read',
            'update' => 'update',
            'delete' => 'delete',
        ];
        foreach($array as $value){
            if($request->input($value)){
                $permission[] = [
                    'module_name' => strtolower($validated['module_name']),
                    'guard_name'  => 'admin',
                    'name'        => str_replace(' ', '-', strtolower($validated['module_name'])) . '-' . $value,
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                ];
            }
        }
        $permission = Permission::insert($permission);
        return response()->json(['message' => Config::get('languageString.permission_added')], 200);
    }
}
