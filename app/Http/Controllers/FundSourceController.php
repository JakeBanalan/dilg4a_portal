<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FundSourceModel;
use App\Models\FundSourceEntryModel;
use App\Models\UACSModel;
use App\Models\ObjectCodeModel;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FundSourceController extends Controller
{

    public function deleteOC(Request $request)
    {
        ObjectCodeModel::where('id', $request->id)

            ->delete();

        return response()->json(['message' => 'Item deleted successfully']);
    }
    public function postFundSource(Request $request)
    {
        $postFS = new FundSourceModel([
            'source' => $request->source,
            'ppa' => $request->ppa,
            'date_created' => $request->date_created,
            'name' => $request->name,
            'particulars' => $request->particulars,
            'legal_basis' => $request->legal_basis
        ]);
        $postFS->save();
        return response()->json($postFS);
    }
    public function fetchFundSources()
    {
        $data = FundSourceModel::select(
            'tbl_fundsource.id',
            'tbl_fundsource.source as code',
            'tbl_fundsource.name as fund_name',
            'tbl_fundsource.ppa',
            'tbl_fundsource.legal_basis',
            'tbl_fundsource.particulars',
            DB::raw('SUM(fse.allotment_amount) as total_allotment_amount'),
            DB::raw('SUM(fse.obligated_amount) as total_allotment_obligated'),
            DB::raw('SUM(fse.balance) as total_balance'),
            DB::raw("DATE_FORMAT(tbl_fundsource.date_created, '%m/%d/%Y') as date_created"),
            'tbl_fundsource.is_lock'
        )
            ->leftJoin('tbl_fundsource_entry as fse', 'fse.source_id', '=', 'tbl_fundsource.id')
            ->groupBy(
                'tbl_fundsource.id',
                'tbl_fundsource.source',
                'tbl_fundsource.name',
                'tbl_fundsource.ppa',
                'tbl_fundsource.legal_basis',
                'tbl_fundsource.particulars',
                'tbl_fundsource.date_created',
                'tbl_fundsource.is_lock'
            )
            ->get();
        return response()->json($data);
    }
    public function fetchFundSourcesData($id)
    {
        $data = FundSourceModel::select(
            'tbl_fundsource.id',
            'tbl_fundsource.source as code',
            'tbl_fundsource.name as fund_name',
            'tbl_fundsource.ppa',
            'tbl_fundsource.legal_basis',
            'tbl_fundsource.particulars',
            DB::raw('SUM(fse.allotment_amount) as total_allotment_amount'),
            DB::raw('SUM(fse.obligated_amount) as total_allotment_obligated'),
            DB::raw('SUM(fse.balance) as total_balance'),
            DB::raw("DATE_FORMAT(tbl_fundsource.date_created, '%m/%d/%Y') as date_created"),
            'tbl_fundsource.is_lock'
        )
            ->leftJoin('tbl_fundsource_entry as fse', 'fse.source_id', '=', 'tbl_fundsource.id')
            ->where('tbl_fundsource.id', $id)
            ->groupBy(
                'tbl_fundsource.id',
                'tbl_fundsource.source',
                'tbl_fundsource.name',
                'tbl_fundsource.ppa',
                'tbl_fundsource.legal_basis',
                'tbl_fundsource.particulars',
                'tbl_fundsource.date_created',
                'tbl_fundsource.is_lock'
            )
            ->get();
        return response()->json($data);
    }

    public function fetchFundSourceEntryData($id)
    {
        $data = FundSourceEntryModel::select(
            'tbl_fundsource_entry.id',
            'tbl_fundsource_entry.expense_class',
            'tbl_fundsource_entry.uacs',
            'tbl_fundsource_entry.allotment_amount',
            'tbl_fundsource_entry.obligated_amount',
            'tbl_fundsource_entry.balance',
            'tbl_fundsource_entry.uacs',
            DB::raw('CASE WHEN MAX(oe.id) IS NOT NULL THEN TRUE ELSE FALSE END as is_used'),
            'tbl_fundsource_entry.is_lock'
        )
            ->leftJoin('tbl_fundsource as fs', 'fs.id', '=', 'tbl_fundsource_entry.source_id')
            ->leftJoin('tbl_obentries as oe', 'oe.uacs', '=', 'tbl_fundsource_entry.id')
            ->leftJoin('tbl_object_codes as oc', 'oc.id', '=', 'tbl_fundsource_entry.uacs')
            ->where('fs.id', $id)
            ->groupBy('tbl_fundsource_entry.id')
            ->get();

        return response()->json($data);
    }

    public function fetchUACS()
    {
        return response()->json(
            UACSModel::all()
        );
    }

    public function fetchObjectCode()
    {
        return response()->json(
            ObjectCodeModel::all()
        );
    }
}
