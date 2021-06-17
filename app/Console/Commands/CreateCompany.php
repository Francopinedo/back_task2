<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use GuzzleHttp\Client as GuzzleHttpClient;


class CreateCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:company 
    {companyname : The name of the company}
    {address : The address of the company}
    {phone : The phone of the company} 
    {email : The email of the company} 
    {billing_name : The billingname of the company}
    {country : The country of the company}
    {city : The city of the company}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea la compania de la aplicacion';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
         $client = new GuzzleHttpClient(['verify' => false]);
         
        $params = ['name' => $this->argument('companyname'),
            'address' => $this->argument('address'),
            'email' => $this->argument('email'),
            'phone' => $this->argument('phone'),
            'billing_name' => $this->argument('billing_name'),
            'billing_address' => $this->argument('address'),
            'roomName' => 'General',
            'user_id' => '1',

        ];

        $params = ['form_params' => $params];

        $apiRoutes = ["companies", "irmdomain", "irmmailadm", "rcadmin", "admin", "rcgeneralchannel"];
        $irmApiRoutes = ['domain', 'admin_mailbox', 'rcadmin'];
        $bar = $this->output->createProgressBar(count($apiRoutes) + count($irmApiRoutes));
        foreach ($apiRoutes as $route) {
            if($route == 'companies')
            {
                $request = $client->request('POST', env('API_PATH') . $route, $params);
                $company = json_decode($request->getBody()->__toString())->data;
                $bar->advance();
            }
            else
            {
                $client->request('POST', env('API_PATH') . $route, $params);
                $bar->advance();
            }
        }

        if (env('IREDMAIL_API_HOST')) {
            foreach ($irmApiRoutes as $route) {
                $client->request('POST', env('IREDMAIL_API_HOST') . $route, $params);
                $bar->advance();
            }
        }

        $request = $client->request('GET', env('API_PATH') . 'countries');
        $countries = json_decode($request->getBody()->__toString())->data;
        $countryName = $this->argument('country');
        $countryId = '';

        foreach ($countries as $country) {
            if ($countryName == $country->name) {
                $countryId = $country->id;
            }
        }

        $params = ['name' => $this->argument('city'),
            'location_name' => $this->argument('city'),
            'country_id' => $countryId,
            'company_id' => $company->id,
            'added_by' => 'form'
        ];
        $params = ['form_params' => $params];
        $client->request('POST', env('API_PATH') . 'cities', $params);

        $bar->finish();

        $this->line('Done!');

    }
}
