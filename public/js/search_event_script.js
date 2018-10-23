"use strict";

$(".year-choice").click(function () {
    $("#event_search_form_periodStart").val($(this).data('year')+'-01-01');
    $("#event_search_form_periodEnd").val($(this).data('year')+'-12-31');
    $( "form" ).submit();
});

$( "form" ).submit(function( event ) {
    if (new Date ($("#event_search_form_periodStart").val() ) > new Date ($("#event_search_form_periodEnd").val() )) {
        alert('Дата начала выбранного периода должна быть меньше даты его окончания');
        return false;
    }
});
