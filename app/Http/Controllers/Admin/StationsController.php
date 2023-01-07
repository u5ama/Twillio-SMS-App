<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Auth;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class StationsController extends Controller
{
    /**
     * Display a listing of the Company.
     *
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $users = User::where('user_type', 'station')->get();

            return DataTables::of($users)
                ->addColumn('action', function ($users) {
                    $edit_button = '<a href="' . route('admin.stations.edit', [$users->id]) . '" class="btn btn-icon btn-info waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
//                    $delete_button = '<button data-id="' . $users->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
                    $delete_button = '';
                    $detail_button = '<a href="' . route('admin.stations.show', [$users->id]) . '" class="btn btn-secondary btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.view') . '"><i class="bx bx-bullseye font-size-16 align-middle"></i></button>';
                    if ($users->status == 'Active') {
                        $status_button = '<button data-id="' . $users->id . '" data-status="InActive" class="status-change btn btn-warning btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.inactive') . '" ><i class="bx bx-refresh font-size-16 align-middle"></i></button>';
                    } else {
                        $status_button = '<button data-id="' . $users->id . '" data-status="Active" class="status-change btn btn-success btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.active') . '" ><i class="bx bx-refresh font-size-16 align-middle"></i></button>';
                    }
                    return '<div class="btn-icon-list">' . $detail_button . ' ' . $edit_button . ' ' . $delete_button . '' . $status_button . '</div>';
                })
                ->addColumn('status', function ($users) {
                    if ($users->status == 'Active') {
                        $status = '<a data-id="' . $users->id . '" data-status="InActive" class="status-change" data-toggle="tooltip" data-placement="top" title="' . config('languageString.inactive') . '" ><span class="badge badge-success">' . config('languageString.active') . '</span></a>';
                    } else {
                        $status = '<span data-id="' . $users->id . '" data-status="Active"  class="status-change badge badge-danger" data-toggle="tooltip" data-placement="top" title="' . config('languageString.active') . '">' . config('languageString.inactive') . '</span>';
                    }
                    return $status;
                })
                ->addColumn('creation_time', function ($users) {
                    return date('d-m-Y H:i:s', strtotime($users->created_at));
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.stations.index');
    }

    /**
     * Show the form for creating a new Company.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.stations.create');
    }

    /**
     * Store a newly created Company in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $id = $request->input('edit_value');
        if ($id == NULL) {
            $user = new User();
            $user->name = $request->name;
            $user->address = $request->address;
            $user->user_type = 'station';

            $user->save();

            return response()->json(['success' => true,'message' => config('languageString.user_added')], 200);
        } else {
            $user = User::find($id);
            $user->name = $request->name;
            $user->address = $request->address;
            $user->user_type = 'station';

            $user->save();

            return response()->json(['success' => true,'message' => config('languageString.user_updated')], 200);
        }
    }

    /**
     * Display the specified Company.
     *
     * @param int $id
     * @return Factory|View
     */
    public function show($id)
    {
        $stations = User::where('id', $id)->first();

        $stations = [
            'user_type' => $stations->user_type,
            'Name'  => $stations->name,
            'Address' => $stations->address,
            /* Add here all the data you need*/
        ];

        $stations = json_encode($stations);

        return view('admin.stations.show', ['stations' => $stations]);
    }

    /**
     * Show the form for editing the specified Company.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $stations = User::find($id);
        if ($stations) {
            return view('admin.stations.edit', ['station' => $stations]);
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified Company from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return response()->json(['success' => true, 'message' => trans('adminMessages.country_deleted')]);
    }


    /**Change the status for Company
     * @param $id
     * @param $status
     * @return JsonResponse
     */
    public function changeStatus($id, $status)
    {
        User::where('id', $id)->update(['status' => $status]);

        return response()->json([
            'message' => Config::get('languageString.change_status_message'),
        ], 200);
    }

}
