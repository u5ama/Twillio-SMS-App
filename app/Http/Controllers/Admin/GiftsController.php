<?php

namespace App\Http\Controllers\Admin;


use App\Models\Gifts;
use Illuminate\Contracts\Foundation\App\Modelslication;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class GiftsController extends Controller
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
            $gifts = Gifts::all();
            return Datatables::of($gifts)
                ->addColumn('gift_image', function($gifts){
                    $image = $gifts->image;
                    return '<img src="' . url($image) . '" height="70px" />';
                })
                ->addColumn('action', function($gifts){
                    $edit_button = '<a href="' . route('admin.gifts.edit', [$gifts->id]) . '" class="btn btn-info btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $gifts->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
//                    $extra_button = '<a href="#" class="driver-requirement btn btn-icon btn-secondary" data-toggle="tooltip" data-placement="top" title="' . config('languageString.extra') . '"><i class="bx bx-bullseye font-size-16 align-middle"></i></a>';
                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button  . '</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.gifts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Http\Response|View
     */
    public function create()
    {
        return view('admin.gifts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {

        $id = $request->input('edit_value');

        if($id == NULL){
            if ($request->hasFile('image')) {
                $mime = $request->image->getMimeType();
                $logo = $request->file('image');
                $logo_name = preg_replace('/\s+/', '', $logo->getClientOriginalName());
                $logoName = time() . '-' . $logo_name;
                $logo->move('./assets/user/gifts/', $logoName);
                $cat_img = 'assets/user/gifts/' . $logoName;
            }
            Gifts::create([
                'name'   => $request->name,
                'image'  => $cat_img,
                'price'  => $request->price,
                'commission'  => $request->commission,
            ]);
            return response()->json(['success' => true, 'message' => 'Gift Added Successfully!']);
        } else{

            if ($request->hasFile('image')) {
                $mime = $request->image->getMimeType();
                $logo = $request->file('image');
                $logo_name = preg_replace('/\s+/', '', $logo->getClientOriginalName());
                $logoName = time() . '-' . $logo_name;
                $logo->move('./assets/user/gifts/', $logoName);
                $cat_img = 'assets/user/gifts/' . $logoName;
            }

            Gifts::where('id', $id)->update([
                'name'   => $request->name,
                'price'   => $request->price,
                'image'  => $cat_img,
                'commission'  => $request->commission,
            ]);

            return response()->json(['success' => true, 'message' => 'Gift Updated Successfully!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Modelslication|Factory|View
     */
    public function edit($id)
    {
        $gift = Gifts::find($id);
        if($gift){
            return view('admin.gifts.edit', ['gift' => $gift]);
        } else{
            abort(404);
        }
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
