<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageStringStoreRequest;
use App\Models\Language;
use App\Models\LanguageString;
use App\Models\LanguageStringTranslation;
use App\Models\LanguageScreen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;


class LanguageStringController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $language_strings = LanguageString::with('language_screen');
            if($request['panel'] != null) {
                $language_strings->whereHas('language_screen', function ($query) use ($request){
                   $query->where('app_or_panel', $request['panel']);
                });
            }
            $language_strings=$language_strings->get();
            return DataTables::of($language_strings)
                ->addColumn('app_or_panel', function($language_strings){
                    if($language_strings->language_screen->app_or_panel === 0){
                        return config('languageString.admin_panel');
                    } else{
                        return config('languageString.app');
                    }
                })
                ->addColumn('value_ar', function($language_strings){
                    return $language_strings->translateOrNew('ar')->name;
                })
                ->addColumn('action', function($language_strings){
                    $edit_button = '<a href="' . route('admin.language-string.edit', [$language_strings->id]) . '" class="btn btn-icon btn-info waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $language_strings->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';

                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button . '</div>';
                })
                ->addColumn('view_screen', function($languageScreens){
                    return '<a href="' . route('admin.view-language-screen', [$languageScreens->language_screen_id]) . '" class="btn btn-icon btn-info waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="' . config('languageString.view') . '"><i class="far fa-eye align-middle"></i></a>';
                })

                ->rawColumns(['action', 'image', 'view_screen'])
                ->make(true);
        }
        return view('admin.languageString.index');
    }

    public function create()
    {
        $languageScreens = LanguageScreen::all();
        $languages = Language::where('status','Active')->get();
        return view('admin.languageString.create', ['languageScreens' => $languageScreens, 'languages' => $languages]);
    }

    public function store(LanguageStringStoreRequest $request)
    {
        $validated = $request->validated();
        $id = $request->edit_value;
        if($validated){
            if($id == NULL){

                $language_string = new LanguageString();
                $language_string->language_screen_id = $validated['language_screen_id'];
                $language_string->name_key = $validated['name_key'];
                $language_string->save();

                $languages = Language::where('status','Active')->get();
                foreach($languages as $language){
                    LanguageStringTranslation::create([
                        'name'               => $request->input($language->language_code . '_name'),
                        'language_string_id' => $language_string->id,
                        'locale'             => $language->language_code,
                    ]);
                }

                return response()->json(['success' => true, 'message' => Config::get('languageString.language_string_added')], 200);
            } else{

                $language_string = LanguageString::findorfail($id);
                $language_string->language_screen_id = $validated['language_screen_id'];
                $language_string->save();

                $languages = Language::where('status','Active')->get();
                foreach($languages as $language){
                    LanguageStringTranslation::updateOrCreate([
                        'language_string_id' => $id,
                        'locale'             => $language->language_code,
                    ],
                        [
                            'language_string_id' => $id,
                            'locale'             => $language->language_code,
                            'name'               => $request->input($language->language_code . '_name'),
                        ]);
                }

                return response()->json(['success' => true, 'message' => Config::get('languageString.language_string_updated')], 200);
            }

        }

    }

    public function getLanguageScreen(Request $request)
    {
        $type = $request->input('app_or_panel');
        $languageScreens = LanguageScreen::where('app_or_panel', $type)->get();

        if(count($languageScreens) > 0){
            echo "<option value=''>" . Config::get('languageString.please_select_screen') . "</option>";
            foreach($languageScreens as $languageScreen){
                echo "<option value='" . $languageScreen->id . "'>" . $languageScreen->name . "</option>";
            }
        } else{
            echo "<option value=''>" . Config::get('languageString.no_screen_found') . "</option>";
        }

    }

    public function edit(int $id)
    {
        $languageScreens = LanguageScreen::get();
        $languages = Language::where('status','Active')->get();
        $languageString = LanguageString::findorfail($id);
        return view('admin.languageString.edit', ["languageString" => $languageString, "languageScreens" => $languageScreens, "languages" => $languages]);
    }

    public function destroy($id)
    {
        LanguageString::where('id', $id)->delete();
        return response()->json(['success' => true, 'status_code' => 200, 'message' => Config::get('languageString.language_string_deleted')]);
    }

    public function changeStatus($id, $status)
    {
        LanguageString::where('id', $id)->update(['status' => $status]);

        return response()->json([
            'message' => Config::get('languageString.change_status_message'),
        ], 200);
    }

}
