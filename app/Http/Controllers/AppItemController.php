<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppItemModel;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppItemController extends Controller
{
    public function index()
    {
    }
    public function countTotalItem($cur_year)
    {
        return response()->json(AppItemModel::select(AppItemModel::raw('count(*) as item'))->whereYear('created_at', $cur_year)
            ->get());
    }
    public function generateStockNumber()
    {
        return response()->json(AppItemModel::select(AppItemModel::raw('id,sn,YEAR(pr_date) as pr_date'))
            ->limit(1)
            ->orderby('id', 'DESC')
            ->get());
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
        return response()->json(AppItemModel::select('item_category.id','item_category.item_category_title')
        ->join('item_category', 'item_category.id', '=', 'tbl_app.category_id')
        ->where('app_year', 2022)
        ->groupBy('item_category.id','item_category.item_category_title')
        ->orderBy('item_category.id')

        ->limit(1000)
        ->get());
    }
    public function fetchAppData()
    {
        // return response()->json(AppItemModel::all());
        $app_item = AppItemModel::select(AppItemModel::raw('
            tbl_app.id as `app_id`,
            tbl_app.sn as `sn`,
            tbl_app.item_title as `item_title`,
            tbl_app.unit_id as `unit_id`,
            pmo.pmo_title,
            source_of_funds.source_of_funds_title,
            tbl_app.source_of_funds_id,
            tbl_app.category_id as `category_id`,
            tbl_app.mode as `mode`,
            tbl_app.app_price as `price`,
            tbl_app.app_year as `app_year`,
            item_unit.item_unit_title as  `item_unit_title`,
            item_category.item_category_title as `item_category_title`,
            mode_of_proc.mode_of_proc_title as `mode_of_proc_title`

        '))
            ->join('source_of_funds', 'tbl_app.source_of_funds_id', '=', 'source_of_funds.id')
            ->join('pmo', 'tbl_app.pmo_id', '=', 'pmo.id')
            ->join('item_category', 'tbl_app.category_id', '=', 'item_category.id')
            ->join('mode_of_proc', 'tbl_app.mode', '=', 'mode_of_proc.id')
            ->join('item_unit', 'tbl_app.unit_id', '=', 'item_unit.id')
            ->where('tbl_app.app_year',2024);
        // Print the SQL query
        // $sql = $app_item->toSql();
        // dd($sql);

        // // Execute the query and return the result
        $appItems = $app_item->get();

        return response()->json($appItems);
    }
    public function post_add_appItem(Request $request)
    {

        $app_item = new AppItemModel([
            'id'            => $request->input('id'),
            'sn'            => $request->input('sn'),
            'code'          => $request->input('code'),
            'item_title'    => $request->input('item_title'),
            'unit_id'       => $request->input('unit'),
            'source_of_funds_id' => $request->input('source_of_funds_id'),
            'category_id'   => $request->input('category_id'),
            'pmo_id'        => $request->input('office'),
            'qty'      => $request->input('qty'),
            'mode'          => $request->input('mode'),
            'price'         => $request->input('app_price'),
            'app_price'     => $request->input('app_price'),

        ]);
        $app_item->save();
    }
    public function post_complete_ta()
    {
        echo 'a';
    }
}
