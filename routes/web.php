<?php

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/dashboard', 'DashboardController@index');

Route::get('/test', 'TestController@index');
Route::get('/test2', 'TestController@index2');

Route::get('/soon', 'SoonController@index');

// Users
Route::get('/users', 'UsersController@index');
Route::get('/main-menu/{parameter}/{parameter2}/users', 'UsersController@index');
Route::get('/users/{id}/show', 'UsersController@show');
Route::get('/users/create', 'UsersController@create');
Route::post('/users', 'UsersController@store');
Route::get('/users/{id}/edit', 'UsersController@edit');
Route::get('/users/import', 'UsersController@import');
Route::get('/users/{id}/password', 'UsersController@password');
Route::get('/users/{id}/delete', 'UsersController@delete');
Route::post('/users/update', 'UsersController@update');
Route::post('/users/do_import', 'UsersController@do_import');
Route::post('/users/update_password', 'UsersController@update_password');

// Countries
Route::get('/countries', 'CountryController@index');
Route::get('/countries/create', 'CountryController@create');
Route::post('/countries', 'CountryController@store');
Route::get('/countries/reload', 'CountryController@reload');


// Languages
Route::get('/languages', 'LanguageController@index');
Route::get('/languages/create', 'LanguageController@create');
Route::post('/languages', 'LanguageController@store');
Route::get('/languages/{id}/edit', 'LanguageController@edit');
Route::get('/languages/{id}/delete', 'LanguageController@delete');
Route::post('/languages/update', 'LanguageController@update');
Route::get('/languages/reload', 'LanguageController@reload');

// Currency
Route::get('/currencies', 'CurrencyController@index');
Route::get('/currencies/create', 'CurrencyController@create');
Route::post('/currencies', 'CurrencyController@store');
Route::get('/currencies/{id}/edit', 'CurrencyController@edit');
Route::get('/currencies/{id}/delete', 'CurrencyController@delete');
Route::post('/currencies/update', 'CurrencyController@update');
Route::get('/currencies/reload', 'CurrencyController@reload');

// Country
Route::get('/countries', 'CountryController@index');
Route::get('/countries/create', 'CountryController@create');
Route::post('/countries', 'CountryController@store');
Route::get('/countries/{id}/edit', 'CountryController@edit');
Route::get('/countries/{id}/delete', 'CountryController@delete');
Route::post('/countries/update', 'CountryController@update');

// Cities
Route::get('/cities', 'CityController@index');
Route::get('/cities/create', 'CityController@create');
Route::post('/cities', 'CityController@store');
Route::get('/cities/{id}/edit', 'CityController@edit');
Route::get('/cities/{id}/delete', 'CityController@delete');
Route::post('/cities/update', 'CityController@update');
Route::get('/cities/import', 'CityController@import');
Route::post('/cities/do_import', 'CityController@do_import');
Route::get('/cities/reload', 'CityController@reload');

// Cities template
Route::get('/cities_template', 'CityTemplateController@index');
Route::get('/cities_template/create', 'CityTemplateController@create');
Route::post('/cities_template', 'CityTemplateController@store');
Route::get('/cities_template/{id}/edit', 'CityTemplateController@edit');
Route::get('/cities_template/{id}/delete', 'CityTemplateController@delete');
Route::post('/cities_template/update', 'CityTemplateController@update');

// Industries
Route::get('/industries', 'IndustryController@index');
Route::get('/industries/create', 'IndustryController@create');
Route::post('/industries', 'IndustryController@store');
Route::get('/industries/{id}/edit', 'IndustryController@edit');
Route::get('/industries/{id}/delete', 'IndustryController@delete');
Route::post('/industries/update', 'IndustryController@update');

// Seniority Templates
Route::get('/seniority_templates', 'SeniorityTemplateController@index');
Route::get('/seniority_templates/create', 'SeniorityTemplateController@create');
Route::post('/seniority_templates', 'SeniorityTemplateController@store');
Route::get('/seniority_templates/{id}/edit', 'SeniorityTemplateController@edit');
Route::get('/seniority_templates/{id}/delete', 'SeniorityTemplateController@delete');
Route::post('/seniority_templates/update', 'SeniorityTemplateController@update');

// ProjectRole Templates
Route::get('/project_role_templates', 'ProjectRoleTemplateController@index');
Route::get('/project_role_templates/create', 'ProjectRoleTemplateController@create');
Route::post('/project_role_templates', 'ProjectRoleTemplateController@store');
Route::get('/project_role_templates/{id}/edit', 'ProjectRoleTemplateController@edit');
Route::get('/project_role_templates/{id}/delete', 'ProjectRoleTemplateController@delete');
Route::post('/project_role_templates/update', 'ProjectRoleTemplateController@update');


// CompanyRole Templates
Route::get('/company_role_templates', 'CompanyRoleTemplateController@index');
Route::get('/company_role_templates/create', 'CompanyRoleTemplateController@create');
Route::post('/company_role_templates', 'CompanyRoleTemplateController@store');
Route::get('/company_role_templates/{id}/edit', 'CompanyRoleTemplateController@edit');
Route::get('/company_role_templates/{id}/delete', 'CompanyRoleTemplateController@delete');
Route::post('/company_role_templates/update', 'CompanyRoleTemplateController@update');


// AbsenceType
Route::get('/absence_types', 'AbsenceTypeController@index');
Route::get('/absence_types/create', 'AbsenceTypeController@create');
Route::get('/absence_types/forAbsences/{country_id}', 'AbsenceTypeController@forAbsences');
Route::post('/absence_types', 'AbsenceTypeController@store');
Route::get('/absence_types/{id}/edit', 'AbsenceTypeController@edit');
Route::get('/absence_types/{id}/delete', 'AbsenceTypeController@delete');
Route::post('/absence_types/update', 'AbsenceTypeController@update');
Route::post('/absence_types/do_import', 'AbsenceTypeController@do_import');
Route::get('/absence_types/import', 'AbsenceTypeController@import');
Route::get('/absence_types/reload', 'AbsenceTypeController@reload');

// AbsenceTypeTemplate
Route::get('/absence_types_template', 'AbsenceTypeTemplateController@index');
Route::get('/absence_types_template/create', 'AbsenceTypeTemplateController@create');
Route::post('/absence_types_template', 'AbsenceTypeTemplateController@store');
Route::get('/absence_types_template/{id}/edit', 'AbsenceTypeTemplateController@edit');
Route::get('/absence_types_template/{id}/delete', 'AbsenceTypeTemplateController@delete');
Route::post('/absence_types_template/update', 'AbsenceTypeTemplateController@update');

// Profile
Route::get('/profile', 'ProfileController@show');
Route::post('/profile/update', 'ProfileController@update');
Route::post('/profile/upload/{id}', 'ProfileController@upload');
Route::get('/profile/edit', 'ProfileController@edit');

// Companies for admin
Route::get('/admin_companies', 'AdminCompanyController@index');
Route::get('/admin_companies/create', 'AdminCompanyController@create');
Route::get('/admin_companies/{id}', 'AdminCompanyController@show');
Route::post('/admin_companies', 'AdminCompanyController@store');
Route::get('/admin_companies/{id}/edit', 'AdminCompanyController@edit');
Route::get('/admin_companies/{id}/delete', 'AdminCompanyController@delete');
Route::post('/admin_companies/update', 'AdminCompanyController@update');

// Companies
Route::get('/companies', 'CompanyController@show');
Route::get('/companies/edit', 'CompanyController@edit');
Route::patch('/companies/update', 'CompanyController@update');

// Customers
Route::get('/customers', 'CustomerController@index');
Route::get('/customers/forProjectSelection', 'CustomerController@forProjectSelection');
Route::get('/customers/forProjectSelectionButton/{customer_id}', 'CustomerController@forProjectSelectionButton');


Route::get('/customers/import', 'CustomerController@import');
Route::get('/customers/{id}', 'CustomerController@show');

Route::get('/customers/create', 'CustomerController@create');
Route::post('/customers', 'CustomerController@store');
Route::get('/customers/{id}/delete', 'CustomerController@delete');
Route::get('/customers/{id}/edit', 'CustomerController@edit');

Route::post('/customers/update', 'CustomerController@update');
Route::post('/customers/do_import', 'CustomerController@do_import');

// // Studios
// Route::get('/studios/create', 'StudioController@create');
// Route::post('/studios', 'StudioController@store');
// Route::get('/studios/{id}/edit', 'StudioController@edit');
// Route::get('/studios/{id}/delete', 'StudioController@delete');
// Route::post('/studios/update', 'StudioController@update');

// Seniorities
Route::get('/seniorities/create', 'SeniorityController@create');
Route::post('/seniorities', 'SeniorityController@store');
Route::get('/seniorities/{id}/edit', 'SeniorityController@edit');
Route::get('/seniorities/{id}/delete', 'SeniorityController@delete');
Route::post('/seniorities/update', 'SeniorityController@update');

// Company Roles
Route::get('/company_roles/create', 'CompanyRoleController@create');
Route::post('/company_roles', 'CompanyRoleController@store');
Route::get('/company_roles/{id}/edit', 'CompanyRoleController@edit');
Route::get('/company_roles/{id}/delete', 'CompanyRoleController@delete');
Route::post('/company_roles/update', 'CompanyRoleController@update');
Route::get('/company_roles/import', 'CompanyRoleController@import');
Route::post('/company_roles/do_import', 'CompanyRoleController@do_import');
// Project Roles
Route::get('/project_roles/create', 'ProjectRoleController@create');
Route::post('/project_roles', 'ProjectRoleController@store');
Route::get('/project_roles/{id}/edit', 'ProjectRoleController@edit');
Route::get('/project_roles/{id}/delete', 'ProjectRoleController@delete');
Route::post('/project_roles/update', 'ProjectRoleController@update');

// Companies Exchange Rates
Route::get('/companies/{company_id}/exchange_rates', 'CompanyExchangeRateController@index');
Route::get('/companies/{company_id}/exchange_rates/create', 'CompanyExchangeRateController@create');
Route::post('/companies/{id}/exchange_rates', 'CompanyExchangeRateController@store');
Route::get('/companies/{company_id}/exchange_rates/{id}/edit', 'CompanyExchangeRateController@edit');
Route::post('/companies/{company_id}/exchange_rates/update', 'CompanyExchangeRateController@update');
Route::get('/companies/{company_id}/exchange_rates/{id}/delete', 'CompanyExchangeRateController@delete');

// Workgroups
Route::post('/workgroups', 'WorkgroupController@store');
Route::get('/workgroups/{id}/delete', 'WorkgroupController@delete');
Route::post('/workgroups/update', 'WorkgroupController@update');

// HolidaysTemplates
Route::get('/holidays_templates', 'HolidayTemplateController@index');
Route::get('/holidays_templates/create', 'HolidayTemplateController@create');
Route::post('/holidays_templates', 'HolidayTemplateController@store');
Route::get('/holidays_templates/{id}/edit', 'HolidayTemplateController@edit');
Route::get('/holidays_templates/{id}/delete', 'HolidayTemplateController@delete');
Route::post('/holidays_templates/update', 'HolidayTemplateController@update');

//Catalog
Route::get('/catalog', 'CatalogController@index');
Route::get('/catalog/{parameter}/view/{lang_system}/{type}/{directory}', 'CatalogController@index');


Route::get('/catalog/form', 'CatalogController@form');
Route::get('/catalog/show/{lang_system}/{type}/{directory}', 'CatalogController@show');


Route::get('/catalog/download/', 'CatalogController@download');
Route::post('/catalog/uploadfile', 'CatalogController@uploadFile');
Route::get('/catalog/delete/', 'CatalogController@delete');
//Repository
Route::get('/repository', 'RepositoryController@index');
Route::get('/repository/view/{customer_name}/{project_name}/{lang}/{process_group}/{knowledge_area}/{directory}', 'RepositoryController@index');

Route::get('/repository/form', 'RepositoryController@form');

//Route::get('/repository/show/{customer}/{project}/{directory}', 'RepositoryController@show')->where('directory', '(.*)');
 Route::get('/repository/show/{customer_name}/{project_name}/{lang}/{process_group}/{knowledge_area}/{directory}', 'RepositoryController@show');
Route::get('/repository/download/', 'RepositoryController@download');
Route::get('/repository/delete/', 'RepositoryController@delete');
Route::post('/repository/uploadfile', 'RepositoryController@uploadFile');

//Repository
Route::get('/repository_backup', 'RepositoryBackupController@index');
Route::get('/main-menu/{parameter}/repository_backup', 'RepositoryBackupController@index');
Route::post('/repository_backup/download', 'RepositoryBackupController@download');
Route::post('/repository_backup/validate_download', 'RepositoryBackupController@validate_download');


// Holidays
Route::get('/holidays', 'HolidayController@index');
Route::get('/holidays/create', 'HolidayController@create');
Route::post('/holidays', 'HolidayController@store');
Route::get('/holidays/{id}/edit', 'HolidayController@edit');
Route::get('/holidays/{id}/delete', 'HolidayController@delete');
Route::post('/holidays/update', 'HolidayController@update');
Route::get('/holidays/reload', 'HolidayController@reload');

// Costs
Route::get('/costs', 'CostController@index');
Route::get('/costs/create', 'CostController@create');
Route::post('/costs', 'CostController@store');
Route::get('/costs/{id}/edit', 'CostController@edit');
Route::get('/costs/{id}/delete', 'CostController@delete');
Route::post('/costs/update', 'CostController@update');

// Email Category Templates
Route::get('/email_category_templates', 'EmailCategoryTemplateController@index');
Route::get('/email_category_templates/create', 'EmailCategoryTemplateController@create');
Route::post('/email_category_templates', 'EmailCategoryTemplateController@store');
Route::get('/email_category_templates/{id}/edit', 'EmailCategoryTemplateController@edit');
Route::get('/email_category_templates/{id}/delete', 'EmailCategoryTemplateController@delete');
Route::post('/email_category_templates/update', 'EmailCategoryTemplateController@update');

// Email Templates
Route::get('/email_templates', 'EmailTemplateController@index');
Route::get('/email_templates/create', 'EmailTemplateController@create');
Route::post('/email_templates', 'EmailTemplateController@store');
Route::get('/email_templates/{id}/edit', 'EmailTemplateController@edit');
Route::get('/email_templates/{id}/delete', 'EmailTemplateController@delete');
Route::post('/email_templates/update', 'EmailTemplateController@update');

// Emails
Route::get('/emails', 'EmailController@index');
Route::get('/emails/templates', 'EmailController@templates');
Route::get('/emails/create', 'EmailController@create');
Route::post('/emails', 'EmailController@store');
Route::get('/emails/{id}/edit', 'EmailController@edit');
Route::get('/emails/{id}/edit_category', 'EmailController@editCategory');

Route::get('/emails/{id}/delete_category', 'EmailController@delete_category');
Route::get('/emails/{id}/delete', 'EmailController@delete');
Route::post('/emails/update', 'EmailController@update');
Route::post('/emails/update_category', 'EmailController@updateCategory');
Route::post('/emails/send', 'EmailController@send');

// Projects
Route::get('/projects', 'ProjectController@index');
Route::get('/main-menu/{parameter}/{parameter2}/projects', 'ProjectController@index');
Route::get('/projects/create', 'ProjectController@create');
Route::post('/projects/select', 'ProjectController@select');
Route::get('/projects/forProjectSelection/{customer_id}', 'ProjectController@forProjectSelection');
Route::get('/projects/forProjectSelectionButton/{customer_id}', 'ProjectController@forProjectSelectionButton');
Route::get('/projects/forContracts/{customer_id}', 'ProjectController@forContracts');
Route::post('/projects', 'ProjectController@store');
Route::get('/projects/{id}/edit', 'ProjectController@edit');
Route::get('/projects/{id}/pdf', 'ProjectController@pdf');

Route::post('/projects/delete', 'ProjectController@delete');
Route::post('/projects/update', 'ProjectController@update');
Route::get('/projects/{id}/show', 'ProjectController@show');
Route::post('projects/validate_download', 'ProjectController@validate_download');

// Capacity Planing
Route::get('/capacity_planing', 'CapacityPlanningController@index');
Route::get('/capacity_planing/datatables', 'CapacityPlanningController@datatables');

Route::get('/risk_report', 'RiskReportController@index');
Route::get('/risk_report/excel', 'RiskReportController@excel');
Route::get('/risk_report/pdf', 'RiskReportController@pdf');

Route::get('/scopechanges_report', 'ScopeChangesReportController@index');
Route::get('/main-menu/knowledge_area/scope_management/scopechanges_report', 'ScopeChangesReportController@index');
Route::get('/scopechanges_report/excel', 'ScopeChangesReportController@excel');
Route::get('/scopechanges_report/pdf', 'ScopeChangesReportController@pdf');

// Rates
Route::get('/rates', 'RateController@index');
Route::get('/rates/create', 'RateController@create');
Route::post('/rates', 'RateController@store');
Route::get('/rates/{id}/edit', 'RateController@edit');
Route::get('/rates/{id}/delete', 'RateController@delete');
Route::post('/rates/update', 'RateController@update');

// Permissions
Route::get('/permissions', 'PermissionController@index');
Route::get('/permissions/create', 'PermissionController@create');
Route::post('/permissions', 'PermissionController@store');
Route::get('/permissions/{id}/edit', 'PermissionController@edit');
Route::get('/permissions/{id}/delete', 'PermissionController@delete');
Route::post('/permissions/update', 'PermissionController@update');

// Services
Route::get('/services', 'ServicesController@index');
Route::get('/services/create', 'ServicesController@create');
Route::post('/services', 'ServicesController@store');
Route::get('/services/{id}/edit', 'ServicesController@edit');
Route::get('/services/import', 'ServicesController@import');
Route::get('/services/{id}/delete', 'ServicesController@delete');
Route::post('/services/update', 'ServicesController@update');
Route::post('/services/do_import', 'ServicesController@do_import');

// Expenses
Route::get('/expenses', 'ExpenseController@index');
Route::get('/expenses/create', 'ExpenseController@create');
Route::post('/expenses', 'ExpenseController@store');
Route::get('/expenses/{id}/edit', 'ExpenseController@edit');
Route::get('/expenses/{id}/delete', 'ExpenseController@delete');
Route::post('/expenses/update', 'ExpenseController@update');

// Expenses
Route::get('/materials', 'MaterialController@index');
Route::get('/materials/create', 'MaterialController@create');
Route::post('/materials', 'MaterialController@store');
Route::get('/materials/{id}/edit', 'MaterialController@edit');
Route::get('/materials/import', 'MaterialController@import');
Route::get('/materials/{id}/delete', 'MaterialController@delete');
Route::post('/materials/update', 'MaterialController@update');
Route::post('/materials/do_import', 'MaterialController@do_import');

// Expenses
Route::get('/debit_credit', 'DebitCreditController@index');
Route::get('/debit_credit/create', 'DebitCreditController@create');
Route::post('/debit_credit', 'DebitCreditController@store');
Route::get('/debit_credit/{id}/edit', 'DebitCreditController@edit');
Route::get('/debit_credit/import', 'DebitCreditController@import');
Route::get('/debit_credit/{id}/delete', 'DebitCreditController@delete');
Route::post('/debit_credit/update', 'DebitCreditController@update');
Route::post('/debit_credit/do_import', 'DebitCreditController@do_import');

// Discounts
Route::get('/discounts', 'DiscountController@index');
Route::get('/discounts/create', 'DiscountController@create');
Route::post('/discounts', 'DiscountController@store');
Route::get('/discounts/{id}/edit', 'DiscountController@edit');
Route::get('/discounts/{id}/delete', 'DiscountController@delete');
Route::post('/discounts/update', 'DiscountController@update');

// Taxes
Route::get('/taxes', 'TaxController@index');
Route::get('/taxes/create', 'TaxController@create');
Route::post('/taxes', 'TaxController@store');
Route::get('/taxes/{id}/edit', 'TaxController@edit');
Route::get('/taxes/{id}/delete', 'TaxController@delete');
Route::post('/taxes/update', 'TaxController@update');

// Absences
Route::get('/absences', 'AbsenceController@index');
Route::get('/main-menu/{parameter}/absences', 'AbsenceController@index');
Route::get('/absences/create', 'AbsenceController@create');
Route::post('/absences', 'AbsenceController@store');
Route::get('/absences/{id}/edit', 'AbsenceController@edit');
Route::get('/absences/{id}/delete', 'AbsenceController@delete');
Route::post('/absences/update', 'AbsenceController@update');

// Replacements
Route::get('/replacements', 'ReplacementController@index');
Route::get('/main-menu/{parameter}/replacements', 'ReplacementController@index');
Route::get('/replacements/create', 'ReplacementController@create');
Route::post('/replacements', 'ReplacementController@store');
Route::get('/replacements/{id}/edit', 'ReplacementController@edit');
Route::get('/replacements/{id}/delete', 'ReplacementController@delete');
Route::post('/replacements/update', 'ReplacementController@update');

// Teams
Route::get('/teams', 'TeamController@index');
Route::get('/teams/create', 'TeamController@create');
Route::post('/teams', 'TeamController@store');
Route::get('/teams/{id}/edit', 'TeamController@edit');
Route::get('/teams/{id}/delete', 'TeamController@delete');
Route::post('/teams/update', 'TeamController@update');

// TeamUsers
Route::get('/team_users', 'TeamUserController@index');
Route::get('/main-menu/{parameter}/{parameter2}/team_users', 'TeamUserController@index');
Route::get('/team_users/create', 'TeamUserController@create');
Route::post('/team_users', 'TeamUserController@store');
Route::get('/team_users/{id}/edit', 'TeamUserController@edit');
Route::get('/team_users/{id}/delete', 'TeamUserController@delete');
Route::post('/team_users/update', 'TeamUserController@update');

// Contacts
Route::get('/contacts', 'ContactController@index');
Route::get('/contacts/create', 'ContactController@create');
Route::post('/contacts', 'ContactController@store');
Route::get('/contacts/{id}/edit', 'ContactController@edit');
Route::get('/contacts/import', 'ContactController@import');
Route::get('/contacts/{id}/delete', 'ContactController@delete');
Route::post('/contacts/update', 'ContactController@update');
Route::post('/contacts/do_import', 'ContactController@do_import');

// Stakeholders
Route::get('/stakeholders', 'StakeholderController@index');
Route::get('/main-menu/{parameter}/{parameter2}/stakeholders', 'StakeholderController@index');
Route::get('/stakeholders/create', 'StakeholderController@create');
Route::post('/stakeholders', 'StakeholderController@store');
Route::get('/stakeholders/{id}/edit', 'StakeholderController@edit');
Route::get('/stakeholders/{id}/delete', 'StakeholderController@delete');
Route::post('/stakeholders/update', 'StakeholderController@update');

// Agenda
Route::get('/agendas', 'AgendaController@index');
Route::get('/agendas/create', 'AgendaController@create');
Route::post('/agendas', 'AgendaController@store');
Route::get('/agendas/{id}/edit', 'AgendaController@edit');
Route::get('/agendas/{id}/delete', 'AgendaController@delete');
Route::post('/agendas/update', 'AgendaController@update');

// AgendaRows
Route::get('/agenda/rows/{id}', 'AgendaRowController@index');

// ActivitiesHistory
Route::get('/activities_history/create', 'ActivityHistoryController@create');
Route::post('/activities_history', 'ActivityHistoryController@store');
Route::get('/activities_history/{id}/edit', 'ActivityHistoryController@edit');
Route::get('/activities_history/{id}/delete', 'ActivityHistoryController@delete');
Route::post('/activities_history/update', 'ActivityHistoryController@update');

// KPIs
Route::get('/kpis', 'KpiController@index');
Route::get('/kpis/create', 'KpiController@create');
Route::post('/kpis', 'KpiController@store');
Route::get('/kpis/{id}/edit', 'KpiController@edit');
Route::get('/kpis/{id}/delete', 'KpiController@delete');
Route::post('/kpis/update', 'KpiController@update');
// KPIs
Route::get('/kpis_category', 'KpiCategoryController@index');
Route::get('/kpis_category/create', 'KpiCategoryController@create');
Route::post('/kpis_category', 'KpiCategoryController@store');
Route::get('/kpis_category/{id}/edit', 'KpiCategoryController@edit');
Route::get('/kpis_category/{id}/delete', 'KpiCategoryController@delete');
Route::post('/kpis_category/update', 'KpiCategoryController@update');

Route::get('/kpis_functions', 'KpiFunctionsController@index');
Route::get('/kpis_functions/{category_kpi}', 'KpiFunctionsController@index');

// ProjectRows
Route::get('/project/rows/{id}', 'ProjectRowController@index');

// ProjectKpiAlerts
Route::get('/project_kpi_alerts/create', 'ProjectKpiAlertController@create');

// Route::post('/project_kpi_alerts/{id}/update', 'ProjectKpiAlertController@update');
// Route::post('/project_kpi_alerts/{id}', 'ProjectKpiAlertController@store');

Route::get('/project_kpi_alerts/{id}/edit', 'ProjectKpiAlertController@edit');
Route::get('/project_kpi_alerts/{id}/delete', 'ProjectKpiAlertController@delete');
Route::post('/project_kpi_alerts', 'ProjectKpiAlertController@store');
Route::post('/project_kpi_alerts/update', 'ProjectKpiAlertController@update');

// Contracts
Route::get('/contracts', 'ContractController@index');
Route::get('/main-menu/{parameter}/{parameter2}/contracts', 'ContractController@index');

Route::get('/contracts/create', 'ContractController@create');
Route::post('/contracts', 'ContractController@store');
Route::get('/contracts/{id}/show', 'ContractController@show');
Route::get('/contracts/{id}/edit', 'ContractController@edit');
Route::post('/contracts/delete', 'ContractController@delete');
Route::post('/contracts/update', 'ContractController@update');
Route::post('/contracts/validate_download', 'ContractController@validate_download');

// ContractRows
Route::get('/contract/rows/{id}', 'ContractRowController@index');
Route::get('/contracts/pdf/{id}', 'ContractRowController@pdf');

// ContractResources
Route::get('/contract_resources/{id}/create', 'ContractResourceController@create');
Route::post('/contract_resources', 'ContractResourceController@store');
Route::get('/contract_resources/{id}/edit', 'ContractResourceController@edit');
Route::get('/contract_resources/{id}/delete', 'ContractResourceController@delete');
Route::post('/contract_resources/update', 'ContractResourceController@update');

// ContractExpenses
Route::get('/contract_expenses/{id}/create', 'ContractExpenseController@create');
Route::post('/contract_expenses', 'ContractExpenseController@store');
Route::get('/contract_expenses/{id}/edit', 'ContractExpenseController@edit');
Route::get('/contract_expenses/{id}/delete', 'ContractExpenseController@delete');
Route::post('/contract_expenses/update', 'ContractExpenseController@update');

// ContractServices
Route::get('/contract_services/{id}/create', 'ContractServiceController@create');
Route::post('/contract_services', 'ContractServiceController@store');
Route::get('/contract_services/{id}/edit', 'ContractServiceController@edit');
Route::get('/contract_services/{id}/delete', 'ContractServiceController@delete');
Route::post('/contract_services/update', 'ContractServiceController@update');

// ContractMaterials
Route::get('/contract_materials/{id}/create', 'ContractMaterialController@create');
Route::post('/contract_materials', 'ContractMaterialController@store');
Route::get('/contract_materials/{id}/edit', 'ContractMaterialController@edit');
Route::get('/contract_materials/{id}/delete', 'ContractMaterialController@delete');
Route::post('/contract_materials/update', 'ContractMaterialController@update');

// AdditionalHours
Route::get('/additional_hours', 'AdditionalHourController@index');
Route::get('/knowledge_area/team_management/additional_hours', 'AdditionalHourController@index');
Route::get('/process_group/executing/additional_hours', 'AdditionalHourController@index');
Route::get('/additional_hours/create', 'AdditionalHourController@create');
Route::post('/additional_hours', 'AdditionalHourController@store');
Route::get('/additional_hours/{id}/edit', 'AdditionalHourController@edit');
Route::get('/additional_hours/{id}/delete', 'AdditionalHourController@delete');
Route::post('/additional_hours/update', 'AdditionalHourController@update');

// WorkingHours
Route::get('/working_hours', 'WorkingHourController@index');
Route::get('/main-menu/{parameter}/{parameter2}/working_hours', 'WorkingHourController@index');
Route::get('/working_hours/{team_user_id}/show', 'WorkingHourController@show');
Route::get('/working_hours/create', 'WorkingHourController@create');
Route::post('/working_hours', 'WorkingHourController@store');
Route::get('/working_hours/{id}/edit', 'WorkingHourController@edit');
Route::get('/working_hours/{id}/delete', 'WorkingHourController@delete');
Route::post('/working_hours/update', 'WorkingHourController@update');

// ProjectBoardRows
Route::get('/project_board/project_rows', 'ProjectBoardRowController@index');
Route::get('/main-menu/{parameter}/project_board/project_rows', 'ProjectBoardRowController@index');
Route::get('/project_board/pdf', 'ProjectBoardRowController@pdf');


// ProjectResources
Route::get('/project_resources/{id}/create', 'ProjectResourceController@create');
Route::post('/project_resources', 'ProjectResourceController@store');
Route::get('/project_resources/{id}/edit', 'ProjectResourceController@edit');
Route::get('/project_resources/{id}/delete', 'ProjectResourceController@delete');
Route::post('/project_resources/update', 'ProjectResourceController@update');

// ProjectExpenses
Route::get('/project_expenses/{id}/create', 'ProjectExpenseController@create');
Route::post('/project_expenses', 'ProjectExpenseController@store');
Route::get('/project_expenses/{id}/edit', 'ProjectExpenseController@edit');
Route::get('/project_expenses/{id}/delete', 'ProjectExpenseController@delete');
Route::post('/project_expenses/update', 'ProjectExpenseController@update');

// ProjectServices
Route::get('/project_services/{id}/create', 'ProjectServiceController@create');
Route::post('/project_services', 'ProjectServiceController@store');
Route::get('/project_services/{id}/edit', 'ProjectServiceController@edit');
Route::get('/project_services/{id}/delete', 'ProjectServiceController@delete');
Route::post('/project_services/update', 'ProjectServiceController@update');

// ProjectMaterials
Route::get('/project_materials/{id}/create', 'ProjectMaterialController@create');
Route::post('/project_materials', 'ProjectMaterialController@store');
Route::get('/project_materials/{id}/edit', 'ProjectMaterialController@edit');
Route::get('/project_materials/{id}/delete', 'ProjectMaterialController@delete');
Route::post('/project_materials/update', 'ProjectMaterialController@update');

// DEbit Credit Adjustment
Route::get('/project_debit_credit/{id}/create', 'ProjectDebitCreditController@create');
Route::post('/project_debit_credit', 'ProjectDebitCreditController@store');
Route::get('/project_debit_credit/{id}/edit', 'ProjectDebitCreditController@edit');
Route::get('/project_debit_credit/{id}/delete', 'ProjectDebitCreditController@delete');
Route::post('/project_debit_credit/update', 'ProjectDebitCreditController@update');

// Invoices
Route::get('/invoices', 'InvoiceController@index');
Route::get('/main-menu/{parameter}/invoices', 'InvoiceController@index');
Route::get('/invoices/create', 'InvoiceController@create');
Route::get('/invoices/rows/{id}', 'InvoiceController@rows');
Route::get('/invoices/pdf/{id}', 'InvoiceController@pdf');
Route::post('/invoices', 'InvoiceController@store');
Route::get('/invoices/{id}/edit', 'InvoiceController@edit');
Route::get('/invoices/{id}/delete', 'InvoiceController@delete');
Route::post('/invoices/update', 'InvoiceController@update');

//Quotations
Route::get('/quotation', 'QuotationController@index');
Route::get('/main-menu/{parameter}/{parameter2}/quotation', 'QuotationController@index');
Route::get('/quotation/create', 'QuotationController@create');
Route::get('/quotation/rows/{id}', 'QuotationController@rows');
Route::get('/quotations/rows/{id}', 'QuotationController@rows');
//Route::get('/quotation/pdf/{id}', 'QuotationController@pdf');
Route::get('/quotation/pdf/{id}/{resources_select}/{expenses_select}/{services_select}/{materials_select}', 'QuotationController@pdf');

Route::post('/quotation', 'QuotationController@store');
Route::get('/quotation/{id}/edit', 'QuotationController@edit');
Route::get('/quotation/{id}/delete', 'QuotationController@delete');
Route::post('/quotation/update', 'QuotationController@update');

// InvoiceResources
Route::get('/invoice_resources/{id}/create', 'InvoiceResourceController@create');
Route::post('/invoice_resources', 'InvoiceResourceController@store');
Route::get('/invoice_resources/{id}/edit', 'InvoiceResourceController@edit');
Route::get('/invoice_resources/{id}/delete', 'InvoiceResourceController@delete');
Route::post('/invoice_resources/update', 'InvoiceResourceController@update');

// QutationResources
Route::get('/quotation_resources/{id}/create', 'QuotationResourceController@create');
Route::post('/quotation_resources', 'QuotationResourceController@store');
Route::get('/quotation_resources/{id}/edit', 'QuotationResourceController@edit');
Route::get('/quotation_resources/{id}/delete', 'QuotationResourceController@delete');
Route::post('/quotation_resources/update', 'QuotationResourceController@update');

// InvoiceExpenses
Route::get('/invoice_expenses/{id}/create', 'InvoiceExpenseController@create');
Route::post('/invoice_expenses', 'InvoiceExpenseController@store');
Route::get('/invoice_expenses/{id}/edit', 'InvoiceExpenseController@edit');
Route::get('/invoice_expenses/{id}/delete', 'InvoiceExpenseController@delete');
Route::post('/invoice_expenses/update', 'InvoiceExpenseController@update');

// QuotationExpenses
Route::get('/quotation_expenses/{id}/create', 'QuotationExpenseController@create');
Route::post('/quotation_expenses', 'QuotationExpenseController@store');
Route::get('/quotation_expenses/{id}/edit', 'QuotationExpenseController@edit');
Route::get('/quotation_expenses/{id}/delete', 'QuotationExpenseController@delete');
Route::post('/quotation_expenses/update', 'QuotationExpenseController@update');

// InvoiceServices
Route::get('/invoice_services/{id}/create', 'InvoiceServiceController@create');
Route::post('/invoice_services', 'InvoiceServiceController@store');
Route::get('/invoice_services/{id}/edit', 'InvoiceServiceController@edit');
Route::get('/invoice_services/{id}/delete', 'InvoiceServiceController@delete');
Route::post('/invoice_services/update', 'InvoiceServiceController@update');


// QuotationServices
Route::get('/quotation_services/{id}/create', 'QuotationServiceController@create');
Route::post('/quotation_services', 'QuotationServiceController@store');
Route::get('/quotation_services/{id}/edit', 'QuotationServiceController@edit');
Route::get('/quotation_services/{id}/delete', 'QuotationServiceController@delete');
Route::post('/quotation_services/update', 'QuotationServiceController@update');


// InvoiceMaterials
Route::get('/invoice_materials/{id}/create', 'InvoiceMaterialController@create');
Route::post('/invoice_materials', 'InvoiceMaterialController@store');
Route::get('/invoice_materials/{id}/edit', 'InvoiceMaterialController@edit');
Route::get('/invoice_materials/{id}/delete', 'InvoiceMaterialController@delete');
Route::post('/invoice_materials/update', 'InvoiceMaterialController@update');

// InvoiceMaterials
Route::get('/invoice_debit_credit/{id}/create', 'InvoiceDebitCreditController@create');
Route::post('/invoice_debit_credit', 'InvoiceDebitCreditController@store');
Route::get('/invoice_debit_credit/{id}/edit', 'InvoiceDebitCreditController@edit');
Route::get('/invoice_debit_credit/{id}/delete', 'InvoiceDebitCreditController@delete');
Route::post('/invoice_debit_credit/update', 'InvoiceDebitCreditController@update');




// QuotationMaterials
Route::get('/quotation_materials/{id}/create', 'QuotationMaterialController@create');
Route::post('/quotation_materials', 'QuotationMaterialController@store');
Route::get('/quotation_materials/{id}/edit', 'QuotationMaterialController@edit');
Route::get('/quotation_materials/{id}/delete', 'QuotationMaterialController@delete');
Route::post('/quotation_materials/update', 'QuotationMaterialController@update');

// InvoiceDiscounts
Route::get('/invoice_discounts/{id}/create', 'InvoiceDiscountController@create');
Route::post('/invoice_discounts', 'InvoiceDiscountController@store');
Route::get('/invoice_discounts/{id}/edit', 'InvoiceDiscountController@edit');
Route::get('/invoice_discounts/{id}/delete', 'InvoiceDiscountController@delete');
Route::post('/invoice_discounts/update', 'InvoiceDiscountController@update');

// InvoiceTaxes
Route::get('/invoice_taxes/{id}/create', 'InvoiceTaxController@create');
Route::post('/invoice_taxes', 'InvoiceTaxController@store');
Route::get('/invoice_taxes/{id}/edit', 'InvoiceTaxController@edit');
Route::get('/invoice_taxes/{id}/delete', 'InvoiceTaxController@delete');
Route::post('/invoice_taxes/update', 'InvoiceTaxController@update');

// Providers
Route::get('/providers', 'ProviderController@index');
Route::get('/providers/create', 'ProviderController@create');
Route::get('/providers/import', 'ProviderController@import');
Route::get('/providers/{id}', 'ProviderController@show');
Route::post('/providers', 'ProviderController@store');
Route::get('/providers/{id}/edit', 'ProviderController@edit');
Route::get('/providers/{id}/delete', 'ProviderController@delete');
Route::post('/providers/update', 'ProviderController@update');
Route::post('/providers/do_import', 'ProviderController@do_import');

// Procurements
Route::get('/procurements', 'ProcurementController@index');
Route::get('/main-menu/{parameter}/procurements', 'ProcurementController@index');
Route::get('/procurements/create', 'ProcurementController@create');
Route::get('/procurements/{id}', 'ProcurementController@show');
Route::get('/procurements/{id}/rows', 'ProcurementController@rows');
Route::post('/procurements', 'ProcurementController@store');
Route::get('/procurements/{id}/edit', 'ProcurementController@edit');
Route::get('/procurements/{id}/delete', 'ProcurementController@delete');
Route::post('/procurements/update', 'ProcurementController@update');

// ProcurementOffers
Route::get('/procurement_offers/{id}/create', 'ProcurementOfferController@create');
Route::post('/procurement_offers', 'ProcurementOfferController@store');
Route::get('/procurement_offers/{id}/edit', 'ProcurementOfferController@edit');
Route::get('/procurement_offers/{id}/delete', 'ProcurementOfferController@delete');
Route::post('/procurement_offers/update', 'ProcurementOfferController@update');

// Requirements
Route::get('/requirements', 'RequirementController@index');
Route::get('/main-menu/{parameter}/{parameter2}/requirements', 'RequirementController@index');
Route::get('/requirements/create', 'RequirementController@create');
Route::get('/requirements/{id}', 'RequirementController@show');
Route::post('/requirements', 'RequirementController@store');
Route::get('/requirements/{id}/edit', 'RequirementController@edit');
Route::get('/requirements/{id}/delete', 'RequirementController@delete');
Route::post('/requirements/update', 'RequirementController@update');

// Tasks
Route::get('/tasks', 'TaskController@index');
Route::get('/tasks/create', 'TaskController@create');
Route::get('/tasks/export', 'TaskController@export');
Route::get('/tasks/import', 'TaskController@import');

Route::get('/tasks/{id}', 'TaskController@show');
Route::post('/tasks', 'TaskController@store');
Route::get('/tasks/{id}/edit', 'TaskController@edit');
Route::get('/tasks/{id}/delete', 'TaskController@delete');
Route::post('/tasks/update', 'TaskController@update');

// Route::get('/projects/{id}/tasks', 'ProjectTaskController@index');

Route::post('/tasks/do_import', 'TaskController@do_import');

// Sprints
Route::get('/sprints/{project_id}', 'SprintsController@index'); // Ruta en knowledge Area / Time Management 
Route::get('/planning/sprints/{project_id}', 'SprintsController@index'); // Ruta en Process Group / Planning
Route::get('/closing/sprints/{project_id}', 'SprintsController@index'); // Rutea en Process Groupe / Closing

Route::get('/sprints/create', 'SprintsController@create');
Route::get('/sprints/{id}/tickets', 'TicketController@indexsprints');
Route::get('/sprints/{id}', 'SprintsController@show');
Route::post('/sprints', 'SprintsController@store');
Route::get('/sprints/{id}/edit', 'SprintsController@edit');
Route::get('/sprints/{id}/delete', 'SprintsController@delete');
Route::post('/sprints/update', 'SprintsController@update');



// Tickets
Route::get('/tasks/{id}/tickets', 'TicketController@index');

Route::get('/tickets/create', 'TicketController@create');
Route::get('/tickets/{id}', 'TicketController@show');
Route::post('/tickets', 'TicketController@store');
Route::get('/tickets/{id}/edit', 'TicketController@edit');
Route::get('/tickets/{id}/files', 'TicketController@files');
Route::get('/tickets/{id}/delete', 'TicketController@delete');
Route::post('/tickets/update', 'TicketController@update');
Route::post('/tickets/uploadfile', 'TicketController@uploadfile');
Route::get('/tickets/download/', 'TicketController@download');

// TicketsHistory
Route::get('/tickets/{id}/history', 'TicketHistoryController@index');
Route::get('/ticket_history/create', 'TicketHistoryController@create');
Route::get('/ticket_history/{id}', 'TicketHistoryController@show');
Route::post('/ticket_history', 'TicketHistoryController@store');
Route::get('/ticket_history/{id}/edit', 'TicketHistoryController@edit');
Route::get('/ticket_history/{id}/delete', 'TicketHistoryController@delete');
Route::post('/ticket_history/update', 'TicketHistoryController@update');


// TasksRows
Route::get('/tasks/{id}/rows', 'TaskRowController@index');

// TasksResources
Route::get('/task_resources/{id}/create', 'TaskResourceController@create');
Route::post('/task_resources', 'TaskResourceController@store');
Route::get('/task_resources/{id}/edit', 'TaskResourceController@edit');
Route::get('/task_resources/{id}/delete', 'TaskResourceController@delete');
Route::post('/task_resources/update', 'TaskResourceController@update');

// TasksServices
Route::get('/task_services/{id}/create', 'TaskServiceController@create');
Route::post('/task_services', 'TaskServiceController@store');
Route::get('/task_services/{id}/edit', 'TaskServiceController@edit');
Route::get('/task_services/{id}/delete', 'TaskServiceController@delete');
Route::post('/task_services/update', 'TaskServiceController@update');

// TaskMaterials
Route::get('/task_materials/{id}/create', 'TaskMaterialController@create');
Route::post('/task_materials', 'TaskMaterialController@store');
Route::get('/task_materials/{id}/edit', 'TaskMaterialController@edit');
Route::get('/task_materials/{id}/delete', 'TaskMaterialController@delete');
Route::post('/task_materials/update', 'TaskMaterialController@update');


// TaskExpenses
Route::get('/task_expenses/{id}/create', 'TaskExpenseController@create');
Route::post('/task_expenses', 'TaskExpenseController@store');
Route::get('/task_expenses/{id}/edit', 'TaskExpenseController@edit');
Route::get('/task_expenses/{id}/delete', 'TaskExpenseController@delete');
Route::post('/task_expenses/update', 'TaskExpenseController@update');

// ProjectBoardvsGantt
Route::get('/project_board/gantt', 'ProjectBoardGanttController@index');

// Offices
Route::get('/offices', 'OfficeController@index');
Route::get('/offices/create', 'OfficeController@create');
Route::post('/offices', 'OfficeController@store');
Route::get('/offices/{id}/edit', 'OfficeController@edit');
Route::get('/offices/import', 'OfficeController@import');
Route::get('/offices/{id}/delete', 'OfficeController@delete');
Route::post('/offices/update', 'OfficeController@update');
Route::post('/offices/do_import', 'OfficeController@do_import');

// Departments
Route::get('/departments', 'DepartmentController@index');
Route::get('/departments/create', 'DepartmentController@create');
Route::post('/departments', 'DepartmentController@store');
Route::get('/departments/{id}/edit', 'DepartmentController@edit');
Route::get('/departments/import', 'DepartmentController@import');
Route::get('/departments/{id}/delete', 'DepartmentController@delete');
Route::post('/departments/update', 'DepartmentController@update');
Route::post('/departments/do_import', 'DepartmentController@do_import');

// ProjectRoles
Route::get('/project_roles', 'ProjectRoleController@index');
Route::get('/project_roles/create', 'ProjectRoleController@create');
Route::post('/project_roles', 'ProjectRoleController@store');
Route::get('/project_roles/{id}/edit', 'ProjectRoleController@edit');
Route::get('/project_roles/import', 'ProjectRoleController@import');
Route::get('/project_roles/{id}/delete', 'ProjectRoleController@delete');
Route::post('/project_roles/update', 'ProjectRoleController@update');
Route::post('/project_roles/do_import', 'ProjectRoleController@do_import');

// Seniorities
Route::get('/seniorities', 'SeniorityController@index');
Route::get('/seniorities/create', 'SeniorityController@create');
Route::post('/seniorities', 'SeniorityController@store');
Route::get('/seniorities/{id}/edit', 'SeniorityController@edit');
Route::get('/seniorities/import', 'SeniorityController@import');
Route::get('/seniorities/{id}/delete', 'SeniorityController@delete');
Route::post('/seniorities/update', 'SeniorityController@update');
Route::post('/seniorities/do_import', 'SeniorityController@do_import');

// Workgroups
Route::get('/workgroups', 'WorkgroupController@index');
Route::get('/workgroups/create', 'WorkgroupController@create');
Route::post('/workgroups', 'WorkgroupController@store');
Route::get('/workgroups/{id}/edit', 'WorkgroupController@edit');
Route::get('/workgroups/import', 'WorkgroupController@import');
Route::get('/workgroups/{id}/delete', 'WorkgroupController@delete');
Route::post('/workgroups/update', 'WorkgroupController@update');
Route::post('/workgroups/do_import', 'WorkgroupController@do_import');

// CompanyRoles
Route::get('/company_roles', 'CompanyRoleController@index');
Route::get('/company_roles/create', 'CompanyRoleController@create');
Route::post('/company_roles', 'CompanyRoleController@store');
Route::get('/company_roles/{id}/edit', 'CompanyRoleController@edit');
Route::get('/company_roles/{id}/delete', 'CompanyRoleController@delete');
Route::post('/company_roles/update', 'CompanyRoleController@update');
Route::get('/company_roles/import', 'CompanyRoleController@import');
Route::post('/company_roles/do_import', 'CompanyRoleController@do_import');

// ExchangeRates
Route::get('/exchange_rates', 'ExchangeRateController@index');
Route::get('/exchange_rates/create', 'ExchangeRateController@create');
Route::post('/exchange_rates', 'ExchangeRateController@store');
Route::get('/exchange_rates/{id}/edit', 'ExchangeRateController@edit');
Route::get('/exchange_rates/{id}/delete', 'ExchangeRateController@delete');
Route::post('/exchange_rates/update', 'ExchangeRateController@update');
Route::get('/exchange_rates/import', 'ExchangeRateController@import');
Route::post('/exchange_rates/do_import', 'ExchangeRateController@do_import');
// Notes
Route::get('/notes', 'NoteController@index');
Route::get('/notes/create', 'NoteController@create');
Route::post('/notes', 'NoteController@store');
Route::get('/notes/{id}/edit', 'NoteController@edit');
Route::get('/notes/{id}/delete', 'NoteController@delete');
Route::post('/notes/update', 'NoteController@update');

// Workboard
Route::get('/workboard', 'WorkboardController@index');
Route::get('/workboard/{group}', 'WorkboardController@grouping');
Route::get('/workboard/{id}/edit', 'WorkboardController@edit');

// Capacity Planning
Route::get('/capacity_planning', 'CapacityPlanningController@index');
Route::get('/main-menu/{parameter}/{parameter2}/capacity_planning', 'CapacityPlanningController@index');
Route::get('/capacity_planning/excel', 'CapacityPlanningController@excel');
Route::get('/capacity_planning/pdf', 'CapacityPlanningController@pdf');

// Pofit and loss

Route::get('/profit_and_loss', 'ProfitAndLossController@index');
Route::get('/main-menu/{parameter}/profit_and_loss', 'ProfitAndLossController@index');
Route::get('/profit_and_loss/pdf', 'ProfitAndLossController@pdf');

//Forecast
Route::get('/forecast', 'ForecastController@index');
Route::get('/main-menu/{parameter}/forecast', 'ForecastController@index');
Route::get('/forecast/pdf', 'ForecastController@pdf');

// Reports
Route::get('/reports/tasks', 'ReportController@getTasks');
Route::get('/main-menu/{parameter}/reports/tasks', 'ReportController@getTasks');
Route::get('/reports/tasks/pdf', 'ReportController@pdf');

Route::get('/reports/{id}/tickets', 'ReportController@getTicketsByTask');

//Document Generation
Route::get('metadocuments','MetaDocumentsController@index');
Route::get('metadocuments/create', 'MetaDocumentsController@create');
Route::post('metadocuments', 'MetaDocumentsController@store');
Route::get('metadocuments/{id}/edit', 'MetaDocumentsController@edit');
Route::post('metadocuments/update', 'MetaDocumentsController@update');
Route::get('metadocuments/{id}/destroy', 'MetaDocumentsController@destroy');



//Metavariables
Route::get('metavariables','MetavariablesController@index');
Route::get('metavariables/create', 'MetavariablesController@create');
Route::post('metavariables', 'MetavariablesController@store');
Route::get('metavariables/{id}/edit', 'MetavariablesController@edit');
Route::post('metavariables/update', 'MetavariablesController@update');
Route::get('metavariables/{id}/destroy', 'MetavariablesController@destroy');


//Metagrids
Route::get('metagrids','MetagridsController@index');
Route::get('metagrids/create', 'MetagridsController@create');
Route::post('metagrids', 'MetagridsController@store');
Route::get('metagrids/{id}/edit', 'MetagridsController@edit');
Route::post('metagrids/update', 'MetagridsController@update');
Route::get('metagrids/{id}/destroy', 'MetagridsController@destroy');


//Document Generation

Route::get('document_generation', 'MetaDocumentsController@generateDocument');
Route::get('metavariables/get_from_file/{lang}/{folder}/{file}', 'MetavariablesController@getFromFile');
 Route::get('metagrids/get_from_file/{lang}/{folder}/{file}', 'MetagridsController@getFromFile'); 
Route::post('repository/store', 'RepositoryController@store');
Route::post('update_preview', 'RepositoryController@updatePreview');
 Route::post('repository/send_by_mail', 'RepositoryController@sendFile');
Route::get('catch_signature', 'RepositoryController@catchsignature');

 
// Settings


Route::get('/settings', 'SettingsController@index');
Route::post('/settings/update/{id}', 'SettingsController@update');

//Help

Route::get('/credit', 'HelpController@credit');
Route::get('/help', 'HelpController@help');
Route::get('/about', 'HelpController@about');
Route::get('/started', 'HelpController@started');
Route::get('/admin', 'HelpController@admin');
Route::get('/guie-users', 'HelpController@users');
Route::get('/help-kpis', 'HelpController@kpis');
Route::get('/download/{lang}/{archivo}', 'HelpController@download');


// AuditLog


Route::get('/audit_log', 'AuditlogController@index');


// WhatIf
Route::get('/whatif', 'WhatIfController@index');
Route::get('/whatif/create', 'WhatIfController@create');
Route::post('/whatif', 'WhatIfController@store');
Route::get('/whatif/{id}/edit', 'WhatIfController@edit');
Route::get('/whatif/{id}/delete', 'WhatIfController@delete');
Route::post('/whatif/update', 'WhatIfController@update');

// WhatIfTasks
Route::get('/whatif_tasks/{whatif_id}', 'WhatIfTaskController@index');
Route::get('/whatif_tasks/{whatif_id}/create', 'WhatIfTaskController@create');
Route::get('/whatif_tasks/{id}', 'WhatIfTaskController@show');
Route::post('/whatif_tasks/{whatif_id}', 'WhatIfTaskController@store');
Route::get('/whatif_tasks/{id}/edit', 'WhatIfTaskController@edit');
Route::get('/whatif_tasks/{id}/{whatif_id}/delete', 'WhatIfTaskController@delete');
Route::post('/whatif_tasks/{whatif_id}/update', 'WhatIfTaskController@update');
Route::get('/projects/{id}/{whatif_id}/whatif_tasks', 'WhatIfTaskController@whatif_index');


// WhatIfTasksRows
Route::get('/whatif_tasks/{id}/rows', 'WhatIfTaskRowController@index');

// WhatIfTasksResources
Route::get('/whatif_task_resource/{id}/create', 'WhatIfTaskResourceController@create');
Route::post('/whatif_task_resource', 'WhatIfTaskResourceController@store');
Route::get('/whatif_task_resource/{id}/edit', 'WhatIfTaskResourceController@edit');
Route::get('/whatif_task_resource/{id}/delete', 'WhatIfTaskResourceController@delete');
Route::post('/whatif_task_resource/update', 'WhatIfTaskResourceController@update');

// WhatIfTasksServices
Route::get('/whatif_task_service/{id}/create', 'WhatIfTaskServiceController@create');
Route::post('/whatif_task_service', 'WhatIfTaskServiceController@store');
Route::get('/whatif_task_service/{id}/edit', 'WhatIfTaskServiceController@edit');
Route::get('/whatif_task_service/{id}/delete', 'WhatIfTaskServiceController@delete');
Route::post('/whatif_task_service/update', 'WhatIfTaskServiceController@update');

// WhatIfTaskMaterials
Route::get('/whatif_task_material/{id}/create', 'WhatIfTaskMaterialController@create');
Route::post('/whatif_task_material', 'WhatIfTaskMaterialController@store');
Route::get('/whatif_task_material/{id}/edit', 'WhatIfTaskMaterialController@edit');
Route::get('/whatif_task_material/{id}/delete', 'WhatIfTaskMaterialController@delete');
Route::post('/whatif_task_material/update', 'WhatIfTaskMaterialController@update');


// WhatIfTaskExpenses
Route::get('/whatif_task_expense/{id}/create', 'WhatIfTaskExpenseController@create');
Route::post('/whatif_task_expense', 'WhatIfTaskExpenseController@store');
Route::get('/whatif_task_expense/{id}/edit', 'WhatIfTaskExpenseController@edit');
Route::get('/whatif_task_expense/{id}/delete', 'WhatIfTaskExpenseController@delete');
Route::post('/whatif_task_expense/update', 'WhatIfTaskExpenseController@update');

//Wiki
Route::get('/wiki', 'WikiController@index');
Route::get('/wiki/create', 'WikiController@create');
Route::post('/wiki', 'WikiController@store');
Route::get('/wiki/{id}', 'WikiController@show');
Route::get('/wiki/{id}/edit', 'WikiController@edit');
Route::get('/wiki/{id}/delete', 'WikiController@delete');
Route::post('wiki/update', 'WikiController@update');

Route::get('/wiki/pdf/{id}', 'WikiController@pdf');

route::get('error', 'ErrorController@index' );