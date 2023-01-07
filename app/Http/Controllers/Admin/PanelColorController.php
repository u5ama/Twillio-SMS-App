<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\PanelColorStoreRequest;
use App\Models\PanelColor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PanelColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\App\Modelslication|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $panelColor = PanelColor::query();
            return Datatables::of($panelColor)
                ->addColumn('action', function($panelColor){
                    $edit_button = '<a href="' . route('admin.panel-color.edit', [$panelColor->id]) . '" class="btn btn-info btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $panelColor->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button . '</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.panelColor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\App\Modelslication|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.panelColor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PanelColorStoreRequest $request)
    {
        $id = $request->input('edit_value');

        $validated = $request->validated();

        if($id == NULL){
            PanelColor::create([
                'color_key_field' => $validated['color_key_field'],
                'color_key_value' => $validated['color_key_value'],
                'color_code'      => $validated['color_code'],
                'theme'           => $validated['theme'],
            ]);

            return response()->json(['success' => true, 'message' => config('languageString.panel_color_added')]);
        } else{
            PanelColor::where('id', $id)->update([
                'color_key_field' => $validated['color_key_field'],
                'color_key_value' => $validated['color_key_value'],
                'color_code'      => $validated['color_code'],
                'theme'           => $validated['theme'],
            ]);
            return response()->json(['success' => true, 'message' => config('languageString.panel_color_updated')]);
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
        $panelColor = PanelColor::find($id);
        if($panelColor){
            return view('admin.panelColor.edit', ['panelColor' => $panelColor]);
        } else{
            abort(404);
        }
    }

    public function panelColorChangeStatus($id, $status)
    {
        PanelColor::where('id', $id)->update(['status' => $status]);
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
        PanelColor::where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => config('languageString.panel_color_deleted')]);
    }
}
