<?php

namespace App\Http\Controllers\Admin;


use App\Helpers\ImageUploadHelper;
use App\Http\Requests\AppControlStoreRequest;
use App\Http\Requests\AppMenuStoreRequest;
use App\Models\AppControl;
use App\Models\AppMenu;
use App\Models\AppMenuTranslation;
use App\Models\Language;
use App\Models\LanguageStringTranslation;
use App\Models\OnBoarding;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AppMenusController extends Controller
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
            $appMenu = AppMenu::all();

            return Datatables::of($appMenu)
                ->addColumn('app_menu_name', function($appMenu){
                    $name = $appMenu->name;
                    return $name;
                })
                ->addColumn('app_menu_slug', function($appMenu){
                    $slug = $appMenu->slug;
                    return $slug;
                })
                ->addColumn('app_menu_image', function($appMenu){
                    $image = $appMenu->image;
                    return '<img src="' . url($image) . '" height="70px">';
                })
                ->addColumn('app_menu_icon', function($appMenu){
                    $icon = $appMenu->icon;
                    return '<img src="' . url($icon) . '" height="70px">';
                })
                ->addColumn('ordering', function($appMenu){
                    $order = $appMenu->ordering;
                    return $order;
                })
                ->addColumn('action', function($appControl){
                    $edit_button = '<a href="' . route('admin.app-menu.edit', [$appControl->id]) . '" class="btn btn-info btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $appControl->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';

                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button  . '</div>';
                })->addColumn('web_view', function($appMenu){
                    if($appMenu->is_web_view == 1){

                            $class = "badge badge-success";
                            $name = "Yes";
                            $status = 0;
                            $status_ch = 'Inactive';
                        } if($appMenu->is_web_view == 0){
                            $class = "badge badge-warning";
                            $name = "No";
                            $status_ch = 'Active';
                            $status = 1;
                        }
                        $status_button = '<a type="button" data-id="' . $appMenu->id . '"  class="status-change '.$class.'" data-status="' . $status . '"  data-toggle="tooltip" data-placement="top" data-statustitle ="'.$status_ch.'" title="'.$status_ch.'" >'.$name.'</a>';
                        return $status_button;
                })
                ->rawColumns(['app_menu_name','web_view','app_menu_slug','app_menu_image','app_menu_icon','action','ordering'])
                ->make(true);
        }
        return view('admin.appMenu.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\App\Modelslication|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.appMenu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AppMenuStoreRequest $request)
    {
        $id = $request->input('edit_value');
        $validated = $request->validated();
        if($id == 0){
            $orderValue = AppMenu::where('user_type',$validated['app_menu_type'])->orderBy('ordering', 'DESC')->first();
            $orderValue = (isset($orderValue->ordering)) ? $orderValue->ordering+1 : 1;

            $icon = ImageUploadHelper::imageUpload($request->file('app_menu_icon'));
            $image = ImageUploadHelper::imageUpload($request->file('app_menu_image'));
            $app_menu = AppMenu::create([
                'image'     => $image,
                'icon'   => $icon,
                'name'   => $validated['app_menu_name'],
                'ordering' => $orderValue,
                'slug' => $validated['app_menu_slug'],
                'user_type' => $validated['app_menu_type'],
            ]);

//            $languages = Language::where('status','Active')->get();
//            foreach($languages as $language){
//                AppMenuTranslation::create([
//                    'name'               => $request->input($language->language_code . '_app_menu_name'),
//                    'app_menu_id'        =>  $app_menu->id,
//                    'locale'             => $language->language_code,
//                ]);
//            }

            return response()->json(['success' => true, 'message' => "Menu added successfully!"]);
        } else{
            if ($request->file('app_menu_icon') != '') {
                $icon = ImageUploadHelper::imageUpload($request->file('app_menu_icon'));

                $update = AppMenu::find($id);
                $update->icon = $icon;
                $update->save();
            }

            if ($request->file('app_menu_image') != '') {
                $image = ImageUploadHelper::imageUpload($request->file('app_menu_image'));

                $update = AppMenu::find($id);
                $update->image = $image;
                $update->save();
            }

            $app_menu = AppMenu::where('id', $id)->update([
                'slug' => $validated['app_menu_slug'],
                'name'   => $validated['app_menu_name'],
                'user_type' => $validated['app_menu_type'],
            ]);
//            $languages = Language::where('status', 'Active')->get();
            /*foreach ($languages as $language) {
                AppMenuTranslation::updateOrCreate([
                    'app_menu_id' => $id,
                    'locale'         => $language->language_code,
                ],
                    [
                        'app_menu_id' => $id,
                        'locale'         => $language->language_code,
                        'name'               => $request->input($language->language_code . '_app_menu_name'),
                    ]);

            }*/
            return response()->json(['success' => true, 'message' => config('languageString.app_menu_updated')]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\App\Modelslication|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $appMenu = AppMenu::where('id', $id)->first();
        if($appMenu){
            $indexes = AppMenu::where('user_type',$appMenu->user_type)->count();
            return view('admin.appMenu.edit', ['appMenu' => $appMenu,'indexes'  => $indexes]);
        } else{
            abort(404);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        AppMenu::where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => "app Menu Deleted"]);
    }
    public function changeWebView($id,$status)
    {
        AppMenu::where('id', $id)->update(['is_web_view'=>$status]);
        return response()->json(['success' => true, 'message' => Config::get('languageString.change_status_message')]);
    }

    public function SaveOrder(Request $request){

        $images = AppMenu::where('user_type',$request->user_type)->orderBy('ordering','DESC')->get();
        foreach ($images as $links=>$value){

            if($request->selectedOrder != ($links+1)){
                if ($request->menu_id == $value->id){
//                    $key = $value->social_order-1;
                }else {
                    AppMenu::where(['id' => $value->id])->update([
                        'ordering' => ($links + 1)
                    ]);
                }
            }else{
                AppMenu::where(['id'=>$request->menu_id])->update([
                    'ordering' => $request->selectedOrder
                ]);

            }
        }
    }
}
