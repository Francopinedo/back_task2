$(function(){
    // Tomando datos de title y asignarlos en variable array para asignarlos en un renglon menos
    //Solo en los ul que tienen sub menus
    // var arr = [];
    // $.each($('li.item-title'), function(index, value){
    //     arr.push($(value).attr('title'));
    //     $(value).removeAttr('title');
    // });

    // Asignando datos de title tomados en script anterior para asignarlos nuevamente 
    // en los espan con clase .k-link
    // $.each($('li.item-title').find('span.k-link:first'), function(index, value){
    //     $(value).attr('title', arr[index]);
    //     $(value).attr("data-uk-tooltip", "{pos:'top-left'}");
    //     $(value).addClass('title-tooltip');
    // });

    //Removiendo la clase title-tooltip para no crear conflicto en los submenus.
 //    $.each($('ul.list-knowledge-area li').find('span.k-link'), function(index, value){
 //    	$(value).removeClass('title-tooltip');
 //    	$(value).addClass('title-knowledge-area');
	// });

	// $.each($('ul.list-process-group li').find('span.k-link'), function(index, value) {
	// 	$(value).removeClass('title-tooltip');
	// 	$(value).addClass('title-process-group')
	// });
	// ===============================================

    // Mostrar tooltips en Items Principales de Menu
    $('.title-tooltip').hover(function(){
    	var width = "0px";
        width = $('#sidebar_main').css('width');
        $('div.uk-tooltip').css("margin-left", width);
    });
    // ===============================================

    // Mostrar tooltip de item Organization
    $('.title-organization').hover(function(){
		tooltip($('ul.list-organization'));
	});
	// ===============================================

	// Mostrar tooltip de item Financial
	$('.title-financial').hover(function(){
		tooltip($('ul.list-financial'));
	});
	// ===============================================

	// Mostrar tooltip de item Resources
	$('.title-resources').hover(function(){
		tooltip($('ul.list-resources'));
	});
	// ===============================================

	// Mostrar tooltip de item Projects
	$('.title-projects').hover(function(){
		tooltip($('ul.list-projects'));
	});
	// ===============================================

	// Mostrar tooltip de item System Settings
	$('.title-settings').hover(function(){
		tooltip($('ul.list-settings'));
	});
	// ===============================================

	// ====================================================================================

	// Mostrar tooltip de item Favorito
	$('.title-favorite').hover(function(){
		tooltip($('ul.list-favorite'));
	});
	// ===============================================

	// Mostrar tooltip de item Gantt
	$('.title-gantt').hover(function(){
		tooltip($('ul.list-gantt'));
	});
	// ===============================================

	// Mostrar tooltip de item Knowledge Area
	$('.title-knowledge-area').hover(function(){
		tooltip($('ul.list-knowledge-area'));
	});

	// Mostrar tooltip de submen de item knowledge Area
	$('.title-knowledge').hover(function(){
		tooltip($('li.k-state-hover'));
	});
	// ===============================================

	// Mostrar tooltip de item Process Group
	$('.title-process-group').hover(function(){
		tooltip($('ul.list-process-group'));
	});

	// // Mostrar tooltip de submenu de item Process Group
	$('.data-title').hover(function(){
		tooltip($('li.k-state-hover'));
	});
	// ===============================================

	
	// $('.data-title').hover(function(){
	// 	var ancho = "0px";
	// 	$('ul.list-process-group-menu').css('width');
	// 	$('div.uk-tooltip').css('margin-left', ancho);
	// });

	remarcarMenu($('li.integration_management li'), $('li.integration_management'));
	remarcarMenu($('li.scope_management li'), $('li.scope_management'));
	remarcarMenu($('li.time_management li'), $('li.time_management'));
	remarcarMenu($('li.cost_management li'), $('li.cost_management'));
	remarcarMenu($('li.quality_management li'), $('li.quality_management'));
	remarcarMenu($('li.team_management li'), $('li.team_management'));
	remarcarMenu($('li.communication_management li'), $('li.communication_management'));
	remarcarMenu($('li.risk_management li'), $('li.risk_management'));
	remarcarMenu($('li.stakeholder_management li'), $('li.stakeholder_management'));
	remarcarMenu($('li.procurement_management li'), $('li.procurement_management'));

	remarcarMenu($('li.Initiating li'), $('li.Initiating'));
	remarcarMenu($('li.Planning li'), $('li.Planning'));
	remarcarMenu($('li.Executing li'), $('li.Executing'));
	remarcarMenu($('li.Monitoring li'), $('li.Monitoring'));
	remarcarMenu($('li.Closing li'), $('li.Closing'));

	remarcarItem($('.list-process-group li'), $('li.process_group'));
	remarcarItem($('.list-knowledge-area li'), $('li.knowledge_area'));


});

function remarcarItem(selector1, selector2){
	$.each(selector1, function(index, value){
		if(value.classList.contains( 'current_section' )){
			return selector2.addClass('current_section');
		}
	});
}

function remarcarMenu(selector1, selector2){
	$.each(selector1, function(index, value){
		if(value.classList.contains( 'select_active' )){
			return selector2.addClass('current_section');
		}
	});
}

function tooltip(selector) {
	var width = "0px";
	width = selector.css('width');
	return $('div.uk-tooltip').css('margin-left', width);
}