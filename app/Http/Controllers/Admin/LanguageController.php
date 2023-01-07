<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CacheClearHelper;
use App\Helpers\ImageUploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageStoreRequest;
use App\Models\Language;
use App\Models\LanguageString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Yajra\DataTables\Facades\DataTables;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->ajax()){

            $languages = Language::query();
            return DataTables::of($languages)
                ->addColumn('is_rtl', function($languages){
                    if($languages->is_rtl == 1){
                        return "Yes";
                    } else{
                        return "No";
                    }
                })
                ->addColumn('action', function($languages){
                    $edit_button = '<a href="' . route('admin.language.edit', [$languages->id]) . '" class="btn btn-icon btn-info waves-effect waves-light" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $languages->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
                    if($languages->status == 'Active'){
                        $status_button = '<button data-id="' . $languages->id . '" data-status="InActive" class="status-change btn btn-warning btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.inactive') . '" ><i class="bx bx-refresh font-size-16 align-middle"></i></button>';
                    } else{
                        $status_button = '<button data-id="' . $languages->id . '" data-status="Active" class="status-change btn btn-success btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.active') . '" ><i class="bx bx-refresh font-size-16 align-middle"></i></button>';
                    }
                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button . '' . $status_button . '</div>';
                })
                ->addColumn('status', function($languages){
                    if($languages->status == 'Active'){
                        $status = '<a data-id="' . $languages->id . '" data-status="InActive" class="status-change" data-toggle="tooltip" data-placement="top" title="' . config('languageString.inactive') . '" ><span class="badge badge-success">' . config('languageString.active') . '</span></a>';
                    } else{
                        $status = '<span data-id="' . $languages->id . '" data-status="Active"  class="status-change badge badge-danger" data-toggle="tooltip" data-placement="top" title="' . config('languageString.active') . '">' . config('languageString.inactive') . '</span>';
                    }
                    return $status;
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }
        return view('admin.language.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.language.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LanguageStoreRequest $request)
    {
        $validated = $request->validated();
        if($validated){
            if($request->edit_value == NULL){
                $image = ImageUploadHelper::imageUpload($validated['image']);
                $language = new Language();
                $language->name = $validated['name'];
                $language->language_code = $validated['language_code'];
                $language->is_rtl = $validated['is_rtl'];
                $language->language_image = $image;
                $language->save();

                CacheClearHelper::languageCacheClear();

                return response()->json(['message' => config('languageString.language_added')], 200);
            } else{
                if ($request->file('image') != '') {
                    $image = ImageUploadHelper::imageUpload($validated['image']);

                    $update = Language::find($request->edit_value);
                    $update->language_image = $image;
                    $update->save();
                }
                $language = Language::find($request->edit_value);
                $language->name = $validated['name'];
                $language->language_code = $validated['language_code'];
                $language->is_rtl = $validated['is_rtl'];
                $language->save();

                CacheClearHelper::languageCacheClear();
                return response()->json(['message' => config('languageString.language_updated')], 200);
            }
        }

    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $language = Language::findOrFail($id);
        return view('admin.language.edit', ["language" => $language]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        Language::where('id', $id)->delete();
        CacheClearHelper::languageCacheClear();

        return response()->json(['message' => config('languageString.language_deleted')], 200);
    }

    public function changeStatus($id, $status)
    {
        Language::where('id', $id)->update(['status' => $status]);

        return response()->json([
            'message' => Config::get('languageString.change_status_message'),
        ], 200);
    }
}
