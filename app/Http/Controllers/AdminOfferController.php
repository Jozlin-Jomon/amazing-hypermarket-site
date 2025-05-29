<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use App\Models\Offer;

class AdminOfferController extends Controller
{
    /*
    View Offers List
    Created On: 22-05-2025
    */
    public function index(Request $request){

        $query = Offer::query();

        // Exclude soft-deleted (status = 2)
        $query->where('status', '!=', 2);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        }

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['1', '0'])) {
            $query->where('status', $request->status);
        }


        // Order by created_at and apply pagination
        $offers = $query->orderBy('created_at', 'desc')->paginate(10)->appends($request->query());

        if ($request->ajax()) {
            return view('admin.offer.partials.table', compact('offers'))->render();
        }

        return view('admin.offer.index', compact('offers'));
    }

    /*
    Store: Offer
    Created On: 22-05-2025
    */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'discount_type'     => 'required|in:' . implode(',', array_keys(config('enums.discount_types'))),
            'offer_scope'       => 'required|in:' . implode(',', array_keys(config('enums.offer_scopes'))),
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',
            'discount_value' => [
                Rule::requiredIf(in_array($request->discount_type, ['percentage', 'fixed'])),
                'nullable',
                'numeric',
                'min:0'
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = [
            'offer_code'        => 'OFR' . str_pad(Offer::max('offer_id') + 1, 4, '0', STR_PAD_LEFT),
            'title'             => $request->title,
            'description'       => $request->description,
            'discount_type'     => $request->discount_type,
            'discount_value'    => in_array($request->discount_type, ['percentage', 'fixed']) ? $request->discount_value : null,
            'offer_scope'       => $request->offer_scope,
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
            'status'            => 1,
        ];

        $offer = Offer::create($data);

        return response()->json([
            'message' => 'Offer created successfully!',
            'offer' => $offer,
        ], 201);
    }

    /*
    Update: Offer status
    Created On: 22-05-2025
    */
    public function updateStatus(Request $request, Offer $offer){
        $validated = $request->validate([
            'status' => 'required|in:0,1',
        ]);
        try{
            $offer->status = $validated['status'];
            $offer->save();
            return redirect()->back()->with('success', 'Offer status updated successfully.');
        }catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update offer status.');
        }
        
    }

    /*
    Delete: Offer
    Created On: 23-05-2025
    */
    public function destroy($offerId){
        $offer = Offer::find($offerId);
        if (!$offer) {
            return response()->json(['error' => 'Offer not found'], 404);
        }
        $offer->status = 2;
        $offer->save();
        return response()->json(['success' => 'Offer removed successfully']);
    }

    /*
    Bulk Delete: Offer
    Created On: 23-05-2025
    */
    public function bulkDelete(Request $request)
    {
        $offerIds = $request->input('offerIds');
        if (is_array($offerIds) && !empty($offerIds)) {
            Offer::whereIn('offer_id', $offerIds)->update(['status' => 2]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    /*
    Update: Offer
    Created On: 27-05-2025
    */
    public function update(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);
        $validatedData = $request->validate([
            'title'         => 'required|string|max:255',
            'offer_scope'   => 'required|string|max:255',
            'description'   => 'nullable|integer|exists:categories,category_id',
            'discount_type' => '',
            'discount_value'=> '',
            'start_date'    => 'required|integer',
            'end_date'      => '',
        ]);

        $offer->title           = $validatedData['title'];
        $offer->description     = $validatedData['description'];
        $offer->discount_type   = $validatedData['discount_type'];
        $offer->discount_value  = $validatedData['discount_value'];
        $offer->start_date      = $validatedData['start_date'];
        $offer->end_date        = $validatedData['end_date'];
        $offer->offer_scope     = $validatedData['offer_scope'];

        
        $offer->save();

        return response()->json($offer->fresh());
    }
}
