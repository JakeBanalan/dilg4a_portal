<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\AppItemModel;
use Illuminate\Http\Request;
use App\Events\AppItemApproved;
use App\Events\AppItemRejected;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppItemController extends Controller
{
    public function countTotalItem($cur_year)
    {
        return response()->json(AppItemModel::select(AppItemModel::raw('count(*) as item'))->whereYear('created_at', $cur_year)
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
        $appYear = $request->input('appYear', date('Y'));
        $userId = $request->input('userId');

        $user = UserModel::find($userId);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $query = AppItemModel::selectRaw('
        tbl_app.id as app_id,
        tbl_app.sn as sn,
        tbl_app.item_title as item_title,
        tbl_app.unit_id as unit_id,
        tbl_app.app_status,
        tbl_app.category_id as category_id,
        tbl_app.app_year as app_year,
        item_unit.item_unit_title as item_unit_title,
        item_category.item_category_title as item_category_title,
        mode_of_proc.mode_of_proc_title as mode_of_proc_title
    ')
            ->from('tbl_app')
            ->leftJoin('item_category', 'tbl_app.category_id', '=', 'item_category.id')
            ->leftJoin('mode_of_proc', 'tbl_app.mode', '=', 'mode_of_proc.id')
            ->leftJoin('item_unit', 'tbl_app.unit_id', '=', 'item_unit.id');


        if ($user->user_role !== 'gss_admin') {
            $query->where('tbl_app.pmo_id', $user->pmo_id);
        }
        if (!empty($appYear)) {
            $query->where('tbl_app.app_year', $appYear);
        }
        if (!empty($searchValue)) {
            $query->where(function ($q) use ($searchValue) {
                $q->where('tbl_app.item_title', 'LIKE', "%{$searchValue}%")
                    ->orWhere('tbl_app.sn', 'LIKE', "%{$searchValue}%");
            });
        }

        $query->orderByRaw("FIELD(tbl_app.app_status, 'approve', 'for approval') DESC")
            ->orderBy('tbl_app.id', 'DESC');

        return response()->json($query->get());
    }




    public function fetchAppDataById(Request $request)
    {
        $appId = $request->input('appId');

        $app_item = AppItemModel::selectRaw('
            tbl_app.id as app_id,
            tbl_app.sn as sn,
            tbl_app.item_title as item_title,
            tbl_app.unit_id as unit_id,
            tbl_app.category_id as category_id,
            tbl_app.app_year as app_year,
            item_unit.item_unit_title as item_unit_title,
            item_category.item_category_title as item_category_title,
            mode_of_proc.mode_of_proc_title as mode_of_proc_title
        ')
            ->leftJoin('item_category', 'tbl_app.category_id', '=', 'item_category.id')
            ->leftJoin('mode_of_proc', 'tbl_app.mode', '=', 'mode_of_proc.id')
            ->leftJoin('item_unit', 'tbl_app.unit_id', '=', 'item_unit.id')
            ->where('tbl_app.id', $appId);

        return response()->json($app_item->first());
    }

    public function post_add_appItem(Request $request)
    {
        $validated = $request->validate([
            'item_title' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s]+$/'
            ],
            'unit_id' => 'required|integer',
            'category_id' => 'required|integer',
            'app_year' => 'required|integer',
            'created_by' => 'required|integer|exists:users,id', // Validate created_by as user id
        ]);

        $normalizedTitle = strtolower(trim($validated['item_title']));

        $existing = AppItemModel::whereRaw('LOWER(TRIM(item_title)) LIKE ?', ["%{$normalizedTitle}%"])
            ->first();

        if ($existing) {
            return response()->json(['message' => 'Duplicated Item Title.'], 422);
        }

        try {
            // Fetch user to get pmo_id
            $user = UserModel::find($validated['created_by']);
            if (!$user) {
                return response()->json(['message' => 'User not found.'], 404);
            }

            // Save item
            $appItem = new AppItemModel();
            $appItem->item_title = trim($validated['item_title']);
            $appItem->unit_id = $validated['unit_id'];
            $appItem->category_id = $validated['category_id'];
            $appItem->app_year = $validated['app_year'];
            $appItem->app_status = 'for approval';
            $appItem->created_by = $validated['created_by']; // Save created_by
            $appItem->pmo_id = $user->pmo_id; // Still save pmo_id for PMO association

            $appItem->save();

            return response()->json(['message' => 'Item added successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to save item.',
                'details' => $e->getMessage()
            ], 500);
        }
    }




    public function post_update_appItem(Request $request, $id)
    {
        try {

            $validatedData = $request->validate([
                'item_title' => 'nullable|string|max:255',
                'unit_id' => 'nullable|integer',
                'category_id' => 'nullable|integer',
            ]);


            $appItem = AppItemModel::findOrFail($id);


            $appItem->fill($validatedData);


            if (!$appItem->isDirty()) {
                return response()->json([
                    'message' => 'No changes detected.'
                ], 200);
            }
            $appItem->saveOrFail();

            return response()->json([
                'message' => 'App item updated successfully!',
                'data' => $appItem
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'App item not found',
                'message' => 'App item with ID ' . $id . ' does not exist'
            ], 404);
        } catch (\Throwable $e) {

            return response()->json([
                'error' => 'Failed to update App item',
                'message' => 'An unexpected error occurred. Please try again later.'
            ], 500);
        }
    }

    public function approveAppItem(Request $request, $id)
    {
        $validated = $request->validate([
            'sn' => 'required|string|max:255',
            'mode' => 'required|string|max:255',
        ]);

        try {
            $appItem = AppItemModel::findOrFail($id);
            if ($appItem->sn === $validated['sn'] && $appItem->app_status === 'approve') {
                return response()->json(['message' => 'Item is already approved.'], 200);
            }
            $appItem->update([
                'sn' => $validated['sn'],
                'app_status' => 'approve',
                'mode' => $validated['mode'] ?? '7', // Default to 'Not Applicable'
            ]);

            event(new AppItemApproved($appItem, $appItem->created_by));

            return response()->json(['message' => 'Item approved successfully.']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Item not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to approve item.', 'details' => $e->getMessage()], 500);
        }
    }

    public function deleteAppItem($id)
    {
        try {
            $appItem = AppItemModel::findOrFail($id);
            $createdBy = $appItem->created_by;
            $appItem->delete();

            event(new AppItemRejected($appItem, $createdBy));

            return response()->json(['message' => 'Item rejected and deleted successfully.'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Item not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete item.', 'details' => $e->getMessage()], 500);
        }
    }
}
