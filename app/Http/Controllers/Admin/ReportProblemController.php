<?php

namespace App\Http\Controllers\Admin;

use App\Models\ReportProblem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ReportProblemController extends Controller
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
            $report_problems = ReportProblem::with('user')->select('report_problems.*');
            // dd(DB::getQueryLog());
            return Datatables::of($report_problems)
                ->addColumn('action', function($report_problems){
                    $view_detail_button = '<button data-id="' . $report_problems->id . '" class="report-problem-details btn btn-secondary btn-icon" data-effect="effect-fall" data-toggle="tooltip" data-placement="top" title="' . config('languageString.view_details') . '"><i class="bx bx-bullseye font-size-16 align-middle"></i></button>';
                    $delete_button = '<button data-id="' . $report_problems->id . '" class="delete-single btn btn-danger btn-icon" data-toggle="tooltip" data-placement="top" title="' . config('languageString.delete') . '"><i class="bx bx-trash font-size-16 align-middle"></i></button>';
                    return '<div class="btn-icon-list">' . $view_detail_button . ' ' . $delete_button . '</div>';
                })
                ->addColumn('name', function($report_problems){
                    return $report_problems->user->name;
                })
                ->addColumn('creation_time', function ($users) {
                    return date('d-m-Y H:i:s', strtotime($users->created_at));
                })
                ->addColumn('message',function($report_problems){
                    return implode(PHP_EOL, str_split($report_problems->message, 30));
                   })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.reportProblem.index');
    }

    public function destroy($id)
    {
        ReportProblem::where('id', $id)->delete();

        return response()->json(['success' => true, 'message' => config('languageString.report_problem_deleted')]);
    }

    public function show($id)
    {
        ReportProblem::where('id', $id)->update([
            'is_seen' => 1,
        ]);

        $report_problem = ReportProblem::with('user')
            ->where('id', $id)
            ->first();

        if($report_problem){

            $array['globalModalDetails'] = '<table class="table table-bordered">';
            $array['globalModalDetails'] .= '<tr>';
            $array['globalModalDetails'] .= '<td>' . config('languageString.message') . '</td>';
            $array['globalModalDetails'] .= '<td>' .implode(PHP_EOL, str_split($report_problem->message, 60))  . '</td>';
            $array['globalModalDetails'] .= '</tr>';
            $array['globalModalDetails'] .= '<tr>';
            $array['globalModalDetails'] .= '<td>' . config('languageString.image') . '</td>';
            $array['globalModalDetails'] .= '<td><img src="' . asset($report_problem->image) . '" width="640px" height="450px"/></td>';
            $array['globalModalDetails'] .= '</tr>';

            $array['globalModalDetails'] .= '</table>';

        } else{
                $array['globalModalDetails'] = config('languageString.error');
        }

        return response()->json(['success' => true, 'data' => $array]);

    }
}
