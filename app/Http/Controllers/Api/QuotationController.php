<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuotationRequest;
use App\Services\Quotation\QuotationService;
use App\Services\Quotation\QuotationServiceInterface;

class QuotationController extends Controller
{
    /** @var QuotationServiceInterface $quotationService */
    protected $quotationService;

    /**
     * AuthController instance.
     *
     * @return void
     */
    public function __construct(QuotationService $quotationService) {
        $this->middleware('auth:api');
        $this->quotationService = $quotationService;
    }

    /**
     * Store a quotation
     *
     * @param StoreQuotationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreQuotationRequest $request) {
        $quotation = $this->quotationService->generateAndStore($request->validated());
        if (is_null($quotation)) {
            return response()->json([
                'error' => true,
                'message' => 'an error has occurred creating the quotation',
                'detail' => ''
            ], 500);
        }

        return response()->json([
            'total' => $quotation->getAttribute('total'),
            'currency_id' => $quotation->getAttribute('currency_id'),
            'quotation_id' => $quotation->getAttribute('id'),
        ], 201);
    }
}
