<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Customer;
use App\Industry;
use App\City;
use App\Country;
use App\Currency;
use App\Models\Project;

class CustomerTransformer extends TransformerAbstract
{

	/**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'industry', 'country', 'city', 'currency', 'projects'
    ];

    public function transform(Customer $customer)
    {
        return [
			'id'              => $customer->id,
			'company_id'      => $customer->company_id,
			'name'            => $customer->name,
			'address'         => $customer->address,
            'country_id'      => $customer->country_id,
			'city_id'         => $customer->city_id,
			'email'           => $customer->email,
			'phone'           => $customer->phone,
			'billing_name'    => $customer->billing_name,
			'billing_address' => $customer->billing_address,
			'tax_number1'      => $customer->tax_number1,
			'bank_name'       => $customer->bank_name,
			'account_number'  => $customer->account_number,
			'swiftcode'       => $customer->swiftcode,
			'aba'             => $customer->aba,
			'currency_id'     => $customer->currency_id,
			'industry_id'     => $customer->industry_id,
			'logo_path'     => $customer->logo_path,
        ];
    }

    public function includeIndustry(Customer $customer)
    {
    	if (empty($customer->industry))
    	{
    		$industry = new Industry();
    	}
    	else{
    		$industry = $customer->industry;
    	}

        return $this->item($industry, new IndustryTransformer);
    }

    public function includeCountry(Customer $customer)
    {
        if (empty($customer->country))
        {
            $country = new Country();
        }
        else{
            $country = $customer->country;
        }

        return $this->item($country, new CountryTransformer);
    }

    public function includeCity(Customer $customer)
    {
    	if (empty($customer->city))
    	{
    		$city = new City();
    	}
    	else{
    		$city = $customer->city;
    	}

        return $this->item($city, new CityTransformer);
    }

    public function includeCurrency(Customer $customer)
    {
    	if (empty($customer->currency))
    	{
    		$currency = new Currency();
    	}
    	else{
    		$currency = $customer->currency;
    	}

        return $this->item($currency, new CurrencyTransformer);
    }

    public function includeProjects(Customer $customer)
    {
    	if (empty($customer->Projects))
    	{
    		$projects = new Project();
    	}
    	else{
    		$projects = $customer->projects;
    	}

        return $this->collection($projects, new ProjectTransformer);
    }
}
