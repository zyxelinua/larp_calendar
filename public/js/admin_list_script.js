"use strict";

$(".entity-edit").click(function () {
    var entity_id = $(this).parents('tr').data('entity-id');
    var initial_name = $(this).parent().children('.entity-name').text();
    $(this).siblings('.entity-name').hide()
    $(this).siblings('.entity-delete').hide()
    $(this).siblings('.entity-save').show()
    $(this).siblings('.entity-cancel').show()
    $(this).siblings('.input-name').show()
    $(this).hide()

    $(".entity-cancel").click(function () {
        $(this).siblings('.entity-name').text(initial_name).show()
        $(this).siblings('.entity-delete').show()
        $(this).siblings('.entity-edit').show()
        $(this).siblings('.entity-save').hide()
        $(this).siblings('.input-name').val(initial_name).hide()
        $(this).hide()

    });

    $(".entity-save").click(function () {
        var new_name = $(this).siblings('.input-name').val();
        $(this).siblings('.entity-name').text(new_name)
        $(this).siblings('.entity-name').show()
        $(this).siblings('.entity-delete').show()
        $(this).siblings('.entity-edit').show()
        $(this).siblings('.entity-cancel').hide()
        $(this).siblings('.input-name').hide()
        $(this).hide()

        $.ajax({
            url : $(this).siblings('.entity-edit').data('edit-path'),
            type: "post",
            data: JSON.stringify({id: entity_id, name: new_name}),
            contentType: "application/json"
        });
    });
});

$(".entity-delete").click(function () {
    return confirm('Вы уверены, что хотите удалить эту запись?');
});
