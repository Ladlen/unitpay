$(function(){$('#goods a').click(function(){var tab_id=$(this).attr('id');tabClick(tab_id)});function tabClick(tab_id){if(tab_id!=$('#goods a.active').attr('id')){$('#goods .tabs').removeClass('active');$('#'+tab_id).addClass('active');$('#con_'+ tab_id).addClass('active');}}});