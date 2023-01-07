<?php

namespace App\Http\Controllers\Admin;


use App\Models\BuyGift;
use App\Models\Gifts;
use Illuminate\Contracts\Foundation\App\Modelslication;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class GiftsManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Modelslication|Factory|View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $gifts = BuyGift::with('gifts', 'player','fan')->get();
            return Datatables::of($gifts)
                ->addColumn('gift_name', function($gifts){
                    return $gifts->gifts->name;
                })
                ->addColumn('fan', function($gifts){
                    return $gifts->fan->name;
                })
                ->addColumn('player', function($gifts){
                    return $gifts->player->name;
                })
                ->addColumn('gift_price', function($gifts){
                    return $gifts->gifts->price;
                })
                ->addColumn('gift_commission', function($gifts){
                    return $gifts->gifts->commission. '%';
                })
                ->addColumn('action', function($gifts){
//                    $edit_button = '<a href="' . route('admin.gifts.edit', [$gifts->id]) . '" class="btn btn-info btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $gifts->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
//                    $extra_button = '<a href="#" class="driver-requirement btn btn-icon btn-secondary" data-toggle="tooltip" data-placement="top" title="' . config('languageString.extra') . '"><i class="bx bx-bullseye font-size-16 align-middle"></i></a>';
                    return '<div class="btn-icon-list">' . $delete_button  . '</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.giftsSent.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Http\Response|View
     */
    public function create()
    {
        return view('admin.giftsSent.create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        Gifts::where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => 'Gift Deleted Successfully!']);
    }
}
