var Kpis = (function () {
    'use strict';

    var Kpis = {

        APP_URL: '',
        API_PATH: '',

        init: function (API_PATH, APP_URL) {

            Kpis.APP_URL = APP_URL;
            Kpis.API_PATH = API_PATH;

            Kpis.events();


        },

        events: function () {
            // $(".data-attributes span").peity("donut");
            $('.slick').slick();
            this.chartEv();
            this.chartAc();
            this.chartPv();
            this.chartCpi();
            this.chartSpi();
            this.chartEac1();
            this.chartEac2();
            this.chartEac3();
            this.chartEac4();
            this.chartVac1();
            this.chartVac2();
            this.chartVac3();
            this.chartVac4();
            this.chartSv();
            this.chartCv();
            this.chartMfn();
            this.chartRoi();
            this.chartRrr();
            this.chartFnsl();

            this.chartActivities();
            this.chartMilestones();
            this.chartReviews();
            this.chartCommitments();
            this.chartOverdueTasks();
            this.chartTaskCompleted();
            this.chartPlannedHours();
            this.chartCompletedProjects();
            this.chartCancelledProjects();

        },

        chartEv: function () {

            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartEv",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-ev', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });


        },

        chartAc: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartAc",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-ac', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartPv: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartPv",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-pv', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartCpi: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartCpi",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-cpi', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },


        chartSpi: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartSpi",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-spi', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartEac1: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartEac1",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-eac1', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartEac2: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartEac2",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-eac2', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartEac3: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartEac3",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-eac3', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartEac4: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartEac4",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-eac4', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },


        chartVac1: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartVac1",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-vac1', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartVac2: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartVac2",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-vac2', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartVac3: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartVac3",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-vac3', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartVac4: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartVac4",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-vac4', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartSv: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartSv",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-sv', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartCv: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartCv",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-cv', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartMfn: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartMfn",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-mfn', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },
        chartFnsl: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartFnsl",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-fnsl', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartRoi: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartRoi",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Bar('#chart-roi', {
                        labels: data.months,
                        series:data.data

                    }, {
                        seriesBarDistance: 10,
                        axisX: {
                            offset: 60
                        },
                        axisY: {
                            offset: 80,
                            labelInterpolationFnc: function(value) {
                              //  return value + ' USD'
                                return Math.round(value * 100) / 100;
                            },
                            scaleMinSpace: 15
                        },
                        scaleMinSpace: 1,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartRrr: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartRrr",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-rrr', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },
        chartActivities: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartActivities",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-Activities', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },
        chartMilestones: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartMilestones",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-Milestones', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartReviews: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartReviews",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-Reviews', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },
        chartCommitments: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartCommitments",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-Commitments', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartOverdueTasks: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartOverdueTasks",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-OverdueTasks', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartTaskCompleted: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartTaskCompleted",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-TaskCompleted', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },
        chartPlannedHours: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartPlannedHours",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-PlannedHours', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },
        chartCompletedProjects: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartCompletedProjects",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-CompletedProjects', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        },

        chartCancelledProjects: function () {
            $.ajax({
                type: "GET",
                url: API_PATH + "kpis/chartCancelledProjects",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Line('#chart-CancelledProjects', {
                        labels: data.months,
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                        plugins: [
                            Chartist.plugins.legend({

                            })
                        ]
                    });
                },

            });
        }
    };

    return Kpis;
}());