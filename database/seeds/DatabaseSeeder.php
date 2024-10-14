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
      // $this->call('KpisCategoryTableSeeder');
      // $this->call('KpisTableSeeder');
     //  $this->call('ActivitiesTableSeeder');
     //  $this->call('LanguagesTableSeeder');
     //  $this->call('CurrenciesTableSeeder');
     //  $this->call('SeniorityTemplatesTableSeeder');
    	// $this->call('PermissionsTableSeeder');
     //    $this->call('RolesTableSeeder');
        // $this->call('ConnectRelationshipsSeeder');
        // $this->call('CompanyRoleTemplatesTableSeeder');
        // $this->call('ProjectRoleTemplatesTableSeeder');
        // $this->call('DoctypesTableSeeder');
        $this->call('MetadocumentsTableSeeder');
        // $this->call('MetagridsTableSeeder');
        // $this->call('MetavariablesTableSeeder');
      //   $this->call(UsersTableSeeder::class);
      // $this->call(SuSettingsTableSeeder::class);
      // $this->call('CountriesTableSeeder');
      // $this->call('CitiesTemplateTableSeeder');
      // $this->call('HolidaysTemplatesTableSeeder');
      // $this->call('IndustriesTableSeeder');
      // $this->call('AbsenceTypesTemplateTableSeeder');
      // $this->call('CompaniesTableSeeder');
      // $this->call('EmailCategoryTemplatesTableSeeder');
      // $this->call('TimezonesTableSeeder');
      // $this->call('DirectoriesTableSeeder');
      // $this->call('EngagementsTableSeeder');
    }
}
