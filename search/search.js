$(document).ready(function() {

    $("#search-form-input").keyup(function (e) {
        if( !$('#search-form-input').val() == '' ) {
            $.ajax({
                url: "search/search.php",
                type: "POST",
                data: $('#search-form').serialize(),
                dataType: 'json',
                success: function (results) {
                    var output = '';
                    results.forEach(function (result) {
                        output += "<a href='book.php?id=" + result['ID'] + "' >" + result['name']
                            + " (" + result['year'] + ")</a><br>";
                    });
                    // Double check for bug fix when deleting text in search box to fast
                    if( !$('#search-form-input').val() == '' ) {
                        $('#search-form-results').html(output);
                    }
                }
            });
        } else {
            $('#search-form-results').html('');
        }
    });

    $(window).click(function() {
        $('#search-form-results').html('');
    });

    $('#search-form-results, #search-form-input').click(function(event){
        event.stopPropagation();
    });
});