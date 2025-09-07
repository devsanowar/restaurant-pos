<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RestaurantBranch;
use Illuminate\Http\Request;

class RestaurantBranchController extends Controller
{
    public function index()
    {
        $restaurants = RestaurantBranch::all();
        return view('admin.layouts.pages.restaurants.index', compact('restaurants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'restaurant_branch_name' => 'required|string',
            'status' => 'required|in:1,0',
        ]);

        $restaurant = RestaurantBranch::create([
            'restaurant_branch_name' => $request->restaurant_branch_name,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Restaurant added successfully.',
            'data' => $restaurant,
        ]);
    }

    public function edit($id)
    {
        $branch = RestaurantBranch::findOrFail($id);
        return response()->json($branch);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'restaurant_branch_name' => 'required|string',
            'status' => 'required|in:1,0',
        ]);

        $restaurant = RestaurantBranch::findOrFail($id);
        $restaurant->update([
            'restaurant_branch_name' => $request->restaurant_branch_name,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Restaurant updated successfully.',
            'data' => $restaurant,
        ]);
    }


    public function destroy($id)
    {
        $restaurantBranch = RestaurantBranch::findOrfail($id);
        if (!$restaurantBranch) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No restaurant Found',
                ],
                404,
            );
        }
        $restaurantBranch->delete();


        return response()->json([
            'status' => 'success',
            'message' => 'Restaurant deleted successfully.',

        ]);
    }


}
