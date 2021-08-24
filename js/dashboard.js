var Dashboard = (function () {
    'use strict';

    var Dashboard = {

        APP_URL: '',
        API_PATH: '',
        PROJECTID: '',
        init: function (API_PATH, APP_URL,PROJECTID) {

            Dashboard.APP_URL = APP_URL;
            Dashboard.API_PATH = API_PATH;
            Dashboard.PROJECTID = PROJECTID;

            Dashboard.events();
        },

        events: function () {
            // $(".data-attributes span").peity("donut");

            $('.slick').slick(
                { 
                slidesToShow: 3,
                slidesToScroll: 3,
                autoplay: false,
                autoplaySpeed: 2000,
                arrows: true,

                pauseOnHover: true,
                adaptiveHeight: true,
                mobileFirst:true,//add this one
                responsive: [
                    {
                        breakpoint: 1280,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                        }
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
        
              }
            );

            this.chartTicketsStatstype();
            this.chartTicketsStatsstatus();
            this.chartTicketsStatspriority();
            this.chartTasks();
            this.chartTicketsRiskTotal();
            this.chartTicketsScopeChangeTotal();
            this.chartBugsStatus();
            this.chartRequirements();
            this.chartResourceUtilization();
            this.chartIssues();
            this.percentMissingMilestone();
            this.chartMilestonesTasks();
            this.chartTaskOverdueTotal();
            this.chartTaskCompletedTotal();
            if(this.PROJECTID=='')
            {
                this.chartEvTotal();

            }  else{
                this.chartEvTotalProject();
                this.chartEv();
                this.chartAc();
                this.chartPv();
                this.chartCapacity();
                // this.chartOverdueTasks();
                this.chartPlannedHours();
                // this.chartTaskCompleted();

                // this.chartPlannedHours();

               // this.chartCompletedProjects();
               // this.chartCancelledProjects();  

            }
        },

    
        chartEvTotal: function () {

            $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartEvTotal",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: {project_id: $("#project_id").val()},
                success: function (data) {
                    // $("#chart-ev").append("<div class='uk-alert uk-alert-danger' data-uk-alert style='border-color: #999; border-style: solid;'><h1>"+data.data[0].name+"</h1><br><h1>"+Math.round(data.data[0].data * 100 + Number.EPSILON ) / 100+"</h1></div>"); 
                    // $("#chart-ac").append("<div class='uk-alert uk-alert-success' data-uk-alert style='border-color: #999; border-style: solid;'><h1>"+data.data[1].name+"</h1><br><h1>"+Math.round(data.data[1].data * 100 + Number.EPSILON ) / 100+"</h1></div>"); 
                    // $("#chart-pv").append("<div class='uk-alert uk-alert-success' data-uk-alert style='border-color: #999; border-style: solid;'><h1>"+data.data[2].name+"</h1><br><h1>"+Math.round(data.data[2].data * 100 + Number.EPSILON ) / 100+"</h1></div>"); 

                  //   new Chartist.Bar('#chart-ev', {
                  //     labels: data.type,
                  //     series:data.data

                  // },{
                  //     scaleMinSpace: 20,
                  //     seriesBarDistance: 12,
                  //     fullWidth: true,
                  //     chartPadding: {
                  //         right: 40
                  //     },
                  //     plugins: [
                  //         Chartist.plugins.legend({

                  //         }),
                          
                  //     ]
                  // });
                    new Chartist.Bar('#chart-ev', {
                        labels: data.type,
                        series: data.data
                    },{
                        // high: 10000,
                        // low: -10000, 
                        distributeSeries: true,
                    });
                }
            });
        },

        chartEvTotalProject: function() {
            $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartEvTotalProject",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: {project_id: $("#project_id").val()},
                success: function (data) {
                  
                    new Chartist.Bar('#chart-ev-total', {
                        labels: data.type,
                        series: data.data
                    },{
                        // high: 10000,
                        // low: -10000, 
                        distributeSeries: true,
                    });
                  
                }
            });
        },

        chartTaskCompletedTotal: function () {
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;

            $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/listTasks"+project,
                contentType: "application/json; charset=utf-8",
                data: {option:1},
                dataType: "json",
                success: function (data) {

                    //   $("#chart-chartTaskCompletedTotal").append("<div class='uk-alert uk-alert-success' data-uk-alert style='border-color: #999; border-style: solid;'><h1>% Completed Tasks</h1><br><h1>"+Math.round((data.data / data.total )*100 * 100 + Number.EPSILON ) / 100 +"%</h1></div>"); 
                    var data = {
                    series: data.data,
                    labels: data.type,
                    legend: data.className,
                    total:data.total,
                    };
                    var options = {
                        labelInterpolationFnc: function(name,value) {
                           var percentage = Math.round(data.series[value].value / data.total * 100) + '%';
                           return data.series[value].value +' = '+percentage;
                        },
                        plugins: [Chartist.plugins.legend({
                          classNames:data.legend,
                        })]
                    };
                    var sum = function(a, b) { return a + b };

                    var responsiveOptions = [
                        ['screen and (min-width: 350px)', {
                            chartPadding: 30,
                            labelOffset: 100,
                            labelDirection: 'explode'
                        }],
                        ['screen and (min-width: 1024px)', {
                            labelOffset: 80,
                            chartPadding: 20
                        }]
                    ];

                    new Chartist.Pie('#chart-chartTaskCompletedTotal', data, options);
                },

            });
        },

        chartTaskOverdueTotal: function () {
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;

                $.ajax({
                    type: "GET",
                    url: API_PATH + "dashboard/listTasks"+project,
                    contentType: "application/json; charset=utf-8",
                    data: {option:2},
                    dataType: "json",
                    success: function (data) {
                  //  $("#chart-chartOverdueTasksTotal").append("<div class='uk-alert uk-alert-danger' data-uk-alert style='border-color: #999; border-style: solid;'><h1># of Overdue Task</h1><br><h1>"+Math.round(data.data * 100 + Number.EPSILON ) / 100+"</h1></div>"); 
                  var data = {
                    series: data.data,
                    labels: data.type,
                    legend: data.className,
                    total:data.total,
                  };
                  var options = {
                      labelInterpolationFnc: function(name,value) {
                       var percentage = Math.round(data.series[value].value /  data.total * 100) + '%';
                       
                       return data.series[value].value +' = '+percentage;
                         },
                        plugins: [Chartist.plugins.legend({
                          classNames:data.legend,
                        })]
                   };
                  var sum = function(a, b) { return a + b };

                  var responsiveOptions = [
                    ['screen and (min-width: 350px)', {
                      chartPadding: 30,
                      labelOffset: 100,
                      labelDirection: 'explode'
                    }],
                    ['screen and (min-width: 1024px)', {
                      labelOffset: 80,
                      chartPadding: 20
                    }]
                  ];

              new Chartist.Pie('#chart-chartOverdueTasksTotal', data, options);

            }
            });
        },

        chartTaskProgressTotal: function () {
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;

            $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartEv"+project,
                contentType: "application/json; charset=utf-8",
                data: {option: '3'},

                dataType: "json",
                success: function (data) {
                    $("#chart-TaskProgressTotal").append("<div class='uk-alert uk-alert-danger' data-uk-alert style='border-color: #999; border-style: solid;'><h1>"+data.data[0].name+"</h1><br><h1>"+Math.round(data.data[0].data * 100 + Number.EPSILON ) / 100+"</h1></div>"); 
       

            }
            });
        },

        chartTicketsRiskTotal: function () {
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;

            $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartTicketsStatsType"+project,
                contentType: "application/json; charset=utf-8",
                data: {type: '3',total: '1'},

                dataType: "json",
                success: function (data) {
                   // $("#chart-chartTicketsRiskTotal").append("<div class='uk-alert "+data.data[0].className+"' data-uk-alert style='border-color: #999; border-style: solid;'><h1>Total Risks Tickets</h1><br><h1>"+data.data[0].value+"</h1></div>"); 
      
                  var data = {
                        series: data.data,
                        labels: data.type,
                        total: data.total
                      };
                      var options = {
                          labelInterpolationFnc: function(name,value) {
                            var percentage = Math.round(data.series[value].value / (data.series[0].value+data.series[1].value) * 100) + '%';
                            return data.series[value].value +' = '+percentage;
                               },
                                plugins: [Chartist.plugins.legend({
                                  legendNames:data.labels,
                                })]
                         };
                        var sum = function(a, b) { return a + b };

                        var responsiveOptions = [
                          ['screen and (min-width: 350px)', {
                            chartPadding: 30,
                            labelOffset: 100,
                            labelDirection: 'explode'
                          }],
                          ['screen and (min-width: 1024px)', {
                            labelOffset: 80,
                            chartPadding: 20
                          }]
                        ];

                    new Chartist.Pie('#chart-chartTicketsRiskTotal', data, options);


            }
            });
        },

        chartTicketsScopeChangeTotal: function () {
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;

            $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartTicketsStatsType"+project,
                contentType: "application/json; charset=utf-8",
                data: {type: '5',total:1},

                dataType: "json",
                success: function (data) {
                   // $("#chart-chartTicketsScopeChangeTotal").append("<div class='uk-alert "+data.data[0].className+"' data-uk-alert style='border-color: #999; border-style: solid;'><h1>Total Scope Changes</h1><br><h1>"+data.data[0].value+"</h1></div>"); 
       
                        var data = {
                        series: data.data,
                        labels: data.type,
                        total: data.total
                      };
                      var options = {
                          labelInterpolationFnc: function(name,value) {
                           var percentage = Math.round(data.series[value].value / (data.series[0].value+data.series[1].value) * 100) + '%';
                           return data.labels[value] + ' ' + data.series[value].value +' = '+percentage;
                          },
                           plugins: [Chartist.plugins.legend({
                            legendNames:data.labels,
                            })]
                         };
                        var sum = function(a, b) { return a + b };

                        var responsiveOptions = [
                          ['screen and (min-width: 350px)', {
                            chartPadding: 30,
                            labelOffset: 100,
                            labelDirection: 'explode'
                          }],
                          ['screen and (min-width: 1024px)', {
                            labelOffset: 80,
                            chartPadding: 20
                          }]
                        ];

                    new Chartist.Pie('#chart-chartTicketsScopeChangeTotal', data, options);
            }
            });
        },

        chartEv: function () {

            $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartEv",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Bar('#chart-ev', {
                        labels: [data.data[0].name],
                        series:data.data

                    }, {
                        scaleMinSpace: 20,
                        seriesBarDistance: 12,
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
                url: API_PATH + "dashboard/chartAc",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Bar('#chart-ac', {
                        labels: [data.data[0].name],
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
                url: API_PATH + "dashboard/chartPv",
                contentType: "application/json; charset=utf-8",
                data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Bar('#chart-pv', {
                        labels: [data.data[0].name],
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

                    // new Chartist.Bar('#chart-pv', {
                    //   labels: data.type,
                    //   series: data.data
                    // },{
                    //   distributeSeries: true,
                    // });


                },

            });
        },

        chartTasks: function () {
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;

            $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartTasks"+project,
                contentType: "application/json; charset=utf-8",
              //  data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {

                   
                  var data = {
                    series: data.data,
                    labels: data.type,
                    total:data.total,
                  };
                  var options = {
                      labelInterpolationFnc: function(name,value) {
                       var percentage = Math.round(data.series[value].value / data.total * 100) + '%';
                       return percentage;
                         },
                         plugins: [Chartist.plugins.legend({
                          legendNames:data.labels,
                          })]
                   };
                   
                      var responsiveOptions = [
                        ['screen and (min-width: 350px)', {
                          chartPadding: 30,
                          labelOffset: 100,
                          labelDirection: 'explode'
                        }],
                        ['screen and (min-width: 1024px)', {
                          labelOffset: 80,
                          chartPadding: 20
                        }]
                      ];

                  new Chartist.Pie('#chart-chartTasks',data, options);

                      
                },

            });
        },

        chartOverdueTasks: function () {
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;

            $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartOverdueTasks"+project,
                contentType: "application/json; charset=utf-8",
                //data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Bar('#chart-OverdueTasks', {
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
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;

            $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartTaskCompleted"+project,
                contentType: "application/json; charset=utf-8",
               // data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Bar('#chart-TaskCompleted', {
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
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;

            $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartPlannedHours"+project,
                contentType: "application/json; charset=utf-8",
             //   data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {

                    new Chartist.Bar('#chart-PlannedHours', {
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
                                classNames:data.type[0]
                            })
                        ]
                    });
                },

            });
        },
        // chartCompletedProjects: function () {
        //     $.ajax({
        //         type: "GET",
        //         url: API_PATH + "dashboard/chartCompletedProjects",
        //         contentType: "application/json; charset=utf-8",
        //         data: {project_id: $("#project_id").val()},
        //         dataType: "json",
        //         success: function (data) {


        //             new Chartist.Line('#chart-CompletedProjects', {
        //                 labels: data.months,
        //                 series:data.data

        //             }, {
        //                 scaleMinSpace: 20,
        //                 fullWidth: true,
        //                 chartPadding: {
        //                     right: 40
        //                 },
        //                 plugins: [
        //                     Chartist.plugins.legend({

        //                     })
        //                 ]
        //             });
        //         },

        //     });
        // },

        // chartCancelledProjects: function () {
        //     $.ajax({
        //         type: "GET",
        //         url: API_PATH + "dashboard/chartCancelledProjects",
        //         contentType: "application/json; charset=utf-8",
        //         data: {project_id: $("#project_id").val()},
        //         dataType: "json",
        //         success: function (data) {


        //             new Chartist.Line('#chart-CancelledProjects', {
        //                 labels: data.months,
        //                 series:data.data

        //             }, {
        //                 scaleMinSpace: 20,
        //                 fullWidth: true,
        //                 chartPadding: {
        //                     right: 40
        //                 },
        //                 plugins: [
        //                     Chartist.plugins.legend({

        //                     })
        //                 ]
        //             });
        //         },

        //     });
        // },

        chartTicketsStatstype: function () {
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;

           $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartTicketsStats"+project,
                contentType: "application/json; charset=utf-8",
                data: {option: '1'},
                dataType: "json",
                success: function (data) {


                  var data = {
                    series: data.data,
                    labels: data.type,
                    total:data.total,
                  };
                  var options = {
                      labelInterpolationFnc: function(name,value) {
                       var percentage = Math.round(data.series[value].value / data.total * 100) + '%';
                       return data.series[value].value+' = '+percentage;
                         },
                         plugins: [Chartist.plugins.legend({
                          legendNames:data.labels,
                          })]
                   };
                    var sum = function(a, b) { return a + b };

                    var responsiveOptions = [
                      ['screen and (min-width: 350px)', {
                        chartPadding: 30,
                        labelOffset: 100,
                        labelDirection: 'explode'
                      }],
                      ['screen and (min-width: 1024px)', {
                        labelOffset: 80,
                        chartPadding: 20
                      }]
                    ];

                new Chartist.Pie('#chart-chartTicketsbyType',data, options);

                    
                },

            });
        },

        chartTicketsStatsstatus: function () {
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;
           $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartTicketsStats"+project,
                contentType: "application/json; charset=utf-8",
                data: {option: '2'},
                dataType: "json",
                success: function (data) {


                  var data = {
                    series: data.data,
                    labels: data.type,
                    total:data.total,
                  };
                  var options = {
                      labelInterpolationFnc: function(name,value) {
                       var percentage = Math.round(data.series[value].value / data.total * 100) + '%';
                       return data.series[value].value+' = '+percentage;
                         },
                           plugins: [Chartist.plugins.legend({
                            legendNames:data.labels,
                            })]
                   };
                    var sum = function(a, b) { return a + b };

                    var responsiveOptions = [
                      ['screen and (min-width: 350px)', {
                        chartPadding: 30,
                        labelOffset: 100,
                        labelDirection: 'explode'
                      }],
                      ['screen and (min-width: 1024px)', {
                        labelOffset: 80,
                        chartPadding: 20
                      }]
                    ];

                new Chartist.Pie('#chart-chartTicketsbyStatus', data, options);

                    
                },

            });
        },

        chartTicketsStatspriority: function () {
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;
           $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartTicketsStats"+project,
                contentType: "application/json; charset=utf-8",
                data: {option: '3'},
                dataType: "json",
                success: function (data) {


                  var data = {
                    series: data.data,
                    labels: data.type,
                    total:data.total,
                  };
                  var options = {
                      labelInterpolationFnc: function(name,value) {
                       var percentage = Math.round(data.series[value].value / data.total * 100) + '%';
                       return data.series[value].value+' = '+percentage;
                         },
                       plugins: [Chartist.plugins.legend({
                        legendNames:data.labels,
                        })]
                   };
                    var sum = function(a, b) { return a + b };

                    var responsiveOptions = [
                      ['screen and (min-width: 350px)', {
                        chartPadding: 30,
                        labelOffset: 100,
                        labelDirection: 'explode'
                      }],
                      ['screen and (min-width: 1024px)', {
                        labelOffset: 80,
                        chartPadding: 20
                      }]
                    ];

                new Chartist.Pie('#chart-chartTicketsbyPriority', data, options);

                    
                },

            });
        },

        chartCapacity: function () {
                    var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;
           $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartCapacity"+project ,
                contentType: "application/json; charset=utf-8",
                //data: {project_id: '1'},
                dataType: "json",
                success: function (data) {

                    var data = {
                      series: data.data,
                      labels: data.type,
                      total:data.total,
                    };
                    var options = {
                        labelInterpolationFnc: function(name,value) {
                            var percentage = Math.round(data.series[value].value / data.total * 100) + '%';
                            return data.series[value].value+' = '+percentage;
                        },
                        plugins: [Chartist.plugins.legend({

                        })]
                    };
                    var sum = function(a, b) { return a + b };
                    var responsiveOptions = [
                      ['screen and (min-width: 640px)', {
                        chartPadding: 30,
                        labelOffset: 100,
                        labelDirection: 'explode'
                       
                      }],
                      ['screen and (min-width: 1024px)', {
                        labelOffset: 80,
                        chartPadding: 20
                      }]
                    ];
                    
                    new Chartist.Pie('#chart-chartCapacity', data, options);
                },

            });
        },

        chartBugsStatus: function () {
            var project = this.PROJECTID==''?'':"&project_id="+this.PROJECTID;
           $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartTicketsStatsType?type=2&option=2"+project,
                contentType: "application/json; charset=utf-8",
                // data: {option: '2'},
                dataType: "json",
                success: function (data) {

                  var data = {
                    series: data.data,
                    labels: data.type,
                    total: data.total
                  };
                  var options = {
                      labelInterpolationFnc: function(name,value) {
                       var percentage = Math.round(data.series[value].value / data.total * 100) + '%';
                       return  data.series[value].value +' = '+percentage;
                           },
                           plugins: [Chartist.plugins.legend({
                            legendNames:data.labels,
                            })]
                     };
                    var sum = function(a, b) { return a + b };

                    var responsiveOptions = [
                      ['screen and (min-width: 350px)', {
                        chartPadding: 30,
                        labelOffset: 100,
                        labelDirection: 'explode'
                      }],
                      ['screen and (min-width: 1024px)', {
                        labelOffset: 80,
                        chartPadding: 20
                      }]
                    ];

                new Chartist.Pie('#chart-chartBugsStatus', data, options);

                    
                },

            });
        },

        chartRequirements: function () {
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;
           $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartRequirements"+project,
                contentType: "application/json; charset=utf-8",
                //data: {option: '2'},
                dataType: "json",
                success: function (data) {



                
                new Chartist.Bar('#chart-chartRequirements', {
                  labels: data.type,
                  series:[data.data]

              }, {
                  scaleMinSpace: 20,
                  fullWidth: true,
                  chartPadding: {
                      right: 40
                  },
                  stackBars: true,
                  
              });
                    
                },

            });
        },

        chartResourceUtilization: function () {
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;
           $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartResourceUtilization"+project,
                contentType: "application/json; charset=utf-8",
                //data: {option: '2'},
                dataType: "json",
                success: function (data) {


                              var data = {
                      series: data.data,
                      labels: data.type,
                      total: data.total
                    };
                    var options = {
                        labelInterpolationFnc: function(name,value) {
                         var percentage = Math.round(data.series[value].value / data.total * 100) + '%';
                         return data.series[value].value +' = '+percentage;
                           },
                           plugins: [Chartist.plugins.legend({
                            legendNames:data.labels,
                            })]
                     };
                    var sum = function(a, b) { return a + b };
                     
                    var responsiveOptions = [
                      ['screen and (min-width: 350px)', {
                        chartPadding: 30,
                        labelOffset: 100,
                        labelDirection: 'explode'
                      }],
                      ['screen and (min-width: 1024px)', {
                        labelOffset: 9,

                        chartPadding: 20,
                        labelDirection: 'explode'
                      }]
                    ];

                new Chartist.Pie('#chart-chartResourceUtilization', data, options,responsiveOptions);

     
                },

            });
        },

        chartIssues: function () {
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;
           $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartIssues"+project,
                contentType: "application/json; charset=utf-8",
                //data: {option: '2'},
                dataType: "json",
                success: function (data) {


                           var data = {
                      series: data.data,
                      labels: data.type,
                      total:data.total,
                    };
                    var options = {
                        labelInterpolationFnc: function(name,value) {
                         var percentage = Math.round(data.series[value].value / data.total * 100) + '%';
                         return data.series[value].value +' = '+percentage;
                           },
                           plugins: [Chartist.plugins.legend({
                            legendNames:data.labels,
                            })]
                     };
                    var sum = function(a, b) { return a + b };

                    var responsiveOptions = [
                      ['screen and (min-width: 350px)', {
                        chartPadding: 30,
                        labelOffset: 100,
                        labelDirection: 'explode'
                      }],
                      ['screen and (min-width: 1024px)', {
                        labelOffset: 80,
                        chartPadding: 20
                      }]
                    ];

                new Chartist.Pie('#chart-chartIssues', data, options);

                    
                },

            });
        },

        percentMissingMilestone: function () {
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;

            $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/percentMissingMilestone"+project,
                contentType: "application/json; charset=utf-8",
                //data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Bar('#chart-percentMissingMilestone', {
                        labels: data.type,
                        series:[data.data]

                    }, {
                        scaleMinSpace: 100,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                       
                    });
                },

            });
        },

        chartMilestonesTasks: function () {
            var project = this.PROJECTID==''?'':"?project_id="+this.PROJECTID;

            $.ajax({
                type: "GET",
                url: API_PATH + "dashboard/chartMilestonesTasks"+project,
                contentType: "application/json; charset=utf-8",
                //data: {project_id: $("#project_id").val()},
                dataType: "json",
                success: function (data) {


                    new Chartist.Bar('#chart-chartMilestonesTasks', {
                        labels: data.type,
                        series:data.data

                    }, {
                        scaleMinSpace: 100,
                        fullWidth: true,
                        chartPadding: {
                            right: 40
                        },
                       
                    });
                },

            });
        },

    };

    return Dashboard;
}());