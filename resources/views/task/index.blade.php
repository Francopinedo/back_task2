@extends('layouts.app', ['favoriteTitle' => __('tasks.tasks'), 'favoriteUrl' => 'tasks'])
@if(!session()->has('project_id'))
@section('content')
    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1" id="gantt-container">


                    <div class="uk-alert uk-alert-danger" data-uk-alert>
                        <a href="#" class="uk-alert-close uk-close"></a>
                        {{ __('projects.you_need_a_project') }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@endif

@if(session()->has('project_id'))
@section('scripts')

    <script type="text/javascript">
        var holidaysForGantt = '{{ $holidaysForGantt }}';

        var vsunIsHoly = '{{ in_array(0, $project->holy_days)?true:false }}';
        var vmonIsHoly = '{{ in_array(1, $project->holy_days)?true:false }}';
        var vtueIsHoly = '{{ in_array(2, $project->holy_days)?true:false }}';
        var vwedIsHoly = '{{ in_array(3, $project->holy_days)?true:false }}';
        var vthuIsHoly = '{{ in_array(4, $project->holy_days)?true:false }}';
        var vfriIsHoly = '{{ in_array(5, $project->holy_days)?true:false }}';
        var vsatIsHoly = '{{ in_array(6, $project->holy_days)?true:false }}';
        var vmillisInWorkingDay = '{{ isset($project->hours_by_day)&&!empty($project->hours_by_day * 3600000)?$project->hours_by_day:8*3600000 }}';
    </script>

    <script src="{{ asset('jQueryGantt/libs/jquery/jquery.livequery.1.1.1.min.js')}}"></script>
    <script src="{{ asset('jQueryGantt/libs/jquery/jquery.timers.js')}}"></script>

    <script src="{{ asset('jQueryGantt/libs/utilities.js')}}"></script>
    <script src="{{ asset('jQueryGantt/libs/forms.js')}}"></script>
    <script src="{{ asset('jQueryGantt/libs/date.js')}}"></script>
    <script src="{{ asset('jQueryGantt/libs/dialogs.js')}}"></script>
    <script src="{{ asset('jQueryGantt/libs/layout.js')}}"></script>
    <script src="{{ asset('jQueryGantt/libs/i18nJs.js')}}"></script>
    <script src="{{ asset('jQueryGantt/libs/jquery/dateField/jquery.dateField.js')}}"></script>
    <script src="{{ asset('jQueryGantt/libs/jquery/JST/jquery.JST.js')}}"></script>

    <script type="text/javascript" src="{{ asset('jQueryGantt/libs/jquery/svg/jquery.svg.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('jQueryGantt/libs/jquery/svg/jquery.svgdom.1.8.js')}}"></script>


    <script src="{{ asset('jQueryGantt/ganttUtilities.js')}}"></script>
    <script src="{{ asset('jQueryGantt/ganttTask.js')}}"></script>
    <script src="{{ asset('jQueryGantt/ganttDrawerSVG.js')}}"></script>
    <script src="{{ asset('jQueryGantt/ganttZoom.js')}}"></script>
    <script src="{{ asset('jQueryGantt/ganttGridEditor.js')}}"></script>
    <script src="{{ asset('jQueryGantt/ganttMaster.js')}}"></script>

    <script src="{{ asset('bower_components/parsleyjs/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <script type="text/javascript">
        var saveFirst = '{{ __('tasks.saveFirst') }}';
        var addPhase = '{{ __('tasks.addPhase') }}';
    </script>

    <script src="{{ asset('js/tasks.js') }}"></script>

    <script>
        $(document).ready(function () {
            tasks.init({{ session('project_id') }}, '{{ $project->start}}', '{{ isset($project->hours_by_day)&&!empty($project->hours_by_day)?$project->hours_by_day:8}}');

        });

    </script>
@endsection
@section('css')
    <style>
        .fa-2x {

            font-size: 1.5em !important;
        }
    </style>
    <link rel=stylesheet href="{{ asset('jQueryGantt/platform.css') }}" type="text/css">
    <link rel=stylesheet href="{{ asset('jQueryGantt/libs/jquery/dateField/jquery.dateField.css') }}" type="text/css">

    <link rel=stylesheet href="{{ asset('jQueryGantt/gantt.css') }}" type="text/css">
    <link rel=stylesheet href="{{ asset('jQueryGantt/ganttPrint.css') }}" type="text/css" media="print">
@endsection

<style>
    .tooltip {
        z-index: 999 !important
    }

    .k-loading-mask {
        z-index: 100 !important; /* must be larger than the z-index:2 of #container */
    }
</style>
@section('section_title', __('tasks.tasks'))

@section('content')
    <div id="window"></div>


    <div id="gantEditorTemplates" style="display:none;">
        <div class="__template__" type="GANTBUTTONS"><!--
	  <div class="ganttButtonBar noprint">
	    <div class="buttons">
	      <button onclick="$('#workSpace').trigger('undo.gantt');return false;" data-toggle="tooltip" class="button textual icon requireCanWrite" title="undo"><i class="fa fa-undo fa-2x" aria-hidden="true"></i></button>
	      <button onclick="$('#workSpace').trigger('redo.gantt');return false;"   data-toggle="tooltip"  class="button textual icon requireCanWrite" title="redo"><i class="fa fa-repeat fa-2x" aria-hidden="true"></i></button>
	      <span class="ganttButtonSeparator requireCanWrite requireCanAdd"></span>
	      <button onclick="$('#workSpace').trigger('addAboveCurrentTask.gantt');return false;"  data-toggle="tooltip" class="button textual icon requireCanWrite requireCanAdd" title="insert above"><i class="fa fa-chevron-up fa-2x" aria-hidden="true"></i></button>
	      <button onclick="$('#workSpace').trigger('addBelowCurrentTask.gantt');return false;"  data-toggle="tooltip" class="button textual icon requireCanWrite requireCanAdd" title="insert below"><i class="fa fa-chevron-down fa-2x" aria-hidden="true"></i></button>
	      <button id="add-new" style="float: none;"  data-toggle="tooltip" class="button textual icon requireCanWrite requireCanAdd" title="insert box"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></button>
	      <span class="ganttButtonSeparator requireCanWrite requireCanInOutdent"></span>
	      <button onclick="$('#workSpace').trigger('outdentCurrentTask.gantt');return false;"  data-toggle="tooltip" class="button textual icon requireCanWrite requireCanInOutdent" title="un-indent task"><i class="fa fa-outdent fa-2x" aria-hidden="true"></i></button>
	      <button onclick="$('#workSpace').trigger('indentCurrentTask.gantt');return false;"  data-toggle="tooltip" class="button textual icon requireCanWrite requireCanInOutdent" title="indent task"><i class="fa fa-indent fa-2x" aria-hidden="true"></i></button>
	      <span class="ganttButtonSeparator requireCanWrite requireCanMoveUpDown"></span>
	      <button onclick="$('#workSpace').trigger('moveUpCurrentTask.gantt');return false;"  data-toggle="tooltip" class="button textual icon requireCanWrite requireCanMoveUpDown" title="move up"><i class="fa fa-long-arrow-up fa-2x" aria-hidden="true"></i></button>
	      <button onclick="$('#workSpace').trigger('moveDownCurrentTask.gantt');return false;"  data-toggle="tooltip" class="button textual icon requireCanWrite requireCanMoveUpDown" title="move down"><i class="fa fa-long-arrow-down fa-2x" aria-hidden="true"></i></button>


	         <span class="ganttButtonSeparator requireCanWrite requireCanDelete"></span>
      <button onclick="$('#workSpace').trigger('deleteFocused.gantt');return false;" data-toggle="tooltip" class="button textual icon delete requireCanWrite" title="Elimina"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></button>

	      <span class="ganttButtonSeparator requireCanAddIssue"></span>
	      <button onclick="$('#workSpace').trigger('addIssue.gantt');return false;"  data-toggle="tooltip" class="button textual icon requireCanAddIssue" title="add issue / todo"><span class="teamworkIcon">i</span></button>

	      <span class="ganttButtonSeparator"></span>
	      <button onclick="$('#workSpace').trigger('expandAll.gantt');return false;"  data-toggle="tooltip" class="button textual icon " title="EXPAND_ALL"><i class="fa fa-expand fa-2x" aria-hidden="true"></i></button>
	      <button onclick="$('#workSpace').trigger('collapseAll.gantt'); return false;"  data-toggle="tooltip" class="button textual icon " title="COLLAPSE_ALL"><i class="fa fa-compress fa-2x" aria-hidden="true"></i></button>

	    <span class="ganttButtonSeparator"></span>
	      <button onclick="$('#workSpace').trigger('zoomMinus.gantt'); return false;"  data-toggle="tooltip" class="button textual icon " title="zoom out"><i class="fa fa-search-minus fa-2x" aria-hidden="true"></i></button>
	      <button onclick="$('#workSpace').trigger('zoomPlus.gantt');return false;"  data-toggle="tooltip" class="button textual icon " title="zoom in"><i class="fa fa-search-plus fa-2x" aria-hidden="true"></i></button>
	    <span class="ganttButtonSeparator"></span>
	      <button onclick="print();return false;"  data-toggle="tooltip" class="button textual icon " title="Print"><i class="fa fa-print fa-2x" aria-hidden="true"></i></button>
	    <span class="ganttButtonSeparator"></span>
	      <button onclick="ge.gantt.showCriticalPath=!ge.gantt.showCriticalPath; ge.redraw();return false;"  data-toggle="tooltip" class="button textual icon requireCanSeeCriticalPath" title="CRITICAL_PATH"><i class="fa fa-heartbeat fa-2x" aria-hidden="true"></i></button>
	    <span class="ganttButtonSeparator requireCanSeeCriticalPath"></span>
	      <button onclick="ge.splitter.resize(.1);return false;"  data-toggle="tooltip" title="Left"  class="button textual icon" ><i class="fa fa-long-arrow-left fa-2x" aria-hidden="true"></i></button>
	      <button onclick="ge.splitter.resize(50);return false;"  data-toggle="tooltip"  title="Split" class="button textual icon" ><i class="fa fa-arrows-h fa-2x" aria-hidden="true"></i></button>
	      <button onclick="ge.splitter.resize(100);return false;"  data-toggle="tooltip" title="Right" class="button textual icon"><i class="fa fa-long-arrow-right fa-2x" aria-hidden="true"></i></button>

	      &nbsp; &nbsp; &nbsp; &nbsp;

	       <button  id="btn_quotation"  onclick="tasks.addQuotation(true); "  style="float: right;" class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light requireWrite" title="{{ __('tasks.quotation') }}">{{ __('tasks.quotation') }}</button>



	    <button id="btn_save" onclick="tasks.showLoading(true); " style="float: right;" class="md-btn md-btn-primary md-btn-wave-light waves-effect waves-button waves-light requireWrite" title="{{ __('tasks.save') }}">{{ __('tasks.save') }}</button>

	    </div></div>
	  --></div>

        <div class="__template__" type="TASKSEDITHEAD"><!--
	  <table class="gdfTable" cellspacing="0" cellpadding="0">
	    <thead>
	    <tr style="height:40px">
	      <th class="gdfColHeader" style="width:35px; border-right: none"></th>
	      <th class="gdfColHeader" style="width:78px;"></th>
	      <th class="gdfColHeader gdfResizable" style="width:300px;">name</th>
	      <th class="gdfColHeader"  align="center" style="width:20px;" title="Start date is a milestone."><span class="teamworkIcon" style="font-size: 8px;">^</span></th>
	      <th class="gdfColHeader gdfResizable" style="width:80px;">start</th>
	      <th class="gdfColHeader"  align="center" style="width:20px;" title="End date is a milestone."><span class="teamworkIcon" style="font-size: 8px;">^</span></th>
	      <th class="gdfColHeader gdfResizable" style="width:80px;">End</th>
	      <th class="gdfColHeader gdfResizable" style="width:50px;">dur.</th>
	      <th class="gdfColHeader gdfResizable" style="width:20px;">%</th>
	      <th class="gdfColHeader gdfResizable requireCanSeeDep" style="width:50px;">depe.</th>
	      <th class="gdfColHeader gdfResizable" style="width:1000px; text-align: left; padding-left: 10px;"></th>
	    </tr>
	    </thead>
	  </table>
	  --></div>

        <div class="__template__" type="TASKROW"><!--
	  <tr taskId="(#=obj.id#)" class="taskEditRow (#=obj.isParent()?'isParent':''#) (#=obj.collapsed?'collapsed':''#)" level="(#=level#)">
	    <th class="gdfCell" align="right" style="cursor:pointer;"><span class="taskRowIndex">(#=obj.getRow()+1#)</span></th>
	    <td class="gdfCell noClip" align="right">
	    	<a href="#" data-id="(#=obj.id#)" onclick="tasks.checkId('(#=obj.id#)');" class="edit-task" title="{{ __('tasks.edit') }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
	    		<a href="#" data-id="(#=obj.id#)" onclick="tasks.checkId('(#=obj.id#)');" data-toggle="tooltip"  class="go-to-rows" title="{{ __('tasks.resources') }}"><i class="fa fa-list-alt" aria-hidden="true"></i></a>
	    	<a href="#" data-id="(#=obj.id#)" onclick="tasks.checkId('(#=obj.id#)');" data-toggle="tooltip" class="go-to-tickets" title="{{ __('tasks.tickets') }}"><i class="fa fa-list-ul" aria-hidden="true"></i></a>

	    	<div class="taskStatus cvcColorSquare" status="(#=obj.status#)"></div>
	    </td>
	    <td class="gdfCell indentCell" style="padding-left:(#=obj.level*10+18#)px;">
	      <div class="exp-controller" align="center"></div>
	      <input type="text" name="name" value="(#=obj.name#)" placeholder="name">
	    </td>
	    <td class="gdfCell" align="center"><input type="checkbox" name="startIsMilestone"></td>
	    <td class="gdfCell"><input type="text" name="start"  value="" class="date"></td>
	    <td class="gdfCell" align="center"><input type="checkbox" name="endIsMilestone"></td>
	    <td class="gdfCell"><input type="text" name="end" value="" class="date"></td>
	    <td class="gdfCell"><input type="text" name="duration" autocomplete="off" value="(#=obj.duration#)"></td>
	    <td class="gdfCell"><input type="text" name="progress" class="validated" entrytype="PERCENTILE" autocomplete="off" value="(#=obj.progress?obj.progress:''#)" (#=obj.progressByWorklog?"readOnly":""#)></td>
	    <td class="gdfCell requireCanSeeDep"><input type="text" name="depends" autocomplete="off" value="(#=obj.depends#)" (#=obj.hasExternalDep?"readonly":""#)></td>

	  </tr>
	  --></div>

        <div class="__template__" type="TASKEMPTYROW"><!--
	  <tr class="taskEditRow emptyRow" >
	    <th class="gdfCell" align="right"></th>
	    <td class="gdfCell noClip" align="center"></td>
	    <td class="gdfCell"></td>
	    <td class="gdfCell"></td>
	    <td class="gdfCell"></td>
	    <td class="gdfCell"></td>
	    <td class="gdfCell"></td>
	    <td class="gdfCell"></td>
	    <td class="gdfCell"></td>
	    <td class="gdfCell requireCanSeeDep"></td>

	  </tr>
	  --></div>

        <div class="__template__" type="TASKBAR"><!--
	  <div class="taskBox taskBoxDiv" taskId="(#=obj.id#)" >
	    <div class="layout (#=obj.hasExternalDep?'extDep':''#)">
	      <div class="taskStatus" status="(#=obj.status#)"></div>
	      <div class="taskProgress" style="width:(#=obj.progress>100?100:obj.progress#)%; background-color:(#=obj.progress>100?'red':'rgb(153,255,51);'#);"></div>
	      <div class="milestone (#=obj.startIsMilestone?'active':''#)" ></div>

	      <div class="taskLabel"></div>
	      <div class="milestone end (#=obj.endIsMilestone?'active':''#)" ></div>
	    </div>
	  </div>
	  --></div>

        <div class="__template__" type="CHANGE_STATUS"><!--
	    <div class="taskStatusBox">
	      <div class="taskStatus cvcColorSquare" status="STATUS_ACTIVE" title="active"></div>
	      <div class="taskStatus cvcColorSquare" status="STATUS_DONE" title="completed"></div>
	      <div class="taskStatus cvcColorSquare" status="STATUS_FAILED" title="failed"></div>
	      <div class="taskStatus cvcColorSquare" status="STATUS_SUSPENDED" title="suspended"></div>
	      <div class="taskStatus cvcColorSquare" status="STATUS_UNDEFINED" title="undefined"></div>
	    </div>
	  --></div>

        <div class="__template__" type="TASK_EDITOR"><!--
	  <div class="ganttTaskEditor">
	    <h2 class="taskData">Task editorasdasd</h2>
	    <table  cellspacing="1" cellpadding="5" width="100%" class="taskData table" border="0">
	          <tr>
	        <td width="200" style="height: 80px"  valign="top">
	          <label for="code">code/short name</label><br>
	          <input type="text" name="code" id="code" value="" size=15 class="formElements" autocomplete='off' maxlength=255 style='width:100%' oldvalue="1">
	        </td>
	        <td colspan="3" valign="top"><label for="name" class="required">name</label><br><input type="text" name="name" id="name"class="formElements" autocomplete='off' maxlength=255 style='width:100%' value="" required="true" oldvalue="1"></td>
	          </tr>


	      <tr class="dateRow">
	        <td nowrap="">
	          <div style="position:relative">
	            <label for="start">start</label>&nbsp;&nbsp;&nbsp;&nbsp;
	            <input type="checkbox" id="startIsMilestone" name="startIsMilestone" value="yes"> &nbsp;<label for="startIsMilestone">is milestone</label>&nbsp;
	            <br><input type="text" name="start" id="start" size="8" class="formElements dateField validated date" autocomplete="off" maxlength="255" value="" oldvalue="1" entrytype="DATE">
	            <span title="calendar" id="starts_inputDate" class="teamworkIcon openCalendar" onclick="$(this).dateField({inputField:$(this).prevAll(':input:first'),isSearchField:false});">m</span>          </div>
	        </td>
	        <td nowrap="">
	          <label for="end">End</label>&nbsp;&nbsp;&nbsp;&nbsp;
	          <input type="checkbox" id="endIsMilestone" name="endIsMilestone" value="yes"> &nbsp;<label for="endIsMilestone">is milestone</label>&nbsp;
	          <br><input type="text" name="end" id="end" size="8" class="formElements dateField validated date" autocomplete="off" maxlength="255" value="" oldvalue="1" entrytype="DATE">
	          <span title="calendar" id="ends_inputDate" class="teamworkIcon openCalendar" onclick="$(this).dateField({inputField:$(this).prevAll(':input:first'),isSearchField:false});">m</span>
	        </td>
	        <td nowrap="" >
	          <label for="duration" class=" ">Days</label><br>
	          <input type="text" name="duration" id="duration" size="4" class="formElements validated durationdays" title="Duration is in working days." autocomplete="off" maxlength="255" value="" oldvalue="1" entrytype="DURATIONDAYS">&nbsp;
	        </td>
	      </tr>

	      <tr>
	        <td  colspan="2">
	          <label for="status" class=" ">status</label><br>
	          <select id="status" name="status" class="taskStatus" status="(#=obj.status#)"  onchange="$(this).attr('STATUS',$(this).val());">
	            <option value="STATUS_ACTIVE" class="taskStatus" status="STATUS_ACTIVE" >active</option>
	            <option value="STATUS_SUSPENDED" class="taskStatus" status="STATUS_SUSPENDED" >suspended</option>
	            <option value="STATUS_DONE" class="taskStatus" status="STATUS_DONE" >completed</option>
	            <option value="STATUS_FAILED" class="taskStatus" status="STATUS_FAILED" >failed</option>
	            <option value="STATUS_UNDEFINED" class="taskStatus" status="STATUS_UNDEFINED" >undefined</option>
	          </select>
	        </td>

	        <td valign="top" nowrap>
	          <label>progress</label><br>
	          <input type="text" name="progress" id="progress" size="7" class="formElements validated percentile" autocomplete="off" maxlength="255" value="" oldvalue="1" entrytype="PERCENTILE">
	        </td>
	      </tr>

	          </tr>
	          <tr>
	            <td colspan="4">
	              <label for="description">Description</label><br>
	              <textarea rows="3" cols="30" id="description" name="description" class="formElements" style="width:100%"></textarea>
	            </td>
	          </tr>
	        </table>

	    <h2>Assignments</h2>
	  <table  cellspacing="1" cellpadding="0" width="100%" id="assigsTable">
	    <tr>
	      <th style="width:100px;">name</th>
	      <th style="width:70px;">Role</th>
	      <th style="width:30px;">est.wklg.</th>
	      <th style="width:30px;" id="addAssig"><span class="teamworkIcon" style="cursor: pointer">+</span></th>
	    </tr>
	  </table>

	  <div style="text-align: right; padding-top: 20px">
	    <span id="saveButton" class="button first" onClick="$(this).trigger('saveFullEditor.gantt');">Save</span>
	  </div>

	  </div>
	  --></div>


        <div class="__template__" type="ASSIGNMENT_ROW"><!--
	  <tr taskId="(#=obj.task.id#)" assId="(#=obj.assig.id#)" class="assigEditRow" >
	    <td ><select name="resourceId"  class="formElements" (#=obj.assig.id.indexOf("tmp_")==0?"":"disabled"#) ></select></td>
	    <td ><select type="select" name="roleId"  class="formElements"></select></td>
	    <td ><input type="text" name="effort" value="(#=getMillisInHoursMinutes(obj.assig.effort)#)" size="5" class="formElements"></td>
	    <td align="center"><span class="teamworkIcon delAssig del" style="cursor: pointer">d</span></td>
	  </tr>
	  --></div>


        <div class="__template__" type="RESOURCE_EDITOR"><!--
	  <div class="resourceEditor" style="padding: 5px;">

	    <h2>Project team</h2>
	    <table  cellspacing="1" cellpadding="0" width="100%" id="resourcesTable">
	      <tr>
	        <th style="width:100px;">name</th>
	        <th style="width:30px;" id="addResource"><span class="teamworkIcon" style="cursor: pointer">+</span></th>
	      </tr>
	    </table>

	    <div style="text-align: right; padding-top: 20px"><button id="resSaveButton" class="button big">Save</button></div>
	  </div>
	  --></div>


        <div class="__template__" type="RESOURCE_ROW"><!--
	  <tr resId="(#=obj.id#)" class="resRow" >
	    <td ><input type="text" name="name" value="(#=obj.name#)" style="width:100%;" class="formElements"></td>
	    <td align="center"><span class="teamworkIcon delRes del" style="cursor: pointer">d</span></td>
	  </tr>
	  --></div>


    </div>

    <div class="md-card">
        <div class="md-card-content">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-1-1" id="gantt-container">

                    @if(session()->has('message'))
                        <div class="uk-alert uk-alert-{{ session('alert-class', 'close') }}" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ session('message') }}
                        </div>
                    @endif

                    @if(!session()->has('project_id'))
                        <div class="uk-alert uk-alert-danger" data-uk-alert>
                            <a href="#" class="uk-alert-close uk-close"></a>
                            {{ __('projects.you_need_a_project') }}
                        </div>
                    @endif

                    @if(session()->has('project_id'))

                        <div id="workSpace"
                             style="padding:0px;  border:0px solid #e5e5e5; position:relative; margin:0 5px; width:1024px; height:800px;"></div>

                    @endif
                </div>
            </div>
        </div>
    </div>





@endsection

@section('create_div')
    @component('task/create', [
                    'users' => $users,
                    'project' => $project,
                    'requirements' => $requirements,
                ]
            )

    @endcomponent
@endsection

<div id="ajax_create_div">
    <div id="ajax_create_div_toggle" style="display: none;"><i class="fa fa-angle-double-right fa-2x"
                                                               aria-hidden="true"></i></div>
    <div class="ajax_create_div">

    </div>
</div>


@endif