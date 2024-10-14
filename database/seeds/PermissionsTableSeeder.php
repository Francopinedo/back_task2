<?php

use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        /**
         * Add Permissions
         *
         */
        if (Permission::where('name', '=', 'Can View Users')->first() === null) {
            Permission::create([
                'name' => 'Can View Users',
                'slug' => 'view.users',
                'description' => 'Can view users',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'Can Create Users')->first() === null) {
            Permission::create([
                'name' => 'Can Create Users',
                'slug' => 'create.users',
                'description' => 'Can create new users',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'Can Edit Users')->first() === null) {
            Permission::create([
                'name' => 'Can Edit Users',
                'slug' => 'edit.users',
                'description' => 'Can edit users',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'Can Delete Users')->first() === null) {
            Permission::create([
                'name' => 'Can Delete Users',
                'slug' => 'delete.users',
                'description' => 'Can delete users',
                'model' => 'Permission',
            ]);
        }
        if (Permission::where('name', '=', 'View My Company')->first() === null) {
            Permission::create([
                'name' => 'View My Company',
                'slug' => 'view.mycompany',
                'description' => 'View My Company',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'Manage My Company')->first() === null) {
            Permission::create([
                'name' => 'Manage My Company',
                'slug' => 'manage.mycompany',
                'description' => 'Manage My Company',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'View Emails')->first() === null) {
            Permission::create([
                'name' => 'View Emails',
                'slug' => 'view.emails',
                'description' => 'View Emails',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'Manage Emails')->first() === null) {
            Permission::create([
                'name' => 'Manage Emails',
                'slug' => 'manage.emails',
                'description' => 'Manage Emails',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'View Customers')->first() === null) {
            Permission::create([
                'name' => 'View Customers',
                'slug' => 'view.customers',
                'description' => 'View Customers',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'Manage Customers')->first() === null) {
            Permission::create([
                'name' => 'Manage Customers',
                'slug' => 'manage.customers',
                'description' => 'Manage Customers',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'View Costs')->first() === null) {
            Permission::create([
                'name' => 'View Costs',
                'slug' => 'view.costs',
                'description' => 'MaView Costs',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'Manage Costs')->first() === null) {
            Permission::create([
                'name' => 'Manage Costs',
                'slug' => 'manage.costs',
                'description' => 'Manage Costss',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'View Company Rates')->first() === null) {
            Permission::create([
                'name' => 'View Company Rates',
                'slug' => 'view.companyrates',
                'description' => 'View Company Rates',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'Manage Company Rates')->first() === null) {
            Permission::create([
                'name' => 'Manage Company Rates',
                'slug' => 'manage.companyrates',
                'description' => 'Manage Company Ratess',
                'model' => 'Permission',
            ]);
        }


        if (Permission::where('name', '=', 'View Projects')->first() === null) {
            Permission::create([
                'name' => 'View Projects',
                'slug' => 'view.projects',
                'description' => 'View Projects',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'View requirements')->first() === null) {
            Permission::create([
                'name' => 'View requirements',
                'slug' => 'view.requirements',
                'description' => 'View requirements',
                'model' => 'Permission',
            ]);
        }
        if (Permission::where('name', '=', 'View providers')->first() === null) {
            Permission::create([
                'name' => 'View providers',
                'slug' => 'view.providers',
                'description' => 'View providers',
                'model' => 'Permission',
            ]);
        }
        if (Permission::where('name', '=', 'View stakeholders')->first() === null) {
            Permission::create([
                'name' => 'View stakeholders',
                'slug' => 'view.stakeholders',
                'description' => 'View stakeholders',
                'model' => 'Permission',
            ]);
        }
        if (Permission::where('name', '=', 'View contracts')->first() === null) {
            Permission::create([
                'name' => 'View contracts',
                'slug' => 'view.contracts',
                'description' => 'View contracts',
                'model' => 'Permission',
            ]);
        }
        if (Permission::where('name', '=', 'View members')->first() === null) {
            Permission::create([
                'name' => 'View members',
                'slug' => 'view.members',
                'description' => 'View members',
                'model' => 'Permission',
            ]);
        }
        if (Permission::where('name', '=', 'View capacity planning')->first() === null) {
            Permission::create([
                'name' => 'View capacity planning',
                'slug' => 'view.capacity_planning',
                'description' => 'View capacity planning',
                'model' => 'Permission',
            ]);
        }
        if (Permission::where('name', '=', 'View working hours')->first() === null) {
            Permission::create([
                'name' => 'View working hours',
                'slug' => 'view.working_hours',
                'description' => 'View working hours',
                'model' => 'Permission',
            ]);
        }
        if (Permission::where('name', '=', 'View absences')->first() === null) {
            Permission::create([
                'name' => 'View absences',
                'slug' => 'view.absences',
                'description' => 'View absences',
                'model' => 'Permission',
            ]);
        }
        if (Permission::where('name', '=', 'View replacements')->first() === null) {
            Permission::create([
                'name' => 'View replacements',
                'slug' => 'view.replacements',
                'description' => 'View replacements',
                'model' => 'Permission',
            ]);
        }
        if (Permission::where('name', '=', 'View additional hours')->first() === null) {
            Permission::create([
                'name' => 'View additional hours',
                'slug' => 'view.additional_hours',
                'description' => 'View additional hours',
                'model' => 'Permission',
            ]);
        }
        if (Permission::where('name', '=', 'View task status report')->first() === null) {
            Permission::create([
                'name' => 'View task status report',
                'slug' => 'view.task_status_report',
                'description' => 'View task status report',
                'model' => 'Permission',
            ]);
        }
        if (Permission::where('name', '=', 'View project risk report')->first() === null) {
            Permission::create([
                'name' => 'View project risk report',
                'slug' => 'view.project_risk_report',
                'description' => 'View project risk report',
                'model' => 'Permission',
            ]);
        }
        if (Permission::where('name', '=', 'View project board gantt')->first() === null) {
            Permission::create([
                'name' => 'View project board gantt',
                'slug' => 'view.project_board_gantt',
                'description' => 'View project board gantt',
                'model' => 'Permission',
            ]);
        }
        if (Permission::where('name', '=', 'View forecast')->first() === null) {
            Permission::create([
                'name' => 'View forecast',
                'slug' => 'view.forecast',
                'description' => 'View forecast',
                'model' => 'Permission',
            ]);
        }
        if (Permission::where('name', '=', 'View profit and loss')->first() === null) {
            Permission::create([
                'name' => 'View profit and loss',
                'slug' => 'view.profit_and_loss',
                'description' => 'View profit and loss',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'View invoices')->first() === null) {
            Permission::create([
                'name' => 'View invoices',
                'slug' => 'view.invoices',
                'description' => 'View invoices',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'View gantt')->first() === null) {
            Permission::create([
                'name' => 'View gantt',
                'slug' => 'view.gantt',
                'description' => 'View gantt',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'View project requeriments')->first() === null) {
            Permission::create([
                'name' => 'View project requeriments',
                'slug' => 'view.projectrequeriments',
                'description' => 'View project requeriments',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'View agenda')->first() === null) {
            Permission::create([
                'name' => 'View agenda',
                'slug' => 'view.agenda',
                'description' => 'View agenda',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'View quotations')->first() === null) {
            Permission::create([
                'name' => 'View quotations',
                'slug' => 'view.quotations',
                'description' => 'View quotations',
                'model' => 'Permission',
            ]);
        }



        if (Permission::where('name', '=', 'View kpis')->first() === null) {
            Permission::create([
                'name' => 'View kpis',
                'slug' => 'view.kpis',
                'description' => 'View kpis',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'View catalog')->first() === null) {
            Permission::create([
                'name' => 'View catalog',
                'slug' => 'view.catalog',
                'description' => 'View Catalogs',
                'model' => 'Permission',
            ]);
        }

        if (Permission::where('name', '=', 'View repository')->first() === null) {
            Permission::create([
                'name' => 'View repository',
                'slug' => 'view.repository',
                'description' => 'View Repository',
                'model' => 'Permission',
            ]);
        }


    }
}
