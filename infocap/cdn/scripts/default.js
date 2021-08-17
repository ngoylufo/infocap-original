$(document).ready(function() {
    var form = $('form');
    var send = $('.ajax-submit');
    var output = $('.ajax-output');

    send.attr('type', 'submit');
    form.submit(function(){ return false; });
    $('.die').delay(3000).fadeOut(300);
    $('.sorter').attr('data-toggle', "tooltip").attr('title', "Asynchronously reorder table based by this column!");

    function output_response(element, response) {
        element.empty().html(response).fadeIn(200);
    }

    function clean_response(element, duration, fade) {
        setTimeout(function(){ element.fadeOut(fade); }, duration * 1000);
    }

    function loader () {
        response = '<tr class="text-center"><td colspan="4"><img src="cdn/images/loader.gif"></td></tr>';
        output_response($('#ajax-people'), response);
    }

    function get_offset() {
        var offset = Number($('.ajax-pagination').find('.active a').text());
        if (!offset)
            return 0
        return (offset > 1 ? (offset - 1) * 10 : 0);
    }

    function get_people() {
        var page = "cdn/ajax/people.php";
        var params = {
            column: ($('.sorter[sorting="true"]').attr('js-column') || 'id'),
            order: $('select[name="order"]').val(),
            offset: get_offset()
        };

        loader();

        $.post(page, params, function(response) {
            $('#ajax-people').html(response);
            var person = $('#ajax-people').find('tr.person');

            person.attr('data-toggle', "tooltip")
            .attr('title', "Click row to retrieve more information!")
            .attr('data-placement', "left");

            $('[data-toggle="tooltip"]').tooltip();

            person.click(function(){
                var page = "cdn/ajax/person.php";
                var id = $(this).attr('id');
                $.post(page, {id: id}, function(response){
                    $('.modal-body').html(response);
                    var deletePerson = $('.modal-body').find('.ajax-delete');

                    deletePerson.click(function() {
                        var page = "cdn/ajax/delete.php";
                        $('#personModal').modal('hide');
                        $.post(page, {id: deletePerson.attr('delete-id')}, function(response) {
                            get_people();
                            output_response($('#alert'), response);
                            clean_response($('#alert'), 4, 'slow');
                        });
                    });
                });
                $('#personModal').modal('show');
            });
        });
    }

    function paginator(link) {
        var page = "cdn/ajax/paginator.php";
        $.post(page, {page: link}, function(response) {
            $('.ajax-pagination').html(response);
            var pageItem = $('.ajax-pagination').find('.page-item');
            get_people();

            pageItem.click(function() {
                var element = $(this).find('.page-link');
                var id = element.attr('id');

                if (id) {
                    var link = Number($('.ajax-pagination').find('.active a').text());
                    link = id == 'next' ? link + 1 : link - 1;
                } else
                    var link = element.text();

                paginator(link);
            });
        });
    }

    var captureForm = $('form[name="Capture Form"]');
    captureForm.submit(function() {
        var element = $('#alert');

        $(this).ajaxSubmit({
            url: "cdn/ajax/process.php",
            type: 'POST',
            success: function(response) {
                output_response(element, response);
            },
            complete: function(){
                clean_response(element, 4, 'slow');
            },
        });
    });

    $('#ajax-people').ready(function(){
        paginator(1);
    });

    $('select[name="order"]').change(function () {
        paginator(1);
    });

    // what happens if it is active
    $('.sorter').click(function(){
        var sorting = $(this).attr('sorting');

        if (sorting == 'true') {
            $(this).attr('sorting', 'false').removeClass('text-danger');
        } else {
            $('.sorter[sorting]').attr('sorting', 'false').removeClass('text-danger');
            $(this).attr('sorting', 'true').addClass('text-danger');
        }

        // $('.sorter[sorting]').attr('sorting', 'false').removeClass('text-danger');
        // $(this).attr('sorting', 'true').addClass('text-danger');
        get_people();
    });
});
