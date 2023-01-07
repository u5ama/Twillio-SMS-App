<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\CountryStoreRequest;
use App\Models\Country;
use App\Models\CountryTranslation;
use App\Models\Language;
use Illuminate\Contracts\Foundation\App\Modelslication;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Modelslication|Factory|View
     * @throws \Exception
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $countries = Country::listsTranslations('name', 'tax_name')
                ->select('countries.id', 'countries.code', 'countries.country_code', 'countries.tax_percentage')->get();
            // dd(DB::getQueryLog());
            return Datatables::of($countries)
                ->addColumn('action', function($countries){
                    $edit_button = '<a href="' . route('admin.country.edit', [$countries->id]) . '" class="btn btn-info btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $countries->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
                    $extra_button = '<a href="#" class="driver-requirement btn btn-icon btn-secondary" data-toggle="tooltip" data-placement="top" title="' . config('languageString.extra') . '"><i class="bx bx-bullseye font-size-16 align-middle"></i></a>';
                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button . ' ' . $extra_button . '</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.country.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Http\Response|View
     */
    public function create()
    {
        $languages = Language::where('status','Active')->get();
        return view('admin.country.create', ['languages' => $languages]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CountryStoreRequest $request)
    {
        $validated = $request->validated();

        $id = $request->input('edit_value');

        if($id == NULL){
            $country_order = Country::max('id');
            $insert_id = Country::create([
                'country_code'   => $validated['country_code'],
                'code'           => $validated['code'],
                'timezone'       => $validated['timezone'],
                'country_order'  => $country_order + 1,
            ]);
            $languages = Language::where('status','Active')->get();
            foreach($languages as $language){
                CountryTranslation::create([
                    'name'       => $request->input($language->language_code . '_name'),
                    'tax_name'   => $request->input($language->language_code . '_tax_name'),
                    'country_id' => $insert_id->id,
                    'locale'     => $language->language_code,
                ]);
            }
            return response()->json(['success' => true, 'message' => config('languageString.country_added')]);
        } else{

            Country::where('id', $id)->update([
                'country_code'   => $request->input('country_code'),
                'code'           => $request->input('code'),
                'timezone'       => $request->input('timezone'),
            ]);

            $languages = Language::where('status','Active')->get();
            foreach($languages as $language){
                CountryTranslation::updateOrCreate([
                    'country_id' => $id,
                    'locale'     => $language->language_code,
                ],
                    [
                        'country_id' => $id,
                        'locale'     => $language->language_code,
                        'name'       => $request->input($language->language_code . '_name'),
                        'tax_name'   => $request->input($language->language_code . '_tax_name'),

                    ]);

            }
            return response()->json(['success' => true, 'message' => config('languageString.country_updated')]);
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
        $country = Country::find($id);
        if($country){
            $languages = Language::where('status','Active')->get();
            return view('admin.country.edit', ['country' => $country, 'languages' => $languages]);
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
        Country::where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => config('languageString.country_deleted')]);
    }
}
