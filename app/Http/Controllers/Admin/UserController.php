<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CacheClearHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddressStoreRequest;
use App\Http\Requests\UserVehicleStoreRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\Admin;
use App\Models\Body;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Engine;
use App\Models\Fuel;
use App\Models\Language;
use App\Models\ModelYear;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserVehicle;
use App\Models\VehicleType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $users = User::where('user_type', 'user')->get();

            return DataTables::of($users)
                ->addColumn('action', function ($users) {
                    $edit_button = '<a href="' . route('admin.user.edit', [$users->id]) . '" class="btn btn-icon btn-info waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $users->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
//                    $detail_button = '<a href="' . route('admin.userDetails', [$users->id]) . '" class="btn btn-secondary btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.view') . '"><i class="bx bx-bullseye font-size-16 align-middle"></i></button>';
                    if ($users->status == 'Active') {
                        $status_button = '<button data-id="' . $users->id . '" data-status="InActive" class="status-change btn btn-warning btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.inactive') . '" ><i class="bx bx-refresh font-size-16 align-middle"></i></button>';
                    } else {
                        $status_button = '<button data-id="' . $users->id . '" data-status="Active" class="status-change btn btn-success btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.active') . '" ><i class="bx bx-refresh font-size-16 align-middle"></i></button>';
                    }
                    return '<div class="btn-icon-list"> ' . $edit_button . ' ' . $delete_button . '' . $status_button . '</div>';
                })
                ->addColumn('status', function ($users) {
                    if ($users->status == 'Active') {
                        $status = '<a data-id="' . $users->id . '" data-status="InActive" class="status-change" data-toggle="tooltip" data-placement="top" title="' . config('languageString.inactive') . '" ><span class="badge badge-success">' . config('languageString.active') . '</span></a>';
                    } else {
                        $status = '<span data-id="' . $users->id . '" data-status="Active"  class="status-change badge badge-danger" data-toggle="tooltip" data-placement="top" title="' . config('languageString.active') . '">' . config('languageString.inactive') . '</span>';
                    }
                    return $status;
                })
                ->addColumn('is_filter', function ($users) {
                    if($users->is_filter == 'yes') {
                        $filter = 'yes';
                    } else {
                        $filter = 'no';
                    }
                    return $filter;
                })
                ->addColumn('creation_time', function ($users) {
                    return date('d-m-Y H:i:s', strtotime($users->created_at));
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.user.index');
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $id = $request->input('edit_value');
            if ($id == NULL) {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->mobile_no = $request->mobile_no;
                $user->save();

                return response()->json(['message' => config('languageString.user_added')], 200);
            } else {
                $user = User::find($id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->mobile_no = $request->mobile_no;
                $user->save();

                return response()->json(['message' => config('languageString.user_updated')], 200);
            }

    }

    public function edit(int $id)
    {
        $user = User::find($id);
        return view('admin.user.edit', ["user" => $user]);
    }

    public function destroy(int $id)
    {
        User::where('id', $id)->delete();
        return response()->json(['message' => config('languageString.user_deleted')], 200);
    }

    public function changeStatus($id, $status)
    {
        User::where('id', $id)->update(['status' => $status]);

        return response()->json([
            'message' => Config::get('languageString.change_status_message'),
        ], 200);
    }

}
