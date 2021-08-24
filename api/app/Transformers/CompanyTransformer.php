<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Company;
use App\Industry;
use App\City;
use App\Currency;

class CompanyTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'country', 'industry', 'city', 'currency'
    ];

    public function transform(Company $company)
    {
        return [
            'id' => $company->id,
            'name' => $company->name,
            'address' => $company->address,
            'country_id' => $company->country_id,
            'city_id' => $company->city_id,
            'email' => $company->email,
            'phone' => $company->phone,
            'billing_name' => $company->billing_name,
            'billing_address' => $company->billing_address,
            'tax_number1' => $company->tax_number1,
            'bank_name' => $company->bank_name,
            'account_number' => $company->account_number,
            'swiftcode' => $company->swiftcode,
            'aba' => $company->aba,
            'currency_id' => $company->currency_id,
            'industry_id' => $company->industry_id,
            'user_id' => $company->user_id,
            'logo_path' => $company->logo_path,
            'domain' => $company->Domain,
            'rocketchatusers' => $company->RocketChatUsers,
        ];
    }

    public function includeIndustry(Company $company)
    {
        if (empty($company->industry)) {
            $industry = new Industry();
        } else {
            $industry = $company->industry;
        }

        return $this->item($industry, new IndustryTransformer);
    }

    public function includeCity(Company $company)
    {
        if (empty($company->city)) {
            $city = new City();
        } else {
            $city = $company->city;
        }

        return $this->item($city, new CityTransformer);
    }

    public function includeCurrency(Company $company)
    {
        if (empty($company->currency)) {
            $currency = new Currency();
        } else {
            $currency = $company->currency;
        }

        return $this->item($currency, new CurrencyTransformer);
    }
}
