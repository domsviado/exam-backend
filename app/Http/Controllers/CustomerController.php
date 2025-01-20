<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::paginate(10);

        // Return paginated resources with a custom message
        return response()->json([
            'success' => true,
            'message' => 'Customers fetched successfully.',
            'data' => CustomerResource::collection($customers),
            'pagination' => [
                'current_page' => $customers->currentPage(),
                'total_pages' => $customers->lastPage(),
                'total_items' => $customers->total(),
            ],
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Customer Created Successfully!',
            'data' => new CustomerResource($customer)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return response()->json([
            'success' => true,
            'message' => 'Customer Fetched Successfully!',
            'data' => new CustomerResource($customer)
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Customer Updated Successfully!',
            'data' => new CustomerResource($customer)
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer Deleted Successfully!',
            'data' => []
        ], 201);
    }
}
