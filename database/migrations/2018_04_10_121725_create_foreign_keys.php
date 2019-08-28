<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForeignKeys extends Migration
{

    public function up()
    {


        Schema::table('countries', function (Blueprint $table) {
            $table->foreign('language_id')->references('id')->on('languages')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->foreign('currency_id')->references('id')->on('currencies')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });


        Schema::table('companies', function (Blueprint $table) {
            $table->foreign('currency_id')->references('id')->on('currencies')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->foreign('industry_id')->references('id')->on('industries')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->foreign('industry_id')->references('id')->on('industries')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('quotation_lines', function (Blueprint $table) {
            $table->foreign('quotation_id')->references('id')->on('quotations')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('procurements', function (Blueprint $table) {
            $table->foreign('provider_id')->references('id')->on('providers')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('procurements', function (Blueprint $table) {
            $table->foreign('responsable_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
      

        Schema::table('seniorities', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('company_roles', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('project_roles', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table('costs', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('costs', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('costs', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('costs', function (Blueprint $table) {
            $table->foreign('seniority_id')->references('id')->on('seniorities')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('costs', function (Blueprint $table) {
            $table->foreign('project_role_id')->references('id')->on('project_roles')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('costs', function (Blueprint $table) {
            $table->foreign('currency_id')->references('id')->on('currencies')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('workgroups', function (Blueprint $table) {
            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('company_role_id')->references('id')->on('company_roles')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('project_role_id')->references('id')->on('project_roles')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('seniority_id')->references('id')->on('seniorities')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('office_id')->references('id')->on('offices')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('workgroup_id')->references('id')->on('workgroups')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('user_social_networks', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('absence_types', function (Blueprint $table) {
            $table->foreign('country_id')->references('id')->on('countries')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('absences', function (Blueprint $table) {
            $table->foreign('absence_type_id')->references('id')->on('absence_types')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('absences', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('absences', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
        });
        Schema::table('replacements', function (Blueprint $table) {
            $table->foreign('absence_id')->references('id')->on('absences')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('replacements', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
        Schema::table('teams', function (Blueprint $table) {
            $table->foreign('project_id')->references('id')->on('projects')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });

        Schema::table('team_users', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });

    }

    public function down()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropForeign('countries_language_id_foreign');
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->dropForeign('countries_currency_id_foreign');
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign('cities_country_id_foreign');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('companies_city_id_foreign');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('companies_currency_id_foreign');
        });
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('companies_industry_id_foreign');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign('customers_company_id_foreign');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropForeign('customers_industry_id_foreign');
        });

        Schema::table('quotations', function (Blueprint $table) {
            $table->dropForeign('quotations_project_id_foreign');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropForeign('quotations_customer_id_foreign');
        });
        Schema::table('quotation_lines', function (Blueprint $table) {
            $table->dropForeign('quotation_lines_quotation_id_foreign');
        });

        Schema::table('materials', function (Blueprint $table) {
            $table->dropForeign('materials_currency_id_foreign');
        });

        Schema::table('seniorities', function (Blueprint $table) {
            $table->dropForeign('seniorities_company_id_foreign');
        });
        Schema::table('company_roles', function (Blueprint $table) {
            $table->dropForeign('company_roles_company_id_foreign');
        });
        Schema::table('project_roles', function (Blueprint $table) {
            $table->dropForeign('project_roles_company_id_foreign');
        });
        Schema::table('costs', function (Blueprint $table) {
            $table->dropForeign('costs_company_id_foreign');
        });
        Schema::table('costs', function (Blueprint $table) {
            $table->dropForeign('costs_country_id_foreign');
        });
        Schema::table('costs', function (Blueprint $table) {
            $table->dropForeign('costs_city_id_foreign');
        });
        Schema::table('costs', function (Blueprint $table) {
            $table->dropForeign('costs_seniority_id_foreign');
        });
        Schema::table('costs', function (Blueprint $table) {
            $table->dropForeign('costs_project_role_id_foreign');
        });
        Schema::table('costs', function (Blueprint $table) {
            $table->dropForeign('costs_currency_id_foreign');
        });
        Schema::table('workgroups', function (Blueprint $table) {
            $table->dropForeign('workgroups_company_id_foreign');
        });
        Schema::table('offices', function (Blueprint $table) {
            $table->dropForeign('offices_city_id_foreign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_city_id_foreign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_company_id_foreign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_company_role_id_foreign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_project_role_id_foreign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_seniority_id_foreign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_office_id_foreign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_workgroup_id_foreign');
        });
        Schema::table('user_social_networks', function (Blueprint $table) {
            $table->dropForeign('user_social_networks_user_id_foreign');
        });
        Schema::table('absence_types', function (Blueprint $table) {
            $table->dropForeign('absence_types_country_id_foreign');
        });
        Schema::table('absences', function (Blueprint $table) {
            $table->dropForeign('absences_absence_type_id_foreign');
        });
        Schema::table('absences', function (Blueprint $table) {
            $table->dropForeign('absences_project_id_foreign');
        });
        Schema::table('absences', function (Blueprint $table) {
            $table->dropForeign('absences_user_id_foreign');
        });
        Schema::table('replacements', function (Blueprint $table) {
            $table->dropForeign('replacements_absence_id_foreign');
        });
        Schema::table('replacements', function (Blueprint $table) {
            $table->dropForeign('replacements_user_id_foreign');
        });
        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign('teams_project_id_foreign');
        });

        Schema::table('team_users', function (Blueprint $table) {
            $table->dropForeign('team_users_user_id_foreign');
        });




    }
}