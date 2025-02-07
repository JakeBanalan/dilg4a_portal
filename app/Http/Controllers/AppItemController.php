<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppItemModel;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppItemController extends Controller
{
    public function index() {}
    public function countTotalItem($cur_year)
    {
        return response()->json(AppItemModel::select(AppItemModel::raw('count(*) as item'))->whereYear('created_at', $cur_year)
            ->get());
    }
    public function generateStockNumber()
    {
        $lastItem = AppItemModel::select('sn')
            ->orderBy('id', 'DESC')
            ->first();

        // Extract number from last stock number (e.g., "S5039" -> "5039")
        if ($lastItem && preg_match('/S(\d+)/', $lastItem->sn, $matches)) {
            $newNumber = (int)$matches[1] + 1; // Increment the number
        } else {
            $newNumber = 5000; // Default starting number if no previous records
        }

        $newStockNumber = 'S' . $newNumber; // Format as "S5040"

        return response()->json(['sn' => $newStockNumber]);
    }


    public function getAppData()
    {
        return response()->json(AppItemModel::select('tbl_app.id', 'sn', 'item_title', 'app_price', 'app_year', 'item_unit.item_unit_title')
            ->join('item_unit', 'tbl_app.unit_id', '=', 'item_unit.id')
            ->where('app_year', 2022)
            ->orderBy('item_title')
            ->limit(1000)
            ->get());
    }
    public function app_category()
    {
        return response()->json(AppItemModel::select('item_category.id', 'item_category.item_category_title')
            ->join('item_category', 'item_category.id', '=', 'tbl_app.category_id')
            ->where('app_year', 2022)
            ->groupBy('item_category.id', 'item_category.item_category_title')
            ->orderBy('item_category.id')

            ->limit(1000)
            ->get());
    }
    public function fetchAppData(Request $request)
    {
        $searchValue = $request->input('searchValue', '');
        $appYear = $request->input('appYear', date('Y')); // Get the requested year, default to current year

        $app_item = AppItemModel::selectRaw('
                tbl_app.id as app_id,
                tbl_app.sn as sn,
                tbl_app.item_title as item_title,
                tbl_app.unit_id as unit_id,
                pmo.pmo_title,
                source_of_funds.source_of_funds_title,
                tbl_app.source_of_funds_id,
                tbl_app.category_id as category_id,
                tbl_app.mode as mode,
                tbl_app.app_price as price,
                tbl_app.app_year as app_year,
                item_unit.item_unit_title as item_unit_title,
                item_category.item_category_title as item_category_title,
                mode_of_proc.mode_of_proc_title as mode_of_proc_title
            ')
            ->join('source_of_funds', 'tbl_app.source_of_funds_id', '=', 'source_of_funds.id')
            ->join('pmo', 'tbl_app.pmo_id', '=', 'pmo.id')
            ->join('item_category', 'tbl_app.category_id', '=', 'item_category.id')
            ->join('mode_of_proc', 'tbl_app.mode', '=', 'mode_of_proc.id')
            ->join('item_unit', 'tbl_app.unit_id', '=', 'item_unit.id')
            ->where('tbl_app.app_year', $appYear); // Make the year dynamic

        if (!empty($searchValue)) {
            $app_item->where(function ($query) use ($searchValue) {
                $query->where('tbl_app.item_title', 'LIKE', "%{$searchValue}%")
                    ->orWhere('tbl_app.sn', 'LIKE', "%{$searchValue}%");
            });
        }

        return response()->json($app_item->get());
    }

    public function post_add_appItem(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'sn' => 'nullable|string|max:255',
            'code' => 'nullable|string|max:255',
            'merge_code' => 'nullable|string|max:255',
            'item_title' => 'nullable|string|max:255',
            'unit_id' => 'nullable|integer',
            'source_of_funds_id' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'pmo_id' => 'nullable|integer',
            'qty' => 'nullable|numeric|min:1',
            'mode' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'app_price' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // Automatically set `app_year` to the current year
        $validatedData['app_year'] = date('Y');

        try {
            // Create the new AppItem and set `new_entry` to 1
            $appItem = AppItemModel::create(array_merge($validatedData, ['new_entry' => 1]));

            return response()->json([
                'message' => 'App item added successfully!',
                'data' => $appItem
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create item',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
