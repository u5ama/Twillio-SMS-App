<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\SocialLinkStoreRequest;
use App\Models\SocialLink;
use App\Helpers\ImageUploadHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SocialLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\App\Modelslication|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $socialLink = SocialLink::query();
            return Datatables::of($socialLink)
                ->addColumn('status', function($socialLink){
                    if($socialLink->status == 'Active'){
                        $status = '<span class=" badge badge-success">' . config('languageString.active') . '</span>';
                    } else{
                        $status = '<span  class=" badge badge-danger">' . config('languageString.inactive') . '</span>';
                    }
                    return $status;
                })
                ->addColumn('icon', function($socialLink){
                    $url = asset($socialLink->icon);
                    return "<img src='" . $url . "' style='width:50px' />";
                })
                ->addColumn('action', function($socialLink){
                    $edit_button = '<a href="' . route('admin.social-link.edit', [$socialLink->id]) . '" class="btn btn-info btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.edit') . '"><i class="bx bx-pencil font-size-16 align-middle"></i></a>';
                    $delete_button = '<button data-id="' . $socialLink->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
                    $status = 'Active';

                    if($socialLink->status == 'Active'){
                        $status = 'InActive';

                    }
                    $status_button = '<button data-id="' . $socialLink->id . '" data-status="' . $status . '"
                     class="status-change btn btn-warning btn-icon" data-effect="effect-fall"
                      data-toggle="tooltip" data-placement="top" title="' . $status . '">
                      <i class="bx bx-refresh font-size-16 align-middle"></i>
                      </button>';

                    return '<div class="btn-icon-list">' . $edit_button . ' ' . $delete_button . '  ' . $status_button . '</div>';
                })
                ->rawColumns(['action', 'status', 'icon'])
                ->make(true);
        }
        return view('admin.socialLink.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\App\Modelslication|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.socialLink.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SocialLinkStoreRequest $request)
    {
        $id = $request->input('edit_value');

        $validated = $request->validated();

        if($id == NULL){
            $icon = '';
            if($request->hasFile('icon')){
                $files = $request->file('icon');
                $icon = ImageUploadHelper::imageUpload($files);
            }
            SocialLink::create([
                'title'      => $validated['title'],
                'social_key' => $validated['social_key'],
                'url'        => $validated['url'],
                'icon'       => $icon,
            ]);

            return response()->json(['success' => true, 'message' => config('languageString.social_link_added')]);
        } else{

            $get_images = SocialLink::where('id', $id)->first();

            $icon = $get_images->icon;
            if($request->hasFile('icon')){
                $files = $request->file('icon');
                $icon = ImageUploadHelper::imageUpload($files);
            }

            SocialLink::where('id', $id)->update([
                'title'      => $validated['title'],
                'social_key' => $validated['social_key'],
                'url'        => $validated['url'],
                'icon'       => $icon,
            ]);
            return response()->json(['success' => true, 'message' => config('languageString.social_link_updated')]);
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
        $socialLink = SocialLink::find($id);
        if($socialLink){
            return view('admin.socialLink.edit', ['socialLink' => $socialLink]);
        } else{
            abort(404);
        }
    }

    public function socialLinkChangeStatus($id, $status)
    {
        SocialLink::where('id', $id)->update(['status' => $status]);
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
        SocialLink::where('id', $id)->delete();
        return response()->json(['success' => true, 'message' => config('languageString.social_link_deleted')]);
    }
}
