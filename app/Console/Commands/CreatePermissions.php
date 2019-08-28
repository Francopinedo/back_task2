<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use jeremykenedy\LaravelRoles\Models\Permission;

class CreatePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea los permisos para el sistema';

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
    	// My Company
        Permission::create(['name' => 'View My Company', 'slug' => 'view.mycompany']);
        Permission::create(['name' => 'Manage My Company', 'slug' => 'manage.mycompany']);

        // Emails
        Permission::create(['name' => 'View Emails', 'slug' => 'view.emails']);
        Permission::create(['name' => 'Manage Emails', 'slug' => 'manage.emails']);

        // Customers
        Permission::create(['name' => 'View Customers', 'slug' => 'view.customers']);
        Permission::create(['name' => 'Manage Customers', 'slug' => 'manage.customers']);

        // Costs
        Permission::create(['name' => 'View Costs', 'slug' => 'view.costs']);
        Permission::create(['name' => 'Manage Costs', 'slug' => 'manage.costs']);

        // Company Rates
        Permission::create(['name' => 'View Company Rates', 'slug' => 'view.companyrates']);
        Permission::create(['name' => 'Manage Company Rates', 'slug' => 'manage.companyrates']);
    }
}
