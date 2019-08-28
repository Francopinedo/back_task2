<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call('PermissionsTableSeeder');
        $this->call('RolesTableSeeder');
        $this->call('ConnectRelationshipsSeeder');
        $this->call('CompanyRoleTemplatesTableSeeder');
        $this->call('ProjectRoleTemplatesTableSeeder');
        $this->call('SeniorityTemplatesTableSeeder');

        $this->call(UsersTableSeeder::class);
      //  $this->call('LanguagesTableSeeder');
      //  $this->call('CurrenciesTableSeeder');
       // $this->call('CountriesTableSeeder');
        //$this->call('CitiesTemplateTableSeeder');
        //$this->call('HolidaysTemplatesTableSeeder');
        $this->call('IndustriesTableSeeder');
        $this->call('AbsenceTypesTemplateTableSeeder');
        $this->call('ActivitiesTableSeeder');
        $this->call('CompaniesTableSeeder');
        $this->call('EmailCategoryTemplatesTableSeeder');
        $this->call('DirectoriesTableSeeder');
        $this->call('EngagementsTableSeeder');
    }
}
