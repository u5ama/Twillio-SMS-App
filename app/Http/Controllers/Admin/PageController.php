<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\PageStoreRequest;
use App\Models\Language;
use App\Models\LanguageStringTranslation;
use App\Models\Page;
use App\Models\PageTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\App\Modelslication|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $page = Page::query();
            return Datatables::of($page)
                ->addColumn('action', function($page){
                    $delete_button = '';
                    $edit_button = '<a href="' . route('admin.page.edit', [$page->id]) . '" class="btn btn-info btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
//                    $delete_button = '<button data-id="' . $page->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';

                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button . '</div>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.page.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\App\Modelslication|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $languages = Language::where('status','Active')->get();
        return view('admin.page.create', ['languages' => $languages]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PageStoreRequest $request)
    {
        $validated = $request->validated();

        $id = $request->input('edit_value');

        if($id == NULL){
            $page = Page::create([
                'for' => $validated['for'],
                'slug' => $validated['slug'],
            ]);

            $languages = Language::where('status','Active')->get();
            foreach($languages as $language){
                PageTranslation::create([
                    'name'        => $request->input($language->language_code . '_name'),
                    'description' => $request->input($language->language_code . '_description'),
                    'page_id'     => $page->id,
                    'locale'      => $language->language_code,
                ]);
            }
            return response()->json(['success' => true, 'message' => config('languageString.page_added')]);
        } else{
            Page::where('id', $id)->update([
                'for' => $validated['for'],
                'slug' => $validated['slug'],
            ]);

            $languages = Language::where('status','Active')->get();
            foreach($languages as $language){
                PageTranslation::updateOrCreate([
                    'page_id' => $id,
                    'locale'  => $language->language_code,
                ],
                    [
                        'page_id'     => $id,
                        'locale'      => $language->language_code,
                        'name'        => $request->input($language->language_code . '_name'),
                        'description' => $request->input($language->language_code . '_description'),
                    ]);
            }
            return response()->json(['success' => true, 'message' => config('languageString.page_updated')]);
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
        $page = Page::find($id);
        $languages = Language::where('status','Active')->get();
        if($page){
            return view('admin.page.edit', ['page' => $page, 'languages' => $languages]);
        } else{
            abort(404);
        }
    }

    public function pageChangeStatus($id, $status)
    {
        Page::where('id', $id)->update(['status' => $status]);
        return response()->json(['success' => true, 'message' => config('languageString.change_status_message')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Page::where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => config('languageString.page_deleted')]);
    }
}
