
<?php
@header('Access-Control-Allow-Origin:  *');
@header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
@header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    // Users
    $api->get('users', 'App\Http\Controllers\UserController@index');
    $api->get('users/datatables', 'App\Http\Controllers\UserController@datatables');
    $api->get('users/index_export', 'App\Http\Controllers\UserController@index_export');

    $api->get('users/{id}', 'App\Http\Controllers\UserController@show');
    $api->post('users', 'App\Http\Controllers\UserController@store');
    $api->post('admin', 'App\Http\Controllers\UserController@storeAdmin');
    $api->patch('users/{id}', 'App\Http\Controllers\UserController@update');
    $api->delete('users/{id}', 'App\Http\Controllers\UserController@destroy');

    // Roles
    $api->get('roles', 'App\Http\Controllers\RolesController@index');
    $api->get('roles/{id}', 'App\Http\Controllers\RolesController@show');

    // Countries
    $api->get('countries', 'App\Http\Controllers\CountryController@index');
    $api->get('countries/datatables', 'App\Http\Controllers\CountryController@datatables');
    $api->get('countries/{id}', 'App\Http\Controllers\CountryController@show');
    $api->post('countries', 'App\Http\Controllers\CountryController@store');
    $api->patch('countries/{id}', 'App\Http\Controllers\CountryController@update');
    $api->delete('countries/{id}', 'App\Http\Controllers\CountryController@destroy');
    $api->get('countries/destroy/all', 'App\Http\Controllers\CountryController@destroyAll');

    // Engagaments
    $api->get('engagements', 'App\Http\Controllers\EngagementController@index');
    $api->get('engagements/datatables', 'App\Http\Controllers\EngagementController@datatables');
    $api->get('engagements/{id}', 'App\Http\Controllers\EngagementController@show');
    $api->post('engagements', 'App\Http\Controllers\EngagementController@store');
    $api->patch('engagements/{id}', 'App\Http\Controllers\EngagementController@update');
    $api->delete('engagements/{id}', 'App\Http\Controllers\EngagementController@destroy');

    // Currencies
    $api->get('currencies', 'App\Http\Controllers\CurrencyController@index');
    $api->get('currencies/datatables', 'App\Http\Controllers\CurrencyController@datatables');
    $api->get('currencies/{id}', 'App\Http\Controllers\CurrencyController@show');
    $api->post('currencies', 'App\Http\Controllers\CurrencyController@store');
    $api->patch('currencies/{id}', 'App\Http\Controllers\CurrencyController@update');
    $api->delete('currencies/{id}', 'App\Http\Controllers\CurrencyController@destroy');
    $api->get('currencies/destroy/all', 'App\Http\Controllers\CurrencyController@destroyAll');

    // Languages
    $api->get('languages', 'App\Http\Controllers\LanguageController@index');
    $api->get('languages/datatables', 'App\Http\Controllers\LanguageController@datatables');
    $api->get('languages/{id}', 'App\Http\Controllers\LanguageController@show');
    $api->post('languages', 'App\Http\Controllers\LanguageController@store');
    $api->patch('languages/{id}', 'App\Http\Controllers\LanguageController@update');
    $api->delete('languages/{id}', 'App\Http\Controllers\LanguageController@destroy');
    $api->get('languages/destroy/all', 'App\Http\Controllers\LanguageController@destroyAll');

    // HolidaysTemplates
    $api->get('holidays_templates', 'App\Http\Controllers\HolidayTemplateController@index');
    $api->get('holidays_templates/datatables', 'App\Http\Controllers\HolidayTemplateController@datatables');
    $api->get('holidays_templates/{id}', 'App\Http\Controllers\HolidayTemplateController@show');
    $api->post('holidays_templates', 'App\Http\Controllers\HolidayTemplateController@store');
    $api->patch('holidays_templates/{id}', 'App\Http\Controllers\HolidayTemplateController@update');
    $api->delete('holidays_templates/{id}', 'App\Http\Controllers\HolidayTemplateController@destroy');
    $api->get('holidays_templates/destroy/all', 'App\Http\Controllers\HolidayTemplateController@destroyAll');

    // Holidays
    $api->get('holidays', 'App\Http\Controllers\HolidayController@index');
    $api->get('holidays/datatables', 'App\Http\Controllers\HolidayController@datatables');
    $api->post('holidays/reload', 'App\Http\Controllers\HolidayController@reload');
    $api->get('holidays/{id}', 'App\Http\Controllers\HolidayController@show');
    $api->post('holidays', 'App\Http\Controllers\HolidayController@store');
    $api->patch('holidays/{id}', 'App\Http\Controllers\HolidayController@update');
    $api->delete('holidays/{id}', 'App\Http\Controllers\HolidayController@destroy');

    // Cities
    $api->get('cities', 'App\Http\Controllers\CityController@index');
    $api->get('cities/datatables', 'App\Http\Controllers\CityController@datatables');
    $api->get('cities/{id}', 'App\Http\Controllers\CityController@show');
    $api->post('cities', 'App\Http\Controllers\CityController@store');
    $api->patch('cities/{id}', 'App\Http\Controllers\CityController@update');
    $api->delete('cities/{id}', 'App\Http\Controllers\CityController@destroy');
    $api->post('cities/reload', 'App\Http\Controllers\CityController@reload');


    // Cities
    $api->get('cities_template', 'App\Http\Controllers\CityTemplateController@index');
    $api->get('cities_template/datatables', 'App\Http\Controllers\CityTemplateController@datatables');
    $api->get('cities_template/{id}', 'App\Http\Controllers\CityTemplateController@show');
    $api->post('cities_template', 'App\Http\Controllers\CityTemplateController@store');
    $api->patch('cities_template/{id}', 'App\Http\Controllers\CityTemplateController@update');
    $api->delete('cities_template/{id}', 'App\Http\Controllers\CityTemplateController@destroy');
    $api->get('cities_template/destroy/all', 'App\Http\Controllers\CityTemplateController@destroyAll');

    // Industries
    $api->get('industries', 'App\Http\Controllers\IndustryController@index');
    $api->get('industries/datatables', 'App\Http\Controllers\IndustryController@datatables');
    $api->get('industries/{id}', 'App\Http\Controllers\IndustryController@show');
    $api->post('industries', 'App\Http\Controllers\IndustryController@store');
    $api->patch('industries/{id}', 'App\Http\Controllers\IndustryController@update');
    $api->delete('industries/{id}', 'App\Http\Controllers\IndustryController@destroy');

    // EmailCategoryTemplates
    $api->get('email_category_templates', 'App\Http\Controllers\EmailCategoryTemplateController@index');
    $api->get('email_category_templates/datatables', 'App\Http\Controllers\EmailCategoryTemplateController@datatables');
    $api->get('email_category_templates/{id}', 'App\Http\Controllers\EmailCategoryTemplateController@show');
    $api->post('email_category_templates', 'App\Http\Controllers\EmailCategoryTemplateController@store');
    $api->patch('email_category_templates/{id}', 'App\Http\Controllers\EmailCategoryTemplateController@update');
    $api->delete('email_category_templates/{id}', 'App\Http\Controllers\EmailCategoryTemplateController@destroy');

    // EmailTemplates
    $api->get('email_templates', 'App\Http\Controllers\EmailTemplateController@index');
    $api->get('email_templates/datatables', 'App\Http\Controllers\EmailTemplateController@datatables');
    $api->get('email_templates/{id}', 'App\Http\Controllers\EmailTemplateController@show');
    $api->post('email_templates', 'App\Http\Controllers\EmailTemplateController@store');
    $api->patch('email_templates/{id}', 'App\Http\Controllers\EmailTemplateController@update');
    $api->delete('email_templates/{id}', 'App\Http\Controllers\EmailTemplateController@destroy');



    // SeniorityTemplates
    $api->get('seniority_templates', 'App\Http\Controllers\SeniorityTemplateController@index');
    $api->get('seniority_templates/datatables', 'App\Http\Controllers\SeniorityTemplateController@datatables');
    $api->get('seniority_templates/{id}', 'App\Http\Controllers\SeniorityTemplateController@show');
    $api->post('seniority_templates', 'App\Http\Controllers\SeniorityTemplateController@store');
    $api->patch('seniority_templates/{id}', 'App\Http\Controllers\SeniorityTemplateController@update');
    $api->delete('seniority_templates/{id}', 'App\Http\Controllers\SeniorityTemplateController@destroy');

    // ProjectRoleTemplates
    $api->get('project_role_templates', 'App\Http\Controllers\ProjectRoleTemplateController@index');
    $api->get('project_role_templates/datatables', 'App\Http\Controllers\ProjectRoleTemplateController@datatables');
    $api->get('project_role_templates/{id}', 'App\Http\Controllers\ProjectRoleTemplateController@show');
    $api->post('project_role_templates', 'App\Http\Controllers\ProjectRoleTemplateController@store');
    $api->patch('project_role_templates/{id}', 'App\Http\Controllers\ProjectRoleTemplateController@update');
    $api->delete('project_role_templates/{id}', 'App\Http\Controllers\ProjectRoleTemplateController@destroy');

    // CompanyRoleTemplates
    $api->get('company_role_templates', 'App\Http\Controllers\CompanyRoleTemplateController@index');
    $api->get('company_role_templates/datatables', 'App\Http\Controllers\CompanyRoleTemplateController@datatables');
    $api->get('company_role_templates/{id}', 'App\Http\Controllers\CompanyRoleTemplateController@show');
    $api->post('company_role_templates', 'App\Http\Controllers\CompanyRoleTemplateController@store');
    $api->patch('company_role_templates/{id}', 'App\Http\Controllers\CompanyRoleTemplateController@update');
    $api->delete('company_role_templates/{id}', 'App\Http\Controllers\CompanyRoleTemplateController@destroy');


    // AbsenceTypes
    $api->get('absence_types', 'App\Http\Controllers\AbsenceTypeController@index');
    $api->get('absence_types/datatables', 'App\Http\Controllers\AbsenceTypeController@datatables');
    $api->get('absence_types/{id}', 'App\Http\Controllers\AbsenceTypeController@show');
    $api->post('absence_types', 'App\Http\Controllers\AbsenceTypeController@store');
    $api->patch('absence_types/{id}', 'App\Http\Controllers\AbsenceTypeController@update');
    $api->delete('absence_types/{id}', 'App\Http\Controllers\AbsenceTypeController@destroy');
    $api->post('absence_types/reload', 'App\Http\Controllers\AbsenceTypeController@reload');

    // AbsenceTypes Template
    $api->get('absence_types_template', 'App\Http\Controllers\AbsenceTypeTemplateController@index');
    $api->get('absence_types_template/datatables', 'App\Http\Controllers\AbsenceTypeTemplateController@datatables');
    $api->get('absence_types_template/{id}', 'App\Http\Controllers\AbsenceTypeTemplateController@show');
    $api->post('absence_types_template', 'App\Http\Controllers\AbsenceTypeTemplateController@store');
    $api->patch('absence_types_template/{id}', 'App\Http\Controllers\AbsenceTypeTemplateController@update');
    $api->delete('absence_types_template/{id}', 'App\Http\Controllers\AbsenceTypeTemplateController@destroy');


    // Favorites
    $api->get('favorites', 'App\Http\Controllers\FavoriteController@index');
    $api->get('favorites/datatables', 'App\Http\Controllers\FavoriteController@datatables');
    $api->get('favorites/check', 'App\Http\Controllers\FavoriteController@check');
    $api->get('favorites/fromUser/{id}', 'App\Http\Controllers\FavoriteController@fromUser');
    $api->get('favorites/{id}', 'App\Http\Controllers\FavoriteController@show');
    $api->post('favorites', 'App\Http\Controllers\FavoriteController@store');
    $api->patch('favorites/{id}', 'App\Http\Controllers\FavoriteController@update');
    $api->delete('favorites', 'App\Http\Controllers\FavoriteController@destroy');

    // Companies
    $api->get('companies', 'App\Http\Controllers\CompanyController@index');
    $api->get('companies/datatables', 'App\Http\Controllers\CompanyController@datatables');
    $api->get('companies/fromUser/{user_id}', 'App\Http\Controllers\CompanyController@fromUser');
    $api->get('companies/{id}', 'App\Http\Controllers\CompanyController@show');
    $api->post('companies', 'App\Http\Controllers\CompanyController@store');
    $api->patch('companies/{id}', 'App\Http\Controllers\CompanyController@update');
    $api->delete('companies/{id}', 'App\Http\Controllers\CompanyController@destroy');

    // Customers
    $api->get('customers', 'App\Http\Controllers\CustomerController@index');
    $api->get('customers/datatables', 'App\Http\Controllers\CustomerController@datatables');
    $api->get('customers/{id}', 'App\Http\Controllers\CustomerController@show');
    $api->post('customers', 'App\Http\Controllers\CustomerController@store');
    $api->patch('customers/{id}', 'App\Http\Controllers\CustomerController@update');
    $api->delete('customers/{id}', 'App\Http\Controllers\CustomerController@destroy');

    // Offices
    $api->get('offices', 'App\Http\Controllers\OfficeController@index');
    $api->get('offices/datatables', 'App\Http\Controllers\OfficeController@datatables');
    $api->get('offices/{id}', 'App\Http\Controllers\OfficeController@show');
    $api->post('offices', 'App\Http\Controllers\OfficeController@store');
    $api->patch('offices/{id}', 'App\Http\Controllers\OfficeController@update');
    $api->delete('offices/{id}', 'App\Http\Controllers\OfficeController@destroy');

    // Seniorities
    $api->get('seniorities', 'App\Http\Controllers\SeniorityController@index');
    $api->get('seniorities/datatables', 'App\Http\Controllers\SeniorityController@datatables');
    $api->get('seniorities/{id}', 'App\Http\Controllers\SeniorityController@show');
    $api->post('seniorities', 'App\Http\Controllers\SeniorityController@store');
    $api->patch('seniorities/{id}', 'App\Http\Controllers\SeniorityController@update');
    $api->delete('seniorities/{id}', 'App\Http\Controllers\SeniorityController@destroy');

    // Company Roles
    $api->get('company_roles', 'App\Http\Controllers\CompanyRoleController@index');
    $api->get('company_roles/datatables', 'App\Http\Controllers\CompanyRoleController@datatables');
    $api->get('company_roles/{id}', 'App\Http\Controllers\CompanyRoleController@show');
    $api->post('company_roles', 'App\Http\Controllers\CompanyRoleController@store');
    $api->patch('company_roles/{id}', 'App\Http\Controllers\CompanyRoleController@update');
    $api->delete('company_roles/{id}', 'App\Http\Controllers\CompanyRoleController@destroy');
    $api->post('company_roles/reload', 'App\Http\Controllers\CompanyRoleController@reload');
    // Project Roles
    $api->get('project_roles', 'App\Http\Controllers\ProjectRoleController@index');
    $api->get('project_roles/datatables', 'App\Http\Controllers\ProjectRoleController@datatables');
    $api->get('project_roles/{id}', 'App\Http\Controllers\ProjectRoleController@show');
    $api->post('project_roles', 'App\Http\Controllers\ProjectRoleController@store');
    $api->patch('project_roles/{id}', 'App\Http\Controllers\ProjectRoleController@update');
    $api->delete('project_roles/{id}', 'App\Http\Controllers\ProjectRoleController@destroy');

    // ExchangeRates
    $api->get('exchange_rates', 'App\Http\Controllers\ExchangeRateController@index');
    $api->get('exchange_rates/datatables', 'App\Http\Controllers\ExchangeRateController@datatables');
    $api->get('exchange_rates/{id}', 'App\Http\Controllers\ExchangeRateController@show');
    $api->post('exchange_rates', 'App\Http\Controllers\ExchangeRateController@store');
    $api->patch('exchange_rates/{id}', 'App\Http\Controllers\ExchangeRateController@update');
    $api->delete('exchange_rates/{id}', 'App\Http\Controllers\ExchangeRateController@destroy');

    // WorkGroups
    $api->get('workgroups', 'App\Http\Controllers\WorkgroupController@index');
    $api->get('workgroups/datatables', 'App\Http\Controllers\WorkgroupController@datatables');
    $api->get('workgroups/{id}', 'App\Http\Controllers\WorkgroupController@show');
    $api->post('workgroups', 'App\Http\Controllers\WorkgroupController@store');
    $api->patch('workgroups/{id}', 'App\Http\Controllers\WorkgroupController@update');
    $api->delete('workgroups/{id}', 'App\Http\Controllers\WorkgroupController@destroy');

    // Costs
    $api->get('costs', 'App\Http\Controllers\CostController@index');
    $api->get('costs/datatables', 'App\Http\Controllers\CostController@datatables');
    $api->get('costs/{id}', 'App\Http\Controllers\CostController@show');
    $api->post('costs', 'App\Http\Controllers\CostController@store');
    $api->patch('costs/{id}', 'App\Http\Controllers\CostController@update');
    $api->delete('costs/{id}', 'App\Http\Controllers\CostController@destroy');

    // Departments
    $api->get('departments', 'App\Http\Controllers\DepartmentController@index');
    $api->get('departments/datatables', 'App\Http\Controllers\DepartmentController@datatables');
    $api->get('departments/{id}', 'App\Http\Controllers\DepartmentController@show');
    $api->post('departments', 'App\Http\Controllers\DepartmentController@store');
    $api->patch('departments/{id}', 'App\Http\Controllers\DepartmentController@update');
    $api->delete('departments/{id}', 'App\Http\Controllers\DepartmentController@destroy');

    // EmailCategories
    $api->get('email_categories/{id}', 'App\Http\Controllers\EmailCategoryController@show');
    $api->get('email_categories', 'App\Http\Controllers\EmailCategoryController@index');
    $api->post('email_categories', 'App\Http\Controllers\EmailCategoryController@store');
    $api->patch('email_categories/{id}', 'App\Http\Controllers\EmailCategoryController@update');
    $api->delete('email_categories/{id}', 'App\Http\Controllers\EmailCategoryController@destroy');
    $api->post('email_categories/reload', 'App\Http\Controllers\EmailCategoryController@reload');

    // EmailTemplates
    $api->get('emails/{id}', 'App\Http\Controllers\EmailController@show');
    $api->post('emails', 'App\Http\Controllers\EmailController@store');
    $api->patch('emails/{id}', 'App\Http\Controllers\EmailController@update');
    $api->delete('emails/{id}', 'App\Http\Controllers\EmailController@destroy');
    $api->post('emails/reload', 'App\Http\Controllers\EmailController@reload');

    // Projects

    $api->get('projects', 'App\Http\Controllers\ProjectController@index');
    $api->get('projects/datatables', 'App\Http\Controllers\ProjectController@datatables');
    $api->get('projects/{id}', 'App\Http\Controllers\ProjectController@show');
    $api->get('projects/{id}/count_rows', 'App\Http\Controllers\ProjectController@countRows');
    $api->post('projects', 'App\Http\Controllers\ProjectController@store');
    $api->patch('projects/{id}', 'App\Http\Controllers\ProjectController@update');
    $api->delete('projects/{id}', 'App\Http\Controllers\ProjectController@destroy');


    // CapacityPlanning
    $api->get('capacity_planning', 'App\Http\Controllers\CapacityPlanningController@index');
    $api->get('capacity_planning/datatables', 'App\Http\Controllers\CapacityPlanningController@datatables'
);
        $api->get('capacity_planning/pdf', 'App\Http\Controllers\CapacityPlanningController@pdf');



    // Rates
    $api->get('rates', 'App\Http\Controllers\RateController@index');
    $api->get('rates/datatables', 'App\Http\Controllers\RateController@datatables');
    $api->get('rates/{id}', 'App\Http\Controllers\RateController@show');
    $api->post('rates', 'App\Http\Controllers\RateController@store');
    $api->patch('rates/{id}', 'App\Http\Controllers\RateController@update');
    $api->delete('rates/{id}', 'App\Http\Controllers\RateController@destroy');

    // PermissionRole
    $api->get('permission_roles/{id}', 'App\Http\Controllers\PermissionRoleController@show');
    $api->post('permission_roles', 'App\Http\Controllers\PermissionRoleController@store');
    $api->delete('permission_roles/{permission_id}/{role_id}', 'App\Http\Controllers\PermissionRoleController@destroy');

    // Permission
    $api->get('permissions', 'App\Http\Controllers\PermissionController@index');
    $api->get('permissions/{id}', 'App\Http\Controllers\PermissionController@show');

    // WordDirectory
    $api->get('directories', 'App\Http\Controllers\DirectoryController@index');
    $api->get('directories/{id}', 'App\Http\Controllers\DirectoryController@show');


    // DirectoryRole
    $api->get('directory_roles/{id}', 'App\Http\Controllers\DirectoryRoleController@show');
    $api->post('directory_roles', 'App\Http\Controllers\DirectoryRoleController@store');
    $api->patch('directory_roles/{id}', 'App\Http\Controllers\DirectoryRoleController@update');
    $api->patch('directory_roles/{permission_id}/{role_id}/{type}', 'App\Http\Controllers\DirectoryRoleController@destroy');

    // RoleUser
    $api->patch('role_users/{id}', 'App\Http\Controllers\UserRoleController@update');

    // OtherCosts
    $api->get('other_costs', 'App\Http\Controllers\OtherCostController@index');
    $api->get('other_costs/datatables', 'App\Http\Controllers\OtherCostController@datatables');
    $api->get('other_costs/{id}', 'App\Http\Controllers\OtherCostController@show');
    $api->post('other_costs', 'App\Http\Controllers\OtherCostController@store');
    $api->patch('other_costs/{id}', 'App\Http\Controllers\OtherCostController@update');
    $api->delete('other_costs/{id}', 'App\Http\Controllers\OtherCostController@destroy');

    // Services
    $api->get('services', 'App\Http\Controllers\ServiceController@index');
    $api->get('services/index_export', 'App\Http\Controllers\ServiceController@index_export');

    $api->get('services/datatables', 'App\Http\Controllers\ServiceController@datatables');

    $api->get('services/{id}', 'App\Http\Controllers\ServiceController@show');
    $api->post('services', 'App\Http\Controllers\ServiceController@store');
    $api->patch('services/{id}', 'App\Http\Controllers\ServiceController@update');
    $api->delete('services/{id}', 'App\Http\Controllers\ServiceController@destroy');

    // Expenses
    $api->get('expenses', 'App\Http\Controllers\ExpenseController@index');
    $api->get('expenses/index_export', 'App\Http\Controllers\ExpenseController@index_export');

    $api->get('expenses/datatables', 'App\Http\Controllers\ExpenseController@datatables');
    $api->get('expenses/{id}', 'App\Http\Controllers\ExpenseController@show');
    $api->post('expenses', 'App\Http\Controllers\ExpenseController@store');
    $api->patch('expenses/{id}', 'App\Http\Controllers\ExpenseController@update');
    $api->delete('expenses/{id}', 'App\Http\Controllers\ExpenseController@destroy');

    // Materials
    $api->get('materials', 'App\Http\Controllers\MaterialController@index');
    $api->get('materials/index_export', 'App\Http\Controllers\MaterialController@index_export');

    $api->get('materials/datatables', 'App\Http\Controllers\MaterialController@datatables');
    $api->get('materials/{id}', 'App\Http\Controllers\MaterialController@show');
    $api->post('materials', 'App\Http\Controllers\MaterialController@store');
    $api->patch('materials/{id}', 'App\Http\Controllers\MaterialController@update');
    $api->delete('materials/{id}', 'App\Http\Controllers\MaterialController@destroy');

    // Discounts
    $api->get('discounts', 'App\Http\Controllers\DiscountController@index');
    $api->get('discounts/datatables', 'App\Http\Controllers\DiscountController@datatables');
    $api->get('discounts/{id}', 'App\Http\Controllers\DiscountController@show');
    $api->post('discounts', 'App\Http\Controllers\DiscountController@store');
    $api->patch('discounts/{id}', 'App\Http\Controllers\DiscountController@update');
    $api->delete('discounts/{id}', 'App\Http\Controllers\DiscountController@destroy');

    // Taxes
    $api->get('taxes', 'App\Http\Controllers\TaxController@index');
    $api->get('taxes/datatables', 'App\Http\Controllers\TaxController@datatables');
    $api->get('taxes/{id}', 'App\Http\Controllers\TaxController@show');
    $api->post('taxes', 'App\Http\Controllers\TaxController@store');
    $api->patch('taxes/{id}', 'App\Http\Controllers\TaxController@update');
    $api->delete('taxes/{id}', 'App\Http\Controllers\TaxController@destroy');


     // Debit Credit
    $api->get('debit_credit', 'App\Http\Controllers\DebitCreditController@index');
    $api->get('debit_credit/datatables', 'App\Http\Controllers\DebitCreditController@datatables');
    $api->get('debit_credit/{id}', 'App\Http\Controllers\DebitCreditController@show');
    $api->post('debit_credit', 'App\Http\Controllers\DebitCreditController@store');
    $api->patch('debit_credit/{id}', 'App\Http\Controllers\DebitCreditController@update');
    $api->delete('debit_credit/{id}', 'App\Http\Controllers\DebitCreditController@destroy');


    // Absences
    $api->get('absences', 'App\Http\Controllers\AbsenceController@index');
    $api->get('absences/datatables', 'App\Http\Controllers\AbsenceController@datatables');
    $api->get('absences/{id}', 'App\Http\Controllers\AbsenceController@show');
    $api->post('absences', 'App\Http\Controllers\AbsenceController@store');
    $api->patch('absences/{id}', 'App\Http\Controllers\AbsenceController@update');
    $api->delete('absences/{id}', 'App\Http\Controllers\AbsenceController@destroy');

    // Replacements
    $api->get('replacements', 'App\Http\Controllers\ReplacementController@index');
    $api->get('replacements/datatables', 'App\Http\Controllers\ReplacementController@datatables');
    $api->get('replacements/{id}', 'App\Http\Controllers\ReplacementController@show');
    $api->post('replacements', 'App\Http\Controllers\ReplacementController@store');
    $api->patch('replacements/{id}', 'App\Http\Controllers\ReplacementController@update');
    $api->delete('replacements/{id}', 'App\Http\Controllers\ReplacementController@destroy');

    // Teams
    $api->get('teams', 'App\Http\Controllers\TeamController@index');
    $api->get('teams/datatables', 'App\Http\Controllers\TeamController@datatables');
    $api->get('teams/{id}', 'App\Http\Controllers\TeamController@show');
    $api->post('teams', 'App\Http\Controllers\TeamController@store');
    $api->patch('teams/{id}', 'App\Http\Controllers\TeamController@update');
    $api->delete('teams/{id}', 'App\Http\Controllers\TeamController@destroy');

    // TeamUsers
    $api->get('team_users', 'App\Http\Controllers\TeamUserController@index');
    $api->get('team_users/index_export', 'App\Http\Controllers\TeamUserController@index_export');
    $api->get('team_users/datatables', 'App\Http\Controllers\TeamUserController@datatables');
    $api->get('team_users/{id}', 'App\Http\Controllers\TeamUserController@show');
    $api->post('team_users', 'App\Http\Controllers\TeamUserController@store');
    $api->patch('team_users/{id}', 'App\Http\Controllers\TeamUserController@update');
    $api->delete('team_users/{id}', 'App\Http\Controllers\TeamUserController@destroy');
    $api->get('team_users/get_rate/{user_id}', 'App\Http\Controllers\TeamUserController@get_rate');
    //
    $api->get('team_users/get_user/{user_id}', 'App\Http\Controllers\TeamUserController@show_user');


    $api->get('team_users/get_load/{user_id}/{project_id}/{office_id}', 'App\Http\Controllers\TeamUserController@get_load');

    // Contacts
    $api->get('contacts', 'App\Http\Controllers\ContactController@index');
    $api->get('contacts/datatables', 'App\Http\Controllers\ContactController@datatables');
    $api->get('contacts/{id}', 'App\Http\Controllers\ContactController@show');
    $api->post('contacts', 'App\Http\Controllers\ContactController@store');
    $api->patch('contacts/{id}', 'App\Http\Controllers\ContactController@update');
    $api->delete('contacts/{id}', 'App\Http\Controllers\ContactController@destroy');

    // Stakeholders
    $api->get('stakeholders', 'App\Http\Controllers\StakeholderController@index');
    $api->get('stakeholders/datatables', 'App\Http\Controllers\StakeholderController@datatables');
    $api->get('stakeholders/{id}', 'App\Http\Controllers\StakeholderController@show');
    $api->post('stakeholders', 'App\Http\Controllers\StakeholderController@store');
    $api->patch('stakeholders/{id}', 'App\Http\Controllers\StakeholderController@update');
    $api->delete('stakeholders/{id}', 'App\Http\Controllers\StakeholderController@destroy');

    // Agenda
    $api->get('agendas', 'App\Http\Controllers\AgendaController@index');
    $api->get('agendas/datatables', 'App\Http\Controllers\AgendaController@datatables');
    $api->get('agendas/{id}', 'App\Http\Controllers\AgendaController@show');
    $api->post('agendas', 'App\Http\Controllers\AgendaController@store');
    $api->patch('agendas/{id}', 'App\Http\Controllers\AgendaController@update');
    $api->delete('agendas/{id}', 'App\Http\Controllers\AgendaController@destroy');

    // ActivitiesHistory
    $api->get('activities_history', 'App\Http\Controllers\ActivityHistoryController@index');
    $api->get('activities_history/datatables', 'App\Http\Controllers\ActivityHistoryController@datatables');
    $api->get('activities_history/{id}', 'App\Http\Controllers\ActivityHistoryController@show');
    $api->post('activities_history', 'App\Http\Controllers\ActivityHistoryController@store');
    $api->patch('activities_history/{id}', 'App\Http\Controllers\ActivityHistoryController@update');
    $api->delete('activities_history/{id}', 'App\Http\Controllers\ActivityHistoryController@destroy');

    // Kpis
    $api->get('kpis', 'App\Http\Controllers\KpiController@index');
    $api->get('kpis/chartEv', 'App\Http\Controllers\KpiController@chartEv');
    $api->get('kpis/chartAc', 'App\Http\Controllers\KpiController@chartAc');
    $api->get('kpis/chartPv', 'App\Http\Controllers\KpiController@chartPv');
    $api->get('kpis/chartCpi', 'App\Http\Controllers\KpiController@chartCpi');
    $api->get('kpis/chartSpi', 'App\Http\Controllers\KpiController@chartSpi');
    $api->get('kpis/chartEac1', 'App\Http\Controllers\KpiController@chartEac1');
    $api->get('kpis/chartEac2', 'App\Http\Controllers\KpiController@chartEac2');
    $api->get('kpis/chartEac3', 'App\Http\Controllers\KpiController@chartEac3');
    $api->get('kpis/chartEac4', 'App\Http\Controllers\KpiController@chartEac4');
    $api->get('kpis/chartVac1', 'App\Http\Controllers\KpiController@chartVac1');
    $api->get('kpis/chartVac2', 'App\Http\Controllers\KpiController@chartVac2');
    $api->get('kpis/chartVac3', 'App\Http\Controllers\KpiController@chartVac3');
    $api->get('kpis/chartVac4', 'App\Http\Controllers\KpiController@chartVac4');
    $api->get('kpis/chartSv', 'App\Http\Controllers\KpiController@chartSv');
    $api->get('kpis/chartCv', 'App\Http\Controllers\KpiController@chartCv');
    $api->get('kpis/chartMfn', 'App\Http\Controllers\KpiController@chartMfn');
    $api->get('kpis/chartFnsl', 'App\Http\Controllers\KpiController@chartFnsl');
    $api->get('kpis/chartRoi', 'App\Http\Controllers\KpiController@chartRoi');
    $api->get('kpis/chartRrr', 'App\Http\Controllers\KpiController@chartRrr');
    $api->get('kpis/chartActivities', 'App\Http\Controllers\KpiController@chartActivities');
    $api->get('kpis/chartMilestones', 'App\Http\Controllers\KpiController@chartMilestones');
    $api->get('kpis/chartReviews', 'App\Http\Controllers\KpiController@chartReviews');
    $api->get('kpis/chartCommitments', 'App\Http\Controllers\KpiController@chartCommitments');
    $api->get('kpis/chartOverdueTasks', 'App\Http\Controllers\KpiController@chartOverdueTasks');
    $api->get('kpis/chartTaskCompleted', 'App\Http\Controllers\KpiController@chartTaskCompleted');
    $api->get('kpis/chartPlannedHours', 'App\Http\Controllers\KpiController@chartPlannedHours');
    $api->get('kpis/chartCompletedProjects', 'App\Http\Controllers\KpiController@chartCompletedProjects');
$api->get('kpis/percentPlannedvsRealMilestone', 'App\Http\Controllers\KpiController@percentPlannedvsRealMilestone');
$api->get('kpis/percentMissingMilestone', 'App\Http\Controllers\KpiController@percentMissingMilestone');

$api->get('kpis/chartDelivernotTime', 'App\Http\Controllers\KpiController@chartDelivernotTime');
$api->get('kpis/chartCancelledProjects', 'App\Http\Controllers\KpiController@chartCancelledProjects');

    $api->get('kpis/chartResponseTimes', 'App\Http\Controllers\KpiController@chartResponseTimes');
        $api->get('kpis/chartCapacity', 'App\Http\Controllers\KpiController@chartCapacity');

        $api->get('kpis/chartUserStats', 'App\Http\Controllers\KpiController@chartUserStats');
        $api->get('kpis/listTasks', 'App\Http\Controllers\KpiController@listTasks');
        $api->get('kpis/chartcountBugs', 'App\Http\Controllers\KpiController@chartcountBugs');



    $api->get('kpis/indicadores', 'App\Http\Controllers\KpiController@indicadores');
    $api->get('kpis/datatables', 'App\Http\Controllers\KpiController@datatables');
    $api->get('kpis/{id}', 'App\Http\Controllers\KpiController@show');
    $api->post('kpis', 'App\Http\Controllers\KpiController@store');
    $api->patch('kpis/{id}', 'App\Http\Controllers\KpiController@update');
    $api->delete('kpis/{id}', 'App\Http\Controllers\KpiController@destroy');



    // Kpis_category
    $api->get('kpis_category', 'App\Http\Controllers\KpiCategoryController@index');
    $api->get('kpis_category/datatables', 'App\Http\Controllers\KpiCategoryController@datatables');
    $api->get('kpis_category/{id}', 'App\Http\Controllers\KpiCategoryController@show');
    $api->post('kpis_category', 'App\Http\Controllers\KpiCategoryController@store');
    $api->patch('kpis_category/{id}', 'App\Http\Controllers\KpiCategoryController@update');
    $api->delete('kpis_category/{id}', 'App\Http\Controllers\KpiCategoryController@destroy');


  // dashboard
  $api->get('dashboard', 'App\Http\Controllers\DashboardController@index');
  $api->get('dashboard/chartEv', 'App\Http\Controllers\DashboardController@chartEv');
  $api->get('dashboard/chartEvTotal', 'App\Http\Controllers\DashboardController@chartEvTotal');

  $api->get('dashboard/calculateBasicsIndicators_total', 'App\Http\Controllers\DashboardController@calculateBasicsIndicators_total');

  $api->get('dashboard/chartAc', 'App\Http\Controllers\DashboardController@chartAc');
  $api->get('dashboard/chartPv', 'App\Http\Controllers\DashboardController@chartPv');
  $api->get('dashboard/chartCpi', 'App\Http\Controllers\DashboardController@chartCpi');
  $api->get('dashboard/chartSpi', 'App\Http\Controllers\DashboardController@chartSpi');
  $api->get('dashboard/chartEac1', 'App\Http\Controllers\DashboardController@chartEac1');
  $api->get('dashboard/chartEac2', 'App\Http\Controllers\DashboardController@chartEac2');
  $api->get('dashboard/chartEac3', 'App\Http\Controllers\DashboardController@chartEac3');
  $api->get('dashboard/chartEac4', 'App\Http\Controllers\DashboardController@chartEac4');
  $api->get('dashboard/chartVac1', 'App\Http\Controllers\DashboardController@chartVac1');
  $api->get('dashboard/chartVac2', 'App\Http\Controllers\DashboardController@chartVac2');
  $api->get('dashboard/chartVac3', 'App\Http\Controllers\DashboardController@chartVac3');
  $api->get('dashboard/chartVac4', 'App\Http\Controllers\DashboardController@chartVac4');
  $api->get('dashboard/chartSv', 'App\Http\Controllers\DashboardController@chartSv');
  $api->get('dashboard/chartCv', 'App\Http\Controllers\DashboardController@chartCv');
  $api->get('dashboard/chartMfn', 'App\Http\Controllers\DashboardController@chartMfn');
  $api->get('dashboard/chartFnsl', 'App\Http\Controllers\DashboardController@chartFnsl');
  $api->get('dashboard/chartRoi', 'App\Http\Controllers\DashboardController@chartRoi');
  $api->get('dashboard/chartRrr', 'App\Http\Controllers\DashboardController@chartRrr');
  $api->get('dashboard/chartActivities', 'App\Http\Controllers\DashboardController@chartActivities');
  $api->get('dashboard/chartMilestones', 'App\Http\Controllers\DashboardController@chartMilestones');
  $api->get('dashboard/chartReviews', 'App\Http\Controllers\DashboardController@chartReviews');
  $api->get('dashboard/chartCommitments', 'App\Http\Controllers\DashboardController@chartCommitments');
  $api->get('dashboard/chartOverdueTasks', 'App\Http\Controllers\DashboardController@chartOverdueTasks');
  $api->get('dashboard/chartTaskCompleted', 'App\Http\Controllers\DashboardController@chartTaskCompleted');
  $api->get('dashboard/chartPlannedHours', 'App\Http\Controllers\DashboardController@chartPlannedHours');
  $api->get('dashboard/chartCompletedProjects', 'App\Http\Controllers\DashboardController@chartCompletedProjects');
$api->get('dashboard/percentPlannedvsRealMilestone', 'App\Http\Controllers\DashboardController@percentPlannedvsRealMilestone');
$api->get('dashboard/percentMissingMilestone', 'App\Http\Controllers\DashboardController@percentMissingMilestone');

$api->get('dashboard/chartDelivernotTime', 'App\Http\Controllers\DashboardController@chartDelivernotTime');
$api->get('dashboard/chartCancelledProjects', 'App\Http\Controllers\DashboardController@chartCancelledProjects');
$api->get('dashboard/chartRequirements', 'App\Http\Controllers\DashboardController@chartRequirements');


  $api->get('dashboard/chartResponseTimes', 'App\Http\Controllers\DashboardController@chartResponseTimes');
      $api->get('dashboard/chartCapacity', 'App\Http\Controllers\DashboardController@chartCapacity');

      $api->get('dashboard/chartTicketsStats', 'App\Http\Controllers\DashboardController@chartTicketsStats');
      $api->get('dashboard/chartTicketsStatsType', 'App\Http\Controllers\DashboardController@chartTicketsStatsType');

      
      $api->get('dashboard/listTasks', 'App\Http\Controllers\DashboardController@listTasks');
      $api->get('dashboard/chartcountBugs', 'App\Http\Controllers\DashboardController@chartcountBugs');
      $api->get('dashboard/chartTasks', 'App\Http\Controllers\DashboardController@chartTasks');
      $api->get('dashboard/chartMissingMilestonesTasks', 'App\Http\Controllers\DashboardController@chartMissingMilestonesTasks');
      $api->get('dashboard/chartIssues', 'App\Http\Controllers\DashboardController@chartIssues');
      $api->get('dashboard/chartMilestonesTasks', 'App\Http\Controllers\DashboardController@chartMilestonesTasks');

      
      
      

// dashboard_category
$api->get('dashboard_category', 'App\Http\Controllers\DashboardCategoryController@index');
$api->get('dashboard_category/datatables', 'App\Http\Controllers\DashboardCategoryController@datatables');
$api->get('dashboard_category/{id}', 'App\Http\Controllers\DashboardCategoryController@show');
$api->post('dashboard_category', 'App\Http\Controllers\DashboardCategoryController@store');
$api->patch('dashboard_category/{id}', 'App\Http\Controllers\DashboardCategoryController@update');
$api->delete('dashboard_category/{id}', 'App\Http\Controllers\DashboardCategoryController@destroy');




    // ProjectKpiAlerts
    $api->get('project_kpi_alerts', 'App\Http\Controllers\ProjectKpiAlertController@index');
    $api->get('project_kpi_alerts/datatables', 'App\Http\Controllers\ProjectKpiAlertController@datatables');
    $api->get('project_kpi_alerts/{id}', 'App\Http\Controllers\ProjectKpiAlertController@show');
    $api->post('project_kpi_alerts', 'App\Http\Controllers\ProjectKpiAlertController@store');
    $api->patch('project_kpi_alerts/{id}', 'App\Http\Controllers\ProjectKpiAlertController@update');
    $api->delete('project_kpi_alerts/{id}', 'App\Http\Controllers\ProjectKpiAlertController@destroy');

    // Contracts
    $api->get('contracts', 'App\Http\Controllers\ContractController@index');
    $api->get('contracts/datatables', 'App\Http\Controllers\ContractController@datatables');
    $api->get('contracts/{id}', 'App\Http\Controllers\ContractController@show');
    $api->post('contracts', 'App\Http\Controllers\ContractController@store');
    $api->patch('contracts/{id}', 'App\Http\Controllers\ContractController@update');
    $api->delete('contracts/{id}', 'App\Http\Controllers\ContractController@destroy');

    // ContractResources
    $api->get('contract_resources', 'App\Http\Controllers\ContractResourceController@index');
    $api->get('contract_resources/datatables', 'App\Http\Controllers\ContractResourceController@datatables');
    $api->get('contract_resources/{id}', 'App\Http\Controllers\ContractResourceController@show');
    $api->post('contract_resources', 'App\Http\Controllers\ContractResourceController@store');
    $api->patch('contract_resources/{id}', 'App\Http\Controllers\ContractResourceController@update');
    $api->delete('contract_resources/{id}', 'App\Http\Controllers\ContractResourceController@destroy');

    // ContractExpenses
    $api->get('contract_expenses', 'App\Http\Controllers\ContractExpenseController@index');
    $api->get('contract_expenses/datatables', 'App\Http\Controllers\ContractExpenseController@datatables');
    $api->get('contract_expenses/{id}', 'App\Http\Controllers\ContractExpenseController@show');
    $api->post('contract_expenses', 'App\Http\Controllers\ContractExpenseController@store');
    $api->patch('contract_expenses/{id}', 'App\Http\Controllers\ContractExpenseController@update');
    $api->delete('contract_expenses/{id}', 'App\Http\Controllers\ContractExpenseController@destroy');

    // ContractServices
    $api->get('contract_services', 'App\Http\Controllers\ContractServiceController@index');
    $api->get('contract_services/datatables', 'App\Http\Controllers\ContractServiceController@datatables');
    $api->get('contract_services/{id}', 'App\Http\Controllers\ContractServiceController@show');
    $api->post('contract_services', 'App\Http\Controllers\ContractServiceController@store');
    $api->patch('contract_services/{id}', 'App\Http\Controllers\ContractServiceController@update');
    $api->delete('contract_services/{id}', 'App\Http\Controllers\ContractServiceController@destroy');

    // ContractMaterials
    $api->get('contract_materials', 'App\Http\Controllers\ContractMaterialController@index');
    $api->get('contract_materials/datatables', 'App\Http\Controllers\ContractMaterialController@datatables');
    $api->get('contract_materials/{id}', 'App\Http\Controllers\ContractMaterialController@show');
    $api->post('contract_materials', 'App\Http\Controllers\ContractMaterialController@store');
    $api->patch('contract_materials/{id}', 'App\Http\Controllers\ContractMaterialController@update');
    $api->delete('contract_materials/{id}', 'App\Http\Controllers\ContractMaterialController@destroy');

    // AddiotionalHours
    $api->get('additional_hours', 'App\Http\Controllers\AdditionalHourController@index');
    $api->get('additional_hours/datatables', 'App\Http\Controllers\AdditionalHourController@datatables');
    $api->get('additional_hours/{id}', 'App\Http\Controllers\AdditionalHourController@show');
    $api->post('additional_hours', 'App\Http\Controllers\AdditionalHourController@store');
    $api->patch('additional_hours/{id}', 'App\Http\Controllers\AdditionalHourController@update');
    $api->delete('additional_hours/{id}', 'App\Http\Controllers\AdditionalHourController@destroy');

 $api->get('additional_hours/get_sum_hours/{user_id}', 'App\Http\Controllers\AdditionalHourController@get_sum_hours');
    

    // WorkingHours
    $api->get('working_hours', 'App\Http\Controllers\WorkingHourController@index');
    $api->get('working_hours/calculated', 'App\Http\Controllers\WorkingHourController@calculated');
    $api->get('working_hours/datatables', 'App\Http\Controllers\WorkingHourController@datatables');
    $api->get('working_hours/generate/{project_id}', 'App\Http\Controllers\WorkingHourController@generate');
    $api->get('working_hours/{id}', 'App\Http\Controllers\WorkingHourController@show');
    $api->post('working_hours', 'App\Http\Controllers\WorkingHourController@store');
    $api->patch('working_hours/{id}', 'App\Http\Controllers\WorkingHourController@update');
    $api->delete('working_hours/{id}', 'App\Http\Controllers\WorkingHourController@destroy');

    // ProjectResources
    $api->get('project_resources', 'App\Http\Controllers\ProjectResourceController@index');
    $api->get('project_resources/datatables', 'App\Http\Controllers\ProjectResourceController@datatables');
    $api->get('project_resources/{id}', 'App\Http\Controllers\ProjectResourceController@show');
    $api->post('project_resources', 'App\Http\Controllers\ProjectResourceController@store');
    $api->patch('project_resources/{id}', 'App\Http\Controllers\ProjectResourceController@update');
    $api->delete('project_resources/{id}', 'App\Http\Controllers\ProjectResourceController@destroy');

    // ProjectExpenses
    $api->get('project_expenses', 'App\Http\Controllers\ProjectExpenseController@index');
    $api->get('project_expenses/index_export', 'App\Http\Controllers\ProjectExpenseController@index_export');

    $api->get('project_expenses/datatables', 'App\Http\Controllers\ProjectExpenseController@datatables');
    $api->get('project_expenses/{id}', 'App\Http\Controllers\ProjectExpenseController@show');
    $api->post('project_expenses', 'App\Http\Controllers\ProjectExpenseController@store');
    $api->patch('project_expenses/{id}', 'App\Http\Controllers\ProjectExpenseController@update');
    $api->delete('project_expenses/{id}', 'App\Http\Controllers\ProjectExpenseController@destroy');

    // ProjectServices
    $api->get('project_services', 'App\Http\Controllers\ProjectServiceController@index');
    $api->get('project_services/index_export', 'App\Http\Controllers\ProjectServiceController@index_export');

    $api->get('project_services/datatables', 'App\Http\Controllers\ProjectServiceController@datatables');
    $api->get('project_services/{id}', 'App\Http\Controllers\ProjectServiceController@show');
    $api->post('project_services', 'App\Http\Controllers\ProjectServiceController@store');
    $api->patch('project_services/{id}', 'App\Http\Controllers\ProjectServiceController@update');
    $api->delete('project_services/{id}', 'App\Http\Controllers\ProjectServiceController@destroy');

    // ProjectMaterials
    $api->get('project_materials', 'App\Http\Controllers\ProjectMaterialController@index');
    $api->get('project_materials/index_export', 'App\Http\Controllers\ProjectMaterialController@index_export');
    $api->get('project_materials/datatables', 'App\Http\Controllers\ProjectMaterialController@datatables');
    $api->get('project_materials/{id}', 'App\Http\Controllers\ProjectMaterialController@show');
    $api->post('project_materials', 'App\Http\Controllers\ProjectMaterialController@store');
    $api->patch('project_materials/{id}', 'App\Http\Controllers\ProjectMaterialController@update');
    $api->delete('project_materials/{id}', 'App\Http\Controllers\ProjectMaterialController@destroy');


     // ProjectMaterials
    $api->get('project_debit_credit', 'App\Http\Controllers\ProjectDebitCreditController@index');
    $api->get('project_debit_credit/datatables', 'App\Http\Controllers\ProjectDebitCreditController@datatables');
    $api->get('project_debit_credit/{id}', 'App\Http\Controllers\ProjectDebitCreditController@show');
    $api->post('project_debit_credit', 'App\Http\Controllers\ProjectDebitCreditController@store');
    $api->patch('project_debit_credit/{id}', 'App\Http\Controllers\ProjectDebitCreditController@update');
    $api->delete('project_debit_credit/{id}', 'App\Http\Controllers\ProjectDebitCreditController@destroy');

    // ProjectBoard
    $api->get('project_board/{id}/update_from_contract', 'App\Http\Controllers\ProjectBoardController@update_from_contract');

    // Invoices
    $api->get('invoices', 'App\Http\Controllers\InvoiceController@index');
    $api->get('invoices/datatables', 'App\Http\Controllers\InvoiceController@datatables');
    $api->get('invoices/{id}/count_rows', 'App\Http\Controllers\InvoiceController@countRows');
    $api->get('invoices/{id}/update_from_project_board', 'App\Http\Controllers\InvoiceController@update_from_project_board');
    $api->get('invoices/{id}', 'App\Http\Controllers\InvoiceController@show');
    $api->post('invoices', 'App\Http\Controllers\InvoiceController@store');
    $api->patch('invoices/{id}', 'App\Http\Controllers\InvoiceController@update');
    $api->delete('invoices/{id}', 'App\Http\Controllers\InvoiceController@destroy');
    $api->get('invoices/{id}/update_total', 'App\Http\Controllers\InvoiceController@update_total');



    // Qotations
    $api->get('quotation', 'App\Http\Controllers\QuotationController@index');
    $api->get('quotation/datatables', 'App\Http\Controllers\QuotationController@datatables');
    $api->get('quotation/{id}/count_rows', 'App\Http\Controllers\QuotationController@countRows');
    $api->get('quotation/{id}/update_from_project_board', 'App\Http\Controllers\QuotationController@update_from_project_board');
    $api->get('quotation/{id}', 'App\Http\Controllers\QuotationController@show');
    $api->post('quotation', 'App\Http\Controllers\QuotationController@store');
    $api->patch('quotation/{id}', 'App\Http\Controllers\QuotationController@update');
    $api->delete('quotation/{id}', 'App\Http\Controllers\QuotationController@destroy');
    $api->get('quotation/{id}/update_total', 'App\Http\Controllers\QuotationController@update_total');



    // InvoiceResources
    $api->get('invoice_resources', 'App\Http\Controllers\InvoiceResourceController@index');
    $api->get('invoice_resources/datatables', 'App\Http\Controllers\InvoiceResourceController@datatables');
    $api->get('invoice_resources/{id}', 'App\Http\Controllers\InvoiceResourceController@show');
    $api->post('invoice_resources', 'App\Http\Controllers\InvoiceResourceController@store');
    $api->patch('invoice_resources/{id}', 'App\Http\Controllers\InvoiceResourceController@update');
    $api->delete('invoice_resources/{id}', 'App\Http\Controllers\InvoiceResourceController@destroy');



    // QuotationResources
    $api->get('quotation_resources', 'App\Http\Controllers\QuotationResourceController@index');
    $api->get('quotation_resources/datatables', 'App\Http\Controllers\QuotationResourceController@datatables');
    $api->get('quotation_resources/{id}', 'App\Http\Controllers\QuotationResourceController@show');
    $api->post('quotation_resources', 'App\Http\Controllers\QuotationResourceController@store');
    $api->patch('quotation_resources/{id}', 'App\Http\Controllers\QuotationResourceController@update');
    $api->delete('quotation_resources/{id}', 'App\Http\Controllers\QuotationResourceController@destroy');


    // InvoiceExpenses
    $api->get('invoice_expenses', 'App\Http\Controllers\InvoiceExpenseController@index');
    $api->get('invoice_expenses/datatables', 'App\Http\Controllers\InvoiceExpenseController@datatables');
    $api->get('invoice_expenses/{id}', 'App\Http\Controllers\InvoiceExpenseController@show');
    $api->post('invoice_expenses', 'App\Http\Controllers\InvoiceExpenseController@store');
    $api->patch('invoice_expenses/{id}', 'App\Http\Controllers\InvoiceExpenseController@update');
    $api->delete('invoice_expenses/{id}', 'App\Http\Controllers\InvoiceExpenseController@destroy');


    // InvoiceExpenses
    $api->get('quotation_expenses', 'App\Http\Controllers\QuotationExpenseController@index');
    $api->get('quotation_expenses/datatables', 'App\Http\Controllers\QuotationExpenseController@datatables');
    $api->get('quotation_expenses/{id}', 'App\Http\Controllers\QuotationExpenseController@show');
    $api->post('quotation_expenses', 'App\Http\Controllers\QuotationExpenseController@store');
    $api->patch('quotation_expenses/{id}', 'App\Http\Controllers\QuotationExpenseController@update');
    $api->delete('quotation_expenses/{id}', 'App\Http\Controllers\QuotationExpenseController@destroy');


    // InvoiceServices
    $api->get('invoice_services', 'App\Http\Controllers\InvoiceServiceController@index');
    $api->get('invoice_services/datatables', 'App\Http\Controllers\InvoiceServiceController@datatables');
    $api->get('invoice_services/{id}', 'App\Http\Controllers\InvoiceServiceController@show');
    $api->post('invoice_services', 'App\Http\Controllers\InvoiceServiceController@store');
    $api->patch('invoice_services/{id}', 'App\Http\Controllers\InvoiceServiceController@update');
    $api->delete('invoice_services/{id}', 'App\Http\Controllers\InvoiceServiceController@destroy');

    // InvoiceServices
    $api->get('quotation_services', 'App\Http\Controllers\QuotationServiceController@index');
    $api->get('quotation_services/datatables', 'App\Http\Controllers\QuotationServiceController@datatables');
    $api->get('quotation_services/datatables_grouped', 'App\Http\Controllers\QuotationServiceController@datatables_grouped');
    $api->get('quotation_services/{id}', 'App\Http\Controllers\QuotationServiceController@show');
    $api->post('quotation_services', 'App\Http\Controllers\QuotationServiceController@store');
    $api->patch('quotation_services/{id}', 'App\Http\Controllers\QuotationServiceController@update');
    $api->delete('quotation_services/{id}', 'App\Http\Controllers\QuotationServiceController@destroy');



    // InvoiceMaterials
    $api->get('invoice_materials', 'App\Http\Controllers\InvoiceMaterialController@index');
    $api->get('invoice_materials/datatables', 'App\Http\Controllers\InvoiceMaterialController@datatables');
    $api->get('invoice_materials/{id}', 'App\Http\Controllers\InvoiceMaterialController@show');
    $api->post('invoice_materials', 'App\Http\Controllers\InvoiceMaterialController@store');
    $api->patch('invoice_materials/{id}', 'App\Http\Controllers\InvoiceMaterialController@update');
    $api->delete('invoice_materials/{id}', 'App\Http\Controllers\InvoiceMaterialController@destroy');


// InvoiceDebitCredit
    $api->get('invoice_debit_credit', 'App\Http\Controllers\InvoiceDebitCreditController@index');
    $api->get('invoice_debit_credit/datatables', 'App\Http\Controllers\InvoiceDebitCreditController@datatables');
    $api->get('invoice_debit_credit/{id}', 'App\Http\Controllers\InvoiceDebitCreditController@show');
    $api->post('invoice_debit_credit', 'App\Http\Controllers\InvoiceDebitCreditController@store');
    $api->patch('invoice_debit_credit/{id}', 'App\Http\Controllers\InvoiceDebitCreditController@update');
    $api->delete('invoice_debit_credit/{id}', 'App\Http\Controllers\InvoiceDebitCreditController@destroy');



    // InvoiceMaterials
    $api->get('quotation_materials', 'App\Http\Controllers\QuotationMaterialController@index');
    $api->get('quotation_materials/datatables', 'App\Http\Controllers\QuotationMaterialController@datatables');
    $api->get('quotation_materials/{id}', 'App\Http\Controllers\QuotationMaterialController@show');
    $api->post('quotation_materials', 'App\Http\Controllers\QuotationMaterialController@store');
    $api->patch('quotation_materials/{id}', 'App\Http\Controllers\QuotationMaterialController@update');
    $api->delete('quotation_materials/{id}', 'App\Http\Controllers\QuotationMaterialController@destroy');


    // InvoiceDiscounts
    $api->get('invoice_discounts', 'App\Http\Controllers\InvoiceDiscountController@index');
    $api->get('invoice_discounts/datatables', 'App\Http\Controllers\InvoiceDiscountController@datatables');
    $api->get('invoice_discounts/{id}', 'App\Http\Controllers\InvoiceDiscountController@show');
    $api->post('invoice_discounts', 'App\Http\Controllers\InvoiceDiscountController@store');
    $api->patch('invoice_discounts/{id}', 'App\Http\Controllers\InvoiceDiscountController@update');
    $api->delete('invoice_discounts/{id}', 'App\Http\Controllers\InvoiceDiscountController@destroy');

    // InvoiceTaxes
    $api->get('invoice_taxes', 'App\Http\Controllers\InvoiceTaxController@index');
    $api->get('invoice_taxes/datatables', 'App\Http\Controllers\InvoiceTaxController@datatables');
    $api->get('invoice_taxes/{id}', 'App\Http\Controllers\InvoiceTaxController@show');
    $api->post('invoice_taxes', 'App\Http\Controllers\InvoiceTaxController@store');
    $api->patch('invoice_taxes/{id}', 'App\Http\Controllers\InvoiceTaxController@update');
    $api->delete('invoice_taxes/{id}', 'App\Http\Controllers\InvoiceTaxController@destroy');

    // Providers
    $api->get('providers', 'App\Http\Controllers\ProviderController@index');
    $api->get('providers/datatables', 'App\Http\Controllers\ProviderController@datatables');
    $api->get('providers/{id}', 'App\Http\Controllers\ProviderController@show');
    $api->post('providers', 'App\Http\Controllers\ProviderController@store');
    $api->patch('providers/{id}', 'App\Http\Controllers\ProviderController@update');
    $api->delete('providers/{id}', 'App\Http\Controllers\ProviderController@destroy');

    // Procurements
    $api->get('procurements', 'App\Http\Controllers\ProcurementController@index');
    $api->get('procurements/datatables', 'App\Http\Controllers\ProcurementController@datatables');
    $api->get('procurements/{id}', 'App\Http\Controllers\ProcurementController@show');
    $api->post('procurements', 'App\Http\Controllers\ProcurementController@store');
    $api->patch('procurements/{id}', 'App\Http\Controllers\ProcurementController@update');
    $api->delete('procurements/{id}', 'App\Http\Controllers\ProcurementController@destroy');

    // ProcurementResources
    $api->get('procurement_offers', 'App\Http\Controllers\ProcurementOfferController@index');
    $api->get('procurement_offers/datatables', 'App\Http\Controllers\ProcurementOfferController@datatables');
    $api->get('procurement_offers/{id}', 'App\Http\Controllers\ProcurementOfferController@show');
    $api->post('procurement_offers', 'App\Http\Controllers\ProcurementOfferController@store');
    $api->patch('procurement_offers/{id}', 'App\Http\Controllers\ProcurementOfferController@update');
    $api->delete('procurement_offers/{id}', 'App\Http\Controllers\ProcurementOfferController@destroy');

    // Requirements
    $api->get('requirements', 'App\Http\Controllers\RequirementController@index');
    $api->get('requirements/datatables', 'App\Http\Controllers\RequirementController@datatables');
    $api->get('requirements/{id}', 'App\Http\Controllers\RequirementController@show');
    $api->post('requirements', 'App\Http\Controllers\RequirementController@store');
    $api->patch('requirements/{id}', 'App\Http\Controllers\RequirementController@update');
    $api->delete('requirements/{id}', 'App\Http\Controllers\RequirementController@destroy');

    // Tasks
    $api->get('tasks', 'App\Http\Controllers\TaskController@index');
    $api->get('tasks/index_export', 'App\Http\Controllers\TaskController@index_export');

    $api->get('tasks/datatables', 'App\Http\Controllers\TaskController@datatables');
    $api->post('tasks/phases', 'App\Http\Controllers\TaskController@phases');
    $api->get('tasks/{id}', 'App\Http\Controllers\TaskController@show');
    $api->post('tasks', 'App\Http\Controllers\TaskController@store');
    $api->post('tasks/store/all', 'App\Http\Controllers\TaskController@storeAll');
    $api->post('tasks/{id}', 'App\Http\Controllers\TaskController@update');
    $api->post('tasks/update/all', 'App\Http\Controllers\TaskController@updateAll');
    $api->delete('tasks/{id}', 'App\Http\Controllers\TaskController@destroy');
    $api->delete('tasks/delete/all', 'App\Http\Controllers\TaskController@destroyAll');





    // Tickets
    $api->get('tickets', 'App\Http\Controllers\TicketController@index');
    $api->get('tickets/datatables', 'App\Http\Controllers\TicketController@datatables');
    $api->get('tickets/by_phase', 'App\Http\Controllers\TicketController@byPhase');
    $api->get('tickets/{id}', 'App\Http\Controllers\TicketController@show');
    $api->post('tickets', 'App\Http\Controllers\TicketController@store');
    $api->patch('tickets/{id}', 'App\Http\Controllers\TicketController@update');
    $api->delete('tickets/{id}', 'App\Http\Controllers\TicketController@destroy');

    // TicketsHistory
    $api->get('ticket_histories', 'App\Http\Controllers\TicketHistoryController@index');
    $api->get('ticket_histories/datatables', 'App\Http\Controllers\TicketHistoryController@datatables');
    $api->get('ticket_histories/{id}', 'App\Http\Controllers\TicketHistoryController@show');
    $api->post('ticket_histories', 'App\Http\Controllers\TicketHistoryController@store');
    $api->patch('ticket_histories/{id}', 'App\Http\Controllers\TicketHistoryController@update');
    $api->delete('ticket_histories/{id}', 'App\Http\Controllers\TicketHistoryController@destroy');

    // TaskResources
    $api->get('task_resources', 'App\Http\Controllers\TaskResourceController@index');
    $api->get('task_resources/datatables', 'App\Http\Controllers\TaskResourceController@datatables');
     $api->get('task_resources/index_export', 'App\Http\Controllers\TaskResourceController@index_export');
    $api->get('task_resources/{id}', 'App\Http\Controllers\TaskResourceController@show');
    $api->post('task_resources', 'App\Http\Controllers\TaskResourceController@store');
    $api->patch('task_resources/{id}', 'App\Http\Controllers\TaskResourceController@update');
    $api->delete('task_resources/{id}', 'App\Http\Controllers\TaskResourceController@destroy');

    // TaskServices
    $api->get('task_services', 'App\Http\Controllers\TaskServiceController@index');
    $api->get('task_services/datatables', 'App\Http\Controllers\TaskServiceController@datatables');
     $api->get('task_services/index_export', 'App\Http\Controllers\TaskServiceController@index_export');

    $api->get('task_services/{id}', 'App\Http\Controllers\TaskServiceController@show');
    $api->post('task_services', 'App\Http\Controllers\TaskServiceController@store');
    $api->patch('task_services/{id}', 'App\Http\Controllers\TaskServiceController@update');
    $api->delete('task_services/{id}', 'App\Http\Controllers\TaskServiceController@destroy');

    // TaskMaterials
    $api->get('task_materials', 'App\Http\Controllers\TaskMaterialController@index');
    $api->get('task_materials/datatables', 'App\Http\Controllers\TaskMaterialController@datatables');
      $api->get('task_materials/index_export', 'App\Http\Controllers\TaskMaterialController@index_export');
    $api->get('task_materials/{id}', 'App\Http\Controllers\TaskMaterialController@show');
    $api->post('task_materials', 'App\Http\Controllers\TaskMaterialController@store');
    $api->patch('task_materials/{id}', 'App\Http\Controllers\TaskMaterialController@update');
    $api->delete('task_materials/{id}', 'App\Http\Controllers\TaskMaterialController@destroy');

    // TaskExpenses
    $api->get('task_expenses', 'App\Http\Controllers\TaskExpenseController@index');
    $api->get('task_expenses/datatables', 'App\Http\Controllers\TaskExpenseController@datatables');
    $api->get('task_expenses/index_export', 'App\Http\Controllers\TaskExpenseController@index_export');
    $api->get('task_expenses/{id}', 'App\Http\Controllers\TaskExpenseController@show');
    $api->post('task_expenses', 'App\Http\Controllers\TaskExpenseController@store');
    $api->patch('task_expenses/{id}', 'App\Http\Controllers\TaskExpenseController@update');
    $api->delete('task_expenses/{id}', 'App\Http\Controllers\TaskExpenseController@destroy');

    // Notes
    $api->get('notes', 'App\Http\Controllers\NoteController@index');
    $api->get('notes/{id}', 'App\Http\Controllers\NoteController@show');
    $api->post('notes', 'App\Http\Controllers\NoteController@store');
    $api->patch('notes/{id}', 'App\Http\Controllers\NoteController@update');
    $api->delete('notes/{id}', 'App\Http\Controllers\NoteController@destroy');

    //Profit and loss

    $api->get('profit_and_loss/team', 'App\Http\Controllers\ProfitAndLossController@team');
    $api->get('profit_and_loss/services', 'App\Http\Controllers\ProfitAndLossController@services');
    $api->get('profit_and_loss/materials', 'App\Http\Controllers\ProfitAndLossController@materials');
    $api->get('profit_and_loss/expenses', 'App\Http\Controllers\ProfitAndLossController@expenses');

// Forecast

       $api->get('forecast/team', 'App\Http\Controllers\ForecastController@team');
    $api->get('forecast/services', 'App\Http\Controllers\ForecastController@services');
    $api->get('forecast/materials', 'App\Http\Controllers\ForecastController@materials');
    $api->get('forecast/expenses', 'App\Http\Controllers\ForecastController@expenses');


 // Settings
    $api->get('settings', 'App\Http\Controllers\SettingsController@index');
    $api->post('settings/{id}', 'App\Http\Controllers\SettingsController@update');

// Sprints
    $api->get('sprints', 'App\Http\Controllers\SprintsController@index');
    $api->get('sprints/projects/{id}', 'App\Http\Controllers\SprintsController@projects');
    $api->get('sprints/datatables', 'App\Http\Controllers\SprintsController@datatables');
    $api->get('sprints/{id}', 'App\Http\Controllers\SprintsController@show');
    $api->post('sprints', 'App\Http\Controllers\SprintsController@store');
    $api->patch('sprints/{id}', 'App\Http\Controllers\SprintsController@update');
    $api->delete('sprints/{id}', 'App\Http\Controllers\SprintsController@destroy');


  // Audit Log
    $api->get('audit_log', 'App\Http\Controllers\AuditlogController@index');
    $api->get('audit_log/datatables', 'App\Http\Controllers\AuditlogController@datatables');
    $api->get('audit_log/{id}', 'App\Http\Controllers\AuditlogController@show');
    $api->post('audit_log', 'App\Http\Controllers\AuditlogController@store');
    $api->patch('audit_log/{id}', 'App\Http\Controllers\AuditlogController@update');
    $api->delete('audit_log/{id}', 'App\Http\Controllers\AuditlogController@destroy');

//Metadocuments
    $api->get('metadocuments', 'App\Http\Controllers\MetadocumentsController@index');
    $api->get('metadocuments/datatables', 'App\Http\Controllers\MetadocumentsController@datatables');
    $api->post('metadocuments', 'App\Http\Controllers\MetadocumentsController@store');
    $api->get('metadocuments/{id}', 'App\Http\Controllers\MetadocumentsController@show');
    $api->patch('metadocuments/{id}', 'App\Http\Controllers\MetadocumentsController@update');
    $api->delete('metadocuments/{id}', 'App\Http\Controllers\MetadocumentsController@destroy');
    $api->get('metavariables/{lang}/{file}', 'App\Http\Controllers\MetavariablesController@index');
    $api->get('metavariables/datatables', 'App\Http\Controllers\MetavariablesController@datatables');
    $api->post('metavariables', 'App\Http\Controllers\MetavariablesController@store');
    $api->get('metavariables/{id}', 'App\Http\Controllers\MetavariablesController@show');
    $api->patch('metavariables/{id}', 'App\Http\Controllers\MetavariablesController@update');
    $api->delete('metavariables/{id}', 'App\Http\Controllers\MetavariablesController@destroy');
//Metavariable Kinds
    $api->get('metavariable_kinds', 'App\Http\Controllers\MetavariablesController@getMetavariableKinds');

//Metagrids
    $api->get('metagrids/{lang}/{file}', 'App\Http\Controllers\MetagridsController@index');
    $api->get('metagrids/datatables', 'App\Http\Controllers\MetagridsController@datatables');
    $api->post('metagrids', 'App\Http\Controllers\MetagridsController@store');
    $api->get('metagrids/{id}', 'App\Http\Controllers\MetagridsController@show');
    $api->patch('metagrids/{id}', 'App\Http\Controllers\MetagridsController@update');
    $api->delete('metagrids/{id}', 'App\Http\Controllers\MetagridsController@destroy');
    

//Activities
    $api->get('activities', 'App\Http\Controllers\ActivitiesController@index');


//IredMail
    $api->post('irmdomain', 'App\Http\Controllers\IredmailController@storeDomain');
    $api->get('irmdomain/{id}', 'App\Http\Controllers\IredmailController@showDomain');
    $api->get('domain/fromUser/{id}', 'App\Http\Controllers\IredmailController@showUserDomain');
//Mail
    $api->post('irmmail', 'App\Http\Controllers\IredmailController@storeMail');
    $api->get('irmmail/{mail}', 'App\Http\Controllers\IredmailController@showMail');
//Admin-mail
    $api->post('irmmailadm', 'App\Http\Controllers\IredmailController@storeAdminMail');
//Show-All
    $api->get('iredmail/domains', 'App\Http\Controllers\IredmailController@getDomains');
    $api->get('iredmail/mails', 'App\Http\Controllers\IredmailController@getMails');
//rocketchat
    $api->get('rcusers','App\Http\Controllers\RocketchatController@showRocketChatUsers');
    $api->get('rcchannels','App\Http\Controllers\RocketchatController@showRocketChatChannels');
    $api->post('rcadmin','App\Http\Controllers\RocketchatController@storeAdmin');
    $api->post('rcuser','App\Http\Controllers\RocketchatController@storeUser');
    $api->post('rcgeneralchannel','App\Http\Controllers\RocketchatController@storeGeneralChannel');
    $api->post('rcworkgroupchannel','App\Http\Controllers\RocketchatController@storeWorkGroupChannel');
    $api->post('rcprojectchannel','App\Http\Controllers\RocketchatController@storeProjectChannel');
    $api->post('rcjoingeneralrooms','App\Http\Controllers\RocketchatController@joinGeneralRooms');


 // WHatIf
    $api->get('whatif', 'App\Http\Controllers\WhatIfController@index');
    $api->get('whatif/datatables', 'App\Http\Controllers\WhatIfController@datatables');
    $api->get('whatif/{id}', 'App\Http\Controllers\WhatIfController@show');
    $api->post('whatif', 'App\Http\Controllers\WhatIfController@store');
    $api->patch('whatif/{id}', 'App\Http\Controllers\WhatIfController@update');
    $api->delete('whatif/{id}', 'App\Http\Controllers\WhatIfController@destroy');


// WHatIf Tasks
    $api->get('whatif_task', 'App\Http\Controllers\WhatIfTaskController@index');
    $api->get('whatif_task/datatables', 'App\Http\Controllers\WhatIfTaskController@datatables');
    $api->post('whatif_task/phases', 'App\Http\Controllers\WhatIfTaskController@phases');
    $api->get('whatif_task/{id}', 'App\Http\Controllers\WhatIfTaskController@show');
    $api->post('whatif_task', 'App\Http\Controllers\WhatIfTaskController@store');
    $api->post('whatif_task/store/all', 'App\Http\Controllers\WhatIfTaskController@storeAll');
    $api->post('whatif_task/{id}', 'App\Http\Controllers\WhatIfTaskController@update');
    $api->post('whatif_task/update/all', 'App\Http\Controllers\WhatIfTaskController@updateAll');
    $api->delete('whatif_task/{id}', 'App\Http\Controllers\WhatIfTaskController@destroy');
    $api->delete('whatif_task/delete/all', 'App\Http\Controllers\WhatIfTaskController@destroyAll');


    // WHatIf TaskResources
    $api->get('whatif_task_resources', 'App\Http\Controllers\WhatIfTaskResourceController@index');
    $api->get('whatif_task_resources/datatables', 'App\Http\Controllers\WhatIfTaskResourceController@datatables');
    $api->get('whatif_task_resources/{id}', 'App\Http\Controllers\WhatIfTaskResourceController@show');
    $api->post('whatif_task_resources', 'App\Http\Controllers\WhatIfTaskResourceController@store');
    $api->patch('whatif_task_resources/{id}', 'App\Http\Controllers\WhatIfTaskResourceController@update');
    $api->delete('whatif_task_resources/{id}', 'App\Http\Controllers\WhatIfTaskResourceController@destroy');

    // WHatIf TaskServices
    $api->get('whatif_task_services', 'App\Http\Controllers\WhatIfTaskServiceController@index');
    $api->get('whatif_task_services/datatables', 'App\Http\Controllers\WhatIfTaskServiceController@datatables');

    $api->get('whatif_task_services/{id}', 'App\Http\Controllers\WhatIfTaskServiceController@show');
    $api->post('whatif_task_services', 'App\Http\Controllers\WhatIfTaskServiceController@store');
    $api->patch('whatif_task_services/{id}', 'App\Http\Controllers\WhatIfTaskServiceController@update');
    $api->delete('whatif_task_services/{id}', 'App\Http\Controllers\WhatIfTaskServiceController@destroy');

    // WHatIf TaskMaterials
    $api->get('whatif_task_materials', 'App\Http\Controllers\WhatIfTaskMaterialController@index');
    $api->get('whatif_task_materials/datatables', 'App\Http\Controllers\WhatIfTaskMaterialController@datatables');
    $api->get('whatif_task_materials/{id}', 'App\Http\Controllers\WhatIfTaskMaterialController@show');
    $api->post('whatif_task_materials', 'App\Http\Controllers\WhatIfTaskMaterialController@store');
    $api->patch('whatif_task_materials/{id}', 'App\Http\Controllers\WhatIfTaskMaterialController@update');
    $api->delete('whatif_task_materials/{id}', 'App\Http\Controllers\WhatIfTaskMaterialController@destroy');

    // WHatIf TaskExpenses
    $api->get('whatif_task_expenses', 'App\Http\Controllers\WhatIfTaskExpenseController@index');
    $api->get('whatif_task_expenses/datatables', 'App\Http\Controllers\WhatIfTaskExpenseController@datatables');
    $api->get('whatif_task_expenses/{id}', 'App\Http\Controllers\WhatIfTaskExpenseController@show');
    $api->post('whatif_task_expenses', 'App\Http\Controllers\WhatIfTaskExpenseController@store');
    $api->patch('whatif_task_expenses/{id}', 'App\Http\Controllers\WhatIfTaskExpenseController@update');
    $api->delete('whatif_task_expenses/{id}', 'App\Http\Controllers\WhatIfTaskExpenseController@destroy');

    //Wiki
    $api->get('wiki', 'App\Http\Controllers\WikiController@index');
    $api->get('wiki/datatables', 'App\Http\Controllers\WikiController@datatables');
    $api->get('wiki/{id}', 'App\Http\Controllers\WikiController@show');
    $api->post('wiki', 'App\Http\Controllers\WikiController@store');
    $api->patch('wiki/{id}', 'App\Http\Controllers\WikiController@update');
    $api->delete('wiki/{id}', 'App\Http\Controllers\WikiController@destroy');

    // Timezones
    $api->get('timezones', 'App\Http\Controllers\TimezoneController@index');

});
