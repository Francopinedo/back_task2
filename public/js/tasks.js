var ge = new GanttMaster();
var tasks = (function () {
    'use strict';

    var tasks = {
            project_id: 0,
            // ge: new GanttMaster(),
            /**
             * [init
             */
            minDate: '',
            hours_by_day: '',
            init: function (project_id, minDate, hours_by_day) {


                console.log(minDate);
                tasks.minDate = new Date(minDate);
                tasks.hours_by_day = hours_by_day;
                tasks.showLoading();
                var self = this;
                self.project_id = project_id;

                // inicio
                ge.init($("#workSpace"));
                tasks.loadI18n();
                ge.set100OnClose = true;
                ge.shrinkParent = true;
                ge.zoom = 'w3';


                console.log(tasks.minDate.getTime());
                //in order to force compute the best-fitting zoom level
                // delete ge.gantt.zoom;
                // ajusto ancho
                var workSpace = $("#workSpace");
                workSpace.css({width: $('#gantt-container').width(), height: $('#gantt-container').height()});
                workSpace.trigger("resize.gantt");


                self.loadTasks(project_id);


                // envio form de crear nueva tarea
                $('#add-task').on('click', function (e) {
                    e.preventDefault();
                    self.addTask();
                });


                $('[data-toggle="tooltip"]').tooltip({"padding": 21});
                self.initEdit();
                self.initRedirecction();


                tasks.events();

            },
            events: function () {

                $('#data-form #start_date, #data-form #due_date').on('change', function () {
                    var start_date = $('#data-form #start_date').val();
                    var start_date_ms = new Date(start_date).getTime();
                    var due_date = $('#data-form #due_date').val();
                    var diff_dates = Math.floor((Date.parse(due_date) - Date.parse(start_date)) / (1000 * 60 * 60 * 24));

                    var estimated = (parseFloat(diff_dates) + 1) * parseFloat(tasks.hours_by_day);

                    $('#data-form #estimated_hours').val(estimated);
                });


                $('#data-form #progress').on('keyup', function () {
                    console.log('change progress');
                    var total_horas_duracion = $('#data-form #estimated_hours').val();
                    var bourned = ( $('#data-form #progress').val() * total_horas_duracion) / 100;

                    $('#data-form #burned_hours').val(bourned);
                });


            },
            redraw: function () {
                var self = this;
                ge.redraw();
                self.initEdit();
                self.initRedirecction();
                tasks.hideLoadding();
            },


            loadI18n: function () {
                GanttMaster.messages = {
                    "CANNOT_WRITE": "No permission to change the following task:",
                    "CHANGE_OUT_OF_SCOPE": "Project update not possible as you lack rights for updating a parent project.",
                    "START_IS_MILESTONE": "Start date is a milestone.",
                    "END_IS_MILESTONE": "End date is a milestone.",
                    "TASK_HAS_CONSTRAINTS": "Task has constraints.",
                    "GANTT_ERROR_DEPENDS_ON_OPEN_TASK": "Error: there is a dependency on an open task.",
                    "GANTT_ERROR_DESCENDANT_OF_CLOSED_TASK": "Error: due to a descendant of a closed task.",
                    "TASK_HAS_EXTERNAL_DEPS": "This task has external dependencies.",
                    "GANNT_ERROR_LOADING_DATA_TASK_REMOVED": "GANNT_ERROR_LOADING_DATA_TASK_REMOVED",
                    "CIRCULAR_REFERENCE": "Circular reference.",
                    "CANNOT_DEPENDS_ON_ANCESTORS": "Cannot depend on ancestors.",
                    "INVALID_DATE_FORMAT": "The data inserted are invalid for the field format.",
                    "GANTT_ERROR_LOADING_DATA_TASK_REMOVED": "An error has occurred while loading the data. A task has been trashed.",
                    "CANNOT_CLOSE_TASK_IF_OPEN_ISSUE": "Cannot close a task with open issues",
                    "TASK_MOVE_INCONSISTENT_LEVEL": "You cannot exchange tasks of different depth.",
                    "CANNOT_MOVE_TASK": "CANNOT_MOVE_TASK",
                    "PLEASE_SAVE_PROJECT": "PLEASE_SAVE_PROJECT",
                    "GANTT_SEMESTER": "Semester",
                    "GANTT_SEMESTER_SHORT": "s.",
                    "GANTT_QUARTER": "Quarter",
                    "GANTT_QUARTER_SHORT": "q.",
                    "GANTT_WEEK": "Week",
                    "GANTT_WEEK_SHORT": "w."
                };
            },

            getPositionById: function (id) {
                var r;
                $.each(ge.tasks, function (index, value) {
                    if (value.id === id) {
                        r = index;
                        return false; // esto solo sirve para detener el loop, no es lo que retorna la funcion realmente
                    }
                });
                return r;
            }
            ,
            /**
             * loadTasks
             */
            loadTasks: function (project_id) {
                var self = this;


                $.ajax({
                    url: API_PATH + 'tasks?project_id=' + project_id,
                    type: 'get',
                    dataType: 'json'
                }).done(function (data) {

                        var taskslist = new Array();

                        var ind = 0;
                        var lenght = data.data.length - 1;
                        console.log(lenght)
                        jQuery.each(data.data, function (i, value) {
                            if (value.start_date == "0000-00-00") {
                                var start = new Date().getTime();
                            } else {
                                var start = new Date(value.start_date).getTime();
                            }


                            if (value.due_date == "0000-00-00") {
                                var end = new Date().getTime();
                            } else {
                                var end = new Date(value.due_date).getTime();
                            }


                            var finaltask = {
                                'id': value.id,
                                'project_id': value.project_id,
                                'name': value.description,
                                'start_date': value.start_date,
                                'due_date': value.due_date,
                                'progressByWorklog': false,
                                'start': start,
                                'end': end,
                                'duration': value.duration,
                                'requirement_id': value.requirement_id,
                                'startIsMilestone': value.start_is_milestone,
                                'endIsMilestone': value.end_is_milestone,
                                'progress': value.progress,
                                'depends': value.depends,
                                'priority': value.priority,
                                'estimated_hours': value.estimated_hours,
                                'burned_hours': value.burned_hours,
                                'business_value': value.business_value,
                                'phase': value.phase,
                                'version': value.version,
                                'release': value.release,
                                'label': value.label,
                                'comments': value.comments,
                                'attachment': value.attachment,
                                'level': value.level,
                                'status': value.status,
                                'index': value.index,
                                "relevance": 0,
                                "hours_by_day": tasks.hours_by_day,
                            };
                            taskslist.push(finaltask);

                            if (ind === lenght || lenght == '-1') {

                                console.log(taskslist);

                                var ret = {

                                    "tasks": taskslist,
                                    // [
                                    //      {
                                    //          "id": -1,
                                    //          "name": "Gantt editor",
                                    //          "progress": 0,
                                    //          "progressByWorklog": false,
                                    //          "relevance": 0,
                                    //          "type": "",
                                    //          "typeId": "",
                                    //          "description": "",
                                    //          "code": "",
                                    //          "level": 0,
                                    //          "status": "STATUS_ACTIVE",
                                    //          "depends": "",
                                    //          "canWrite": true,
                                    //          "start": 1396994400000,
                                    //          "duration": 20,
                                    //          "end": 1399586399999,
                                    //          "startIsMilestone": false,
                                    //          "endIsMilestone": false,
                                    //          "collapsed": false,
                                    //          "assigs": [],
                                    //          "hasChild": false
                                    //      },
                                    // ],
                                    "canWrite": true,
                                    "canDelete": true,
                                    "canWriteOnParent": true,
                                    "canAdd": true,
                                    "zoom": "w4",
                                    "canSeePopEdit": false,
                                    "canSeeFullEdit": false,
                                    "minEditableDate": tasks.minDate.getTime(),

                                };


                                ge.loadProject(ret);
                                //actualize data


                                tasks.hideLoadding();
                                ge.checkpoint(); //empty the undo stack
                                self.redraw();

                            }
                            ind++;
                        });


                        if (lenght == '-1') {

                            console.log(taskslist);

                            var ret = {

                                "tasks": taskslist,

                                "canWrite": true,
                                "canDelete": true,
                                "canWriteOnParent": true,
                                "canAdd": true,
                                "zoom": "w4",
                                "canSeePopEdit": false,
                                "canSeeFullEdit": false,
                                "minEditableDate": tasks.minDate.getTime()
                            };
                            ge.loadProject(ret);
                            tasks.hideLoadding();
                            ge.checkpoint(); //empty the undo stack
                            self.redraw();

                        }


                    }
                );
            }
            ,
            /**
             * addTask
             */
            addTask: function () {


                console.log('adding task.');
                var self = this;

                var description = $('#data-form #description').val();
                var start_date = $('#data-form #start_date').val();
                var start_date_ms = new Date(start_date).getTime();
                var due_date = $('#data-form #due_date').val();
                var diff_dates = Math.floor((Date.parse(due_date) - Date.parse(start_date)) / (1000 * 60 * 60 * 24));

                if (description != '' && start_date != '' && due_date != '') {
                    $("#status_code-error").css('display', 'none');

                    // createTask (id, name, code, level, start, duration)
                    var i = ge.tasks.length;
                    // var newTask = ge.createTask(i + 1, description, '', 0, start_date_ms, diff_dates);
                    var num = i + 1;
                    var newTask = ge.createTask('temp_' + num, description, '', 0, start_date_ms, diff_dates);
                    ge.addTask(newTask, i);
                    self.redraw();

                    // Agrego los campos extra como si estuviera actualizando
                    var index = self.getPositionById(newTask.id);
                    ge.tasks[index].requirement_id = $('#data-form #requirement_id').val();
                    ge.tasks[index].priority = $('#data-form #priority').val();
                    ge.tasks[index].estimated_hours = $('#data-form #estimated_hours').val();
                    ge.tasks[index].burned_hours = $('#data-form #burned_hours').val();
                    ge.tasks[index].business_value = $('#data-form #business_value').val();
                    ge.tasks[index].phase = $('#data-form #phase').val();
                    ge.tasks[index].version = $('#data-form #version').val();
                    ge.tasks[index].release = $('#data-form #release').val();
                    ge.tasks[index].comments = $('#data-form #comments').val();
                    ge.tasks[index].start_date = start_date;
                    ge.tasks[index].due_date = due_date;
                    ge.tasks[index].name = description;
                    ge.tasks[index].duration = diff_dates;
                    ge.tasks[index].start = start_date_ms;
                    ge.tasks[index].depends = $('#data-form input[name=depends]').val();
                    ge.tasks[index].progress = $('#data-form input[name=progress]').val();
                    /* ge.tasks[index].startIsMilestone  = $('#data-form input[name=start_is_milestone]').val();;
                     ge.tasks[index].endIsMilestone   = $('#data-form input[name=end_is_milestone]').val();*/

                    var start_date = $('#data-form #start_date').val();
                    var start = new Date(start_date);
                    var start_date_ms = start.getTime();

                    var due_date = $('#data-form #due_date').val();
                    console.log(due_date);
                    var end = new Date(due_date);
                    console.log(end);
                    end.setDate(end.getDate() + 1);
                    console.log(end);
                    var due_date_ms = end.getTime();

                    console.log(due_date_ms);

                    ge.changeTaskDates(newTask, start_date_ms, due_date_ms);


                    console.log(ge);
                    $('#create_div_toggle').hide();
                    $('#create_div').removeClass('switcher_active');

                    self.redraw();

                } else {
                    $("#status_code-error").css('display', 'block');
                    $("#status_code-error").text('Pleasse complete description, start and due date');
                }

                // tasks.saveOnServer();

            }
            ,


            addQuotation: function () {


                $.ajax({
                    url: 'quotation/create',
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function (data) {
                        var $switcher_ajax_create = $('#ajax_create_div'),
                            $switcher_ajax_create_toggle = $('#ajax_create_div_toggle');

                        $('#ajax_create_div').addClass('switcher_active');
                        $('#ajax_create_div').css('position', 'absolute');
                        $('.ajax_create_div').html(data.view);
                    }
                );
            },

        addwhatif: function () {


                $.ajax({
                    url: 'whatif/create',
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function (data) {
                        var $switcher_ajax_create = $('#ajax_create_div'),
                            $switcher_ajax_create_toggle = $('#ajax_create_div_toggle');

                        $('#ajax_create_div').addClass('switcher_active');
                        $('#ajax_create_div').css('position', 'absolute');
                        $('.ajax_create_div').html(data.view);
                    }
                );
            },


            initEdit: function () {

                var self = this;

                console.log('iniciando deeditar');
                $('.edit-task').unbind().on('click', function (e) {
                    console.log('tratando de editar');
                    if (tasks.checkId($(this).data('id'))) {
                        e.preventDefault();
                        self.showEditForm($(this).data('id'));
                    } else {
                        console.log('no es un numero 2');
                        alert(saveFirst);
                    }
                });
            }
            ,
		  exitTasks: function (save) {
                var self = this;
                $("#btn_exit").addClass('disabled');
                console.log('exiting');
                var element = $("#page_content");
                kendo.ui.progress(element, true);
     			//e.preventDefault();
     			///////////////////////////////
			  UIkit.modal.confirm('Save Changes before Exit?', function () {
                kendo.ui.progress(element, true);
                   var self = this;
                if (save != undefined) {
                    setTimeout(function () {
                        this.tasks.saveOnServer()
                    }, 3000);
                }
//                kendo.ui.progress(element, false);


            },function () {
                   //var self = this;
               tasks.loadTasks(self.project_id);
               tasks.redraw();
             
            },{
                labels: {
                   'ok': 'Save Changes and Exit',
                    'cancel': 'Exit Without Save'
                }
            });
			  //////////////////////////////////
            }
            ,
            showLoading: function (save) {
                $("#btn_save").addClass('disabled');
                console.log('showing');
                var element = $("#page_content");
                kendo.ui.progress(element, true);
                // $(".k-loading-mask").css('display', 'block');
                if (save != undefined) {
                    setTimeout(function () {
                        tasks.saveOnServer()
                    }, 3000);
                }
            }
            ,
            hideLoadding: function () {
                console.log('hiddin');
                $("#btn_save").removeClass('disabled');
                var element = $("#page_content");
                kendo.ui.progress(element, false);
                // $(".k-loading-mask").css('display', 'none');
            }
            ,

            showEditForm: function (id) {
                var self = this;
                // inicializo acciones del boton editar
                var $switcher_edit = $('#edit_div'),
                    $switcher_edit_toggle = $('#edit_div_toggle'),
                    $edit_url;

                $edit_url = './tasks/' + id + '/edit';
                $switcher_edit_toggle.show();
                $('#edit_div').addClass('switcher_active');
                self.loadEditForm($edit_url);


                $switcher_edit_toggle.unbind().click(function (e) {
                    e.preventDefault();
                    $switcher_edit.toggleClass('switcher_active');
                });
            }
            ,

            loadForm: function ($edit_url) {
                $.ajax({
                    url: $edit_url,
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function (data) {
                        $('.edit_div').html(data.view);
                    }
                );
            }
            ,
            /*====================================
             =            loadEditForm            =
             ====================================*/


            loadEditForm: function ($edit_url) {
                $.ajax({
                    url: $edit_url,
                    type: 'GET',
                    dataType: 'json'
                }).done(
                    function (data) {
                        $('.edit_div').html(data.view);

                        var task = ge.getTask($('#data-form-edit input[name=id]').val());

                        console.log(task);
                        $('#data-form-edit input[name=description]').val(task.name);
                        $('#data-form-edit input[name=duration]').val(task.duration);

                        $('#data-form-edit input[name=start_date]').val(moment(new Date(task.start)).format('YYYY-MM-DD'));
                        $('#data-form-edit input[name=due_date]').val(moment(new Date(task.end)).format('YYYY-MM-DD'));
                        $('#data-form-edit select[name=requirement_id]').val(task.requirement_id);
                        $('#data-form-edit input[name=progress]').val(task.progress);
                        $('#data-form-edit input[name=depends]').val(task.depends);
                        $('#data-form-edit select[name=priority]').val(task.priority);
                        $('#data-form-edit input[name=estimated_hours]').val(task.estimated_hours);


                        $('#data-form-edit select[name=business_value]').val(task.business_value);
                        $('#data-form-edit input[name=phase]').val(task.phase);
                        $('#data-form-edit input[name=version]').val(task.version);
                        $('#data-form-edit input[name=release]').val(task.release);
                        $('#data-form-edit input[name=label]').val(task.label);

                        //calculo de bourned hours
                        var total_horas_duracion = task.duration * tasks.hours_by_day;
                        var bourned = ( task.progress * total_horas_duracion) / 100;
                        $('#data-form-edit input[name=burned_hours]').val(bourned);

                        //calculo de estimated hours
                        var estimated = task.duration * tasks.hours_by_day;
                        $('#data-form-edit input[name=estimated_hours]').val(estimated);


                        $('#data-form-edit #start_date, #data-form-edit #due_date').on('change', function () {
                            console.log('changeddd');
                            var start_date = $('#data-form-edit input[name=start_date]').val();
                            var start_date_ms = new Date(start_date).getTime();
                            var due_date = $('#data-form-edit input[name=due_date]').val();
                            var diff_dates = Math.floor((Date.parse(due_date) - Date.parse(start_date)) / (1000 * 60 * 60 * 24));

                            var estimated = (diff_dates + 1) * tasks.hours_by_day;
                            $('#data-form-edit input[name=estimated_hours]').val(estimated);
                        })


                        $('#data-form-edit #progress').on('keyup', function () {
                            console.log('change progress');
                            var total_horas_duracion = $('#data-form-edit #estimated_hours').val();
                            var bourned = ( $('#data-form-edit #progress').val() * total_horas_duracion) / 100;

                            $('#data-form-edit #burned_hours').val(bourned);
                        });
                    }
                );
            }
            ,
            initEditForm: function () {
                var self = this;

                $('#data-form-edit input:visible:enabled:first').focus();

                $('#update-task-btn').click(function (e) {

                    e.preventDefault();
                    var description = $('#data-form-edit input[name=description]').val();

                    var start_date = $('#data-form-edit input[name=start_date]').val();
                    var start = new Date(start_date);
                    var start_date_ms = start.getTime();

                    var due_date = $('#data-form-edit input[name=due_date]').val();
                    var end = new Date(due_date);
                    end.setDate(end.getDate() + 1);
                    var due_date_ms = end.getTime();
                    // var diff_dates = Math.floor((Date.parse(due_date) - Date.parse(start_date))/(1000*60*60*24)) + 1;
                    // console.log(diff_dates);

                    var diff_dates = 0;
                    for (var d = start; d <= end + 1; d.setDate(d.getDate() + 1)) {
                        if (!isHoliday(d)) {
                            diff_dates = diff_dates + 1;
                        }
                    }

                    diff_dates = diff_dates;

                    var task = ge.getTask($('#data-form-edit input[name=id]').val());
                    var index = self.getPositionById(task.id);

                    ge.tasks[index].start_date = start_date;
                    ge.tasks[index].due_date = due_date;
                    ge.tasks[index].name = description;
                    ge.tasks[index].duration = diff_dates;
                    ge.tasks[index].start = start_date_ms;
                    ge.tasks[index].requirement_id = $('#data-form-edit select[name=requirement_id]').val();
                    ge.tasks[index].progress = $('#data-form-edit input[name=progress]').val();
                    ge.tasks[index].depends = $('#data-form-edit input[name=depends]').val();
                    ge.tasks[index].priority = $('#data-form-edit select[name=priority]').val();
                    ge.tasks[index].estimated_hours = $('#data-form-edit input[name=estimated_hours]').val();
                    ge.tasks[index].burned_hours = $('#data-form-edit input[name=burned_hours]').val();
                    ge.tasks[index].business_value = $('#data-form-edit select[name=business_value]').val();
                    ge.tasks[index].phase = $('#data-form-edit input[name=phase]').val();
                    ge.tasks[index].version = $('#data-form-edit input[name=version]').val();
                    ge.tasks[index].release = $('#data-form-edit input[name=release]').val();
                    ge.tasks[index].label = $('#data-form-edit input[name=label]').val();
                    ge.tasks[index].comments = $('#data-form-edit input[name=comments]').val();
                    ge.tasks[index].depends = $('#data-form-edit input[name=depends]').val();

                    /* ge.tasks[index].startIsMilestone  = $('#data-form-edit input[name=start_is_milestone]').val();
                     ge.tasks[index].endIsMilestone   = $('#data-form-edit input[name=end_is_milestone]').val();*/

                    ge.changeTaskDates(task, start_date_ms, due_date_ms);
                    ge.updateLinks(task);

                    console.log('editando esto', ge);
                    console.log('UPDATE TASK');
                    
                    
                    $.ajax({
                        url: API_PATH + 'tasks/'+task.id,
                        type: 'POST',
                        async: false,
                        data: $('#data-form-edit').serializeArray(), 
                        dataType: 'json',
                        success: function (json) {
                        self.loadTasks(self.project_id);
                         self.redraw();
                        },
                        error: function (json) {
                            console.log('error');
                            console.log(json);
                        }
                    });

                    $('#edit_div_toggle').hide();
                    $('#edit_div').removeClass('switcher_active');


                    // tasks.saveOnServer();
                    self.redraw();
                });
            }
            ,
            /**
             * SaveOnServer
             */
            saveOnServer: function () {

                var self = this;
                if (ge.deletedTaskIds > 0) {
                    console.log(ge.deletedTaskIds);
                    console.log('DELETE TASK');
                    $.ajax({
                        url: API_PATH + 'tasks/delete/all',
                        type: 'DELETE',
                        async: false,
                        data: {'tasks': ge.deletedTaskIds},
                        dataType: 'json',
                        success: function (json) {
                            self.loadTasks(self.project_id);
                                    self.redraw();
                        },
                        error: function (json) {
                            console.log('error');
                            console.log(json);
                        }
                    });
                }


                var indx = 0;
                var lengttasks = ge.tasks.length - 1;

                var tasksToAdd = new Array();
                var tasksToEdit = new Array();
                $.each(ge.tasks, function (index, value) {
                    var url;
                    var verb;
                    var data = {};


                    if (Math.floor(value.id) == value.id && $.isNumeric(value.id)) { // si es una tarea existente, que tiene ID, entonces la actualizo
                        //console.log('actualizar', value);
                        url = API_PATH + 'tasks/' + value.id;
                        verb = 'PATCH';
                        var start_d = new Date(value.start);
                        data.start_date = moment(start_d).format('YYYY-MM-DD');
                        var end_d = new Date(value.end);
                        data.due_date = moment(end_d).format('YYYY-MM-DD');
                        data.id = value.id;
                    }
                    else { // si no tiene un ID entonces es una tarea que se debe crear
                        console.log('nueva');
                        url = API_PATH + 'tasks';
                        verb = 'POST';
                        data.project_id = self.project_id;
                        // data.start_date = moment(value.start).format("YYYY-MM-DD");
                        // data.due_date = moment(value.end).format("YYYY-MM-DD");
                        var start_d = new Date(value.start);
                        data.start_date = moment(start_d).format('YYYY-MM-DD');
                        var end_d = new Date(value.end);
                        data.due_date = moment(end_d).format('YYYY-MM-DD');

                        // Es obligatorio que todas las tareas tengan phase
                        // ACTUALIZACION: como esto daba problemas, entonces lo que hago es que las tareas que no tengan phase se les ponga phase 'default'
                        if (typeof(value.phase) !== undefined) {
                            // console.log('no tiene phase');
                            value.phase = 'default';
                            // alert(addPhase);
                            // return;
                        } else {
                            console.log('Tiene phase');
                        }
                    }

                    data.description = value.name;
                    data.index = indx;

                    console.log(value.startIsMilestone);
                    data.requirement_id = value.requirement_id == undefined ? '' : value.requirement_id;
                    data.start_is_milestone = value.startIsMilestone ? 1 : 0;
                    data.end_is_milestone = value.endIsMilestone ? 1 : 0;
                    data.progress = value.progress;
                    data.depends = value.depends;
                    data.priority = value.priority;

                    data.business_value = value.business_value;
                    data.phase = value.phase;
                    data.version = value.version;
                    data.release = value.release;
                    data.label = value.label;
                    data.comments = value.comments;
                    data.level = value.level;
                    data.duration = value.duration;
                    data.status = value.status;
                    data.hours_by_day = tasks.hours_by_day;

                    //calculo de bourned hours
                    var total_horas_duracion = value.duration * tasks.hours_by_day;
                    var bourned = ( value.progress * total_horas_duracion) / 100;
                    data.burned_hours = bourned;

                    //calculo de estimated hours
                    var estimated = value.duration * tasks.hours_by_day;
                    data.estimated_hours = estimated;


                    if ((Math.floor(value.id) == value.id && $.isNumeric(value.id))) {
                        if(indx==(value.index))
                        {
                         tasksToEdit.push(data);
                        console.log('EDIT TASK'+data);
                        }else{
                          tasksToAdd.push(data);
                        console.log('ADD TASK'+data);
                        }
                    } else {
                        tasksToAdd.push(data);
                        console.log('ADD TASK'+data);


                    }
                    
                    if (lengttasks === indx) {
                    }
                    
                           

                    indx++;
                });
                
                   if (tasksToAdd.length > 0) {

                             console.log(tasksToAdd);
                            console.log('ADD TASK');
                    

                           var url = API_PATH + 'tasks/store/all';
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {tasks: tasksToAdd},
                                async: false,
                                dataType: 'json',
                                success: function (json) {
                                     self.loadTasks(self.project_id);
                                    self.redraw();
                                },
                                error: function (json) {
                                    console.log('error');
                                    console.log(json);
                                }
                            });
                        }
                    
                         if (tasksToAdd.length == 0 && tasksToEdit.length > 0) {

                             console.log(tasksToEdit);
                            console.log('UPDATE TASK');
                    

                           var url = API_PATH + 'tasks/update/all';
                            $.ajax({
                                url: url,
                                type: 'POST',
                                data: {tasks: tasksToEdit},
                                async: false,
                                dataType: 'json',
                                success: function (json) {
                                     self.loadTasks(self.project_id);
                                    self.redraw();
                                },
                                error: function (json) {
                                    console.log('error');
                                    console.log(json);
                                }
                            });
                        }
                 

                    

            }
            ,
            checkId: function (id) {

                if (Math.floor(id) == id && $.isNumeric(id)) {
                    return true;
                }
                else {
                    alert(saveFirst);
                    return false;
                }
            }
            ,
            initRedirecction: function () {
                var self = this;

                $('.go-to-tickets').unbind().on('click', function (e) {

                    e.preventDefault();

                    var win = window.open("tasks/" + $(this).data('id') + "/tickets", '_blank');
                    if (win) {
                        //Browser has allowed it to be opened
                        win.focus();
                    } else {
                        //Browser has blocked it
                        alert('Please allow popups for this website');
                    }


                    // $('#edit_div').addClass('switcher_active');
                    //self.loadForm("tasks/" + $(this).data('id') + "/tickets");

                    // window.location.href = "tasks/" + $(this).data('id') + "/tickets";
                });

                $('.go-to-rows').unbind().on('click', function (e) {
                    e.preventDefault();

                    if (tasks.checkId($(this).data('id'))) {
                        e.preventDefault();
                        var win = window.open("tasks/" + $(this).data('id') + "/rows", '_blank');
                        if (win) {
                            //Browser has allowed it to be opened
                            win.focus();
                        } else {
                            //Browser has blocked it
                            alert('Please allow popups for this website');
                        }
                    } else {
                        alert(saveFirst);
                    }

                    // window.location.href = "tasks/" + $(this).data('id') + "/tickets";
                });
            }
            ,
        }
    ;

    return tasks;
}());