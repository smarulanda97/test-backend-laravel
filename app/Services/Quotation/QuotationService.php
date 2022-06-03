<?php

namespace App\Services\Quotation;

use App\Helper\Calculate;
use App\Models\Quotation;
use Carbon\Carbon;

class QuotationService implements QuotationServiceInterface
{
    /**
     * Calculate total of new quotation
     *
     * @param array $attributes
     * @return array
     */
    private function generate(array $attributes): array {
        $ages = explode(",", $attributes['age']);
        $startDate = Carbon::parse($attributes['start_date']);;
        $endDate = Carbon::parse($attributes['end_date']);

        return $attributes + [
            'user_id' => auth()->id(),
            'total' => Calculate::getQuotationTotal($ages, ($endDate->diffInDays($startDate) + 1)),
        ];
    }

    /**
     * Store a new quotation
     *
     * @param array $quotationData
     * @return Quotation|null
     */
    private function store(array $quotationData): ?Quotation {
        try {
            $quotation = new Quotation();
            $quotation->fill($quotationData);
            $quotation->save();
            return $quotation;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function generateAndStore(array $attributes): ?Quotation {
        return $this->store($this->generate($attributes));
    }
}
