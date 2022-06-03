<?php

namespace App\Services\Quotation;

use App\Models\Quotation;

interface QuotationServiceInterface
{
    /**
     * Generate a quotation and store its data in the database
     *
     * @param array $attributes
     * @return Quotation|null
     */
    public function generateAndStore(array $attributes): ?Quotation;
}
