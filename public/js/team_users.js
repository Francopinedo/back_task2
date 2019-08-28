/**
 * Created by Giuseppe on 21/02/2018.
 */
var TeamUsers = (function () {
    'use strict';

    var TeamUsers = {
        /**
         * init
         */
        APP_URL: '',
        API_PATH: '',
        init: function (API_PATH, APP_URL) {
            TeamUsers.events(API_PATH, APP_URL);
            TeamUsers.APP_URL = APP_URL;
            TeamUsers.API_PATH = API_PATH;

        },

        searchOffice:function (id) {
            console.log('searinch office...');
            $.ajax({
                url: TeamUsers.API_PATH + 'offices/'+id,
                type: 'GET',
                dataType: 'json'
            }).done(
                function (data) {
                    data = data.data;

                    $('#working_hours').val(data.hours_by_day);

                }
            );
        },

        serachUser:function () {
            console.log('searinch user...');
            $.ajax({
                url: TeamUsers.API_PATH + 'users/'+$("#user_id").val(),
                type: 'GET',
                dataType: 'json'
            }).done(
                function (data) {
                    data = data.data;
                    TeamUsers.searchOffice(data.office_id);

                }
            );
        },


        events: function () {


            $('#office_id').selectize();

            $("#city_id").on('change', function () {
                console.log('chage....');
                $.ajax({
                    url: TeamUsers.API_PATH + '/offices',
                    type: 'GET',
                    data: {city_id: $(this).val(), company_id:$("#company_id").val()},
                    dataType: 'json'
                }).done(
                    function (data) {
                        var html = '<option value="">Office...</option>';

                        $('#office_id').selectize()[0].selectize.destroy();

                        $.each(data.data, function (i, value) {
                            console.log(value);
                            html += '<option value="' + value.id + '">' + value.title + '</option>';
                        });

                        $('#office_id').html(html);

                        $('#office_id').selectize();
                    }
                );
            });


            $('#country_id').selectize();
            $('#country_id2').selectize();

            $("#country_id, #country_id2").on('change', function () {
                console.log('chage....');
                $.ajax({
                    url: TeamUsers.API_PATH + '/cities',
                    type: 'GET',
                    data: {country_id: $(this).val()},
                    dataType: 'json'
                }).done(
                    function (data) {
                        var html = '<option value="">City...</option>';

                        if($('#city_id2').length>0){
                            $('#city_id2').selectize()[0].selectize.destroy();
                        }

                        $('#city_id').selectize()[0].selectize.destroy();

                        $.each(data.data, function (i, value) {
                            console.log(value);
                            html += '<option value="' + value.id + '">' + value.name + '</option>';
                        });

                        $('#city_id').html(html);
                        $('#city_id2').html(html);

                        $('#city_id').selectize();
                        $('#city_id2').selectize();
                    }
                );
            });


            $('#user_id').selectize()[0].selectize.destroy();
            $("#country_id, #city_id, #office_id, #company_role_id, #seniority_id, #workplace").on('change', function () {
                console.log('chage....');
                $.ajax({
                    url: TeamUsers.API_PATH + '/users',
                    type: 'GET',
                    data: {city_id: $("#city_id").val(), office_id:$("#office_id").val(),company_role_id:$("#company_role_id").val(), seniority_id:$("#seniority_id").val(),
                        workplace:$("#workplace").val()},
                    dataType: 'json'
                }).done(
                    function (data) {
                        var html = '<option value="">User...</option>';

                        $('#user_id').selectize()[0].selectize.destroy();

                        $.each(data.data, function (i, value) {
                            console.log(value);
                            html += '<option value="' + value.id + '">' + value.name + '</option>';
                        });

                        $('#user_id').html(html);

                        $('#user_id').selectize();
                    }
                );
            });





            $("#user_id").selectize();
             //$("#user_id").selectize()[0].selectize.disable();


            $("#team_project_id").selectize();
           // $('#team_project_id').selectize()[0].selectize.disable();


            $('#team_project_id').on('change', function () {
                console.log('test');
                $.ajax({
                    url: TeamUsers.API_PATH + 'projects/'+$(this).val(),
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function (data) {
                        data = data.data;
                        console.log(data.start);
                        $('#date_to').val(data.finish);
                        $('#date_from').val(data.start);
                        //UIkit.datepicker($('#date_from'), {});
                    }
                );
            });

            $('#office_id').on('change', function () {
                console.log('test');
               TeamUsers.searchOffice($(this).val());
            });


        },


    }
    return TeamUsers;
}());
