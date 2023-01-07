<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CacheClearHelper;
use App\Helpers\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageScreenStoreRequest;
use App\Models\LanguageScreen;
use App\Models\LanguageString;
use App\Models\ScreenFamily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;

class LanguageScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->ajax()){

            $languageScreens = LanguageScreen::query();
            return DataTables::of($languageScreens)
                ->addColumn('action', function($languageScreens){
                    $edit_button = '<a href="' . route('admin.language-screen.edit', [$languageScreens->id]) . '" class="btn btn-icon btn-info waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $languageScreens->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button  . '</div>';
                })
                ->addColumn('image', function($languageScreens){
                    if(!empty($languageScreens->image)){
                        return '<img class="img-thumbnail" width="100px" height="100px" src="' . url($languageScreens->image) . '" />';
                    } else{
                        return '';
                    }
                })
                ->addColumn('view_screen', function($languageScreens){
                    return '<a href="' . route('admin.view-language-screen', [$languageScreens->id]) . '" class="btn btn-icon btn-info waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="' . config('languageString.view') . '"><i class="far fa-eye align-middle"></i></a>';
                })
                ->rawColumns(['action', 'image', 'view_screen'])
                ->make(true);
        }
        return view('admin.languageScreen.index');
    }

    public function create()
    {
        return view('admin.languageScreen.create');
    }

    public function store(LanguageScreenStoreRequest $request)
    {
        $validated = $request->validated();
        $id = $request->input('edit_value');
        if($validated){
            if($id == NULL){
                $image = '';
                if($request->hasFile('image')){
                    $image = ImageUploadHelper::imageUpload($request->file('image'));
                }

                $languageScreen = new LanguageScreen();
                $languageScreen->name = $validated['name'];
                $languageScreen->app_or_panel = $validated['app_or_panel'];
                $languageScreen->image = $image;
                $languageScreen->save();

                // CacheClearHelper::languageCacheClear();

                return response()->json(['message' => config('languageString.language_screen_added')], 200);
            } else{
                if($request->hasFile('image')){
                    $image = ImageUploadHelper::imageUpload($request->file('image'));
                } else{
                    $image = LanguageScreen::where('id', $id)->first()->image;
                }

                $languageScreen = LanguageScreen::find($id);
                $languageScreen->name = $validated['name'];
                $languageScreen->image = $image;
                $languageScreen->app_or_panel = $validated['app_or_panel'];
                $languageScreen->save();

                // CacheClearHelper::languageCacheClear();
                return response()->json(['message' => config('languageString.language_screen_updated')], 200);
            }
        }

    }


    public function edit(int $id)
    {
        $languageScreen = LanguageScreen::findOrFail($id);
        return view('admin.languageScreen.edit', ["languageScreen" => $languageScreen]);
    }

    public function destroy(int $id)
    {
        LanguageScreen::where('id', $id)->delete();
        // CacheClearHelper::languageCacheClear();
        return response()->json(['message' => config('languageString.language_screen_deleted')], 200);
    }

    public function changeStatus($id, $status)
    {
        LanguageScreen::where('id', $id)->update(['status' => $status]);

        return response()->json([
            'message' => Config::get('languageString.change_status_message'),
        ], 200);
    }

    public function viewLanguageScreen($id)
    {
        $languageScreen = LanguageScreen::where('id', $id)->first();
        return view('admin.languageScreen.view', ['languageScreen' => $languageScreen]);
    }

    public function viewScreenString(Request $request)
    {
        if($request->ajax()){
            $languageStrings = LanguageString::with('language_screen')->where('language_screen_id', $request->id)->get();
            return DataTables::of($languageStrings)
                ->addColumn('action', function($languageStrings){
                    $edit_button = '<a href="' . route('admin.language-string.edit', [$languageStrings->id]) . '" class="btn btn-icon btn-info waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $languageStrings->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';

                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button . '</div>';
                })
                ->addColumn('app_or_panel', function($language_strings){
                    if($language_strings->language_screen->app_or_panel === 0){
                        return config('languageString.admin_panel');
                    } else{
                        return config('languageString.app');
                    }
                })
                ->addColumn('value_ar', function($languageStrings){
                    return $languageStrings->translateOrNew('ar')->name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.languageScreen.view');
    }
}
