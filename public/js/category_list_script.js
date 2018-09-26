"use strict";

$(".category-edit").click(function () {
    var cat_id = $(this).parent().parent().data('category-id');
    var initial_name = $(this).parent().parent().children('.category-name').text();
    var element = $('<input/>')
        .attr('type', 'text')
        .addClass('name_input')
        .val(initial_name)
        .wrap($('<td/>'));
    $(this).parent().parent().children('.category-name').html('').append(element).children('.name_input').focus();
    $('.name_input').blur(function () {
        var new_name = $(this).val();
        $(this).parent().replaceWith('<td class="category-name">'+new_name+'</td>');
        $.ajax({
            url : '/category_edit',
            type: "post",
            data: JSON.stringify({id: cat_id, name: new_name}),
            contentType: "application/json"
        });
    });
});
