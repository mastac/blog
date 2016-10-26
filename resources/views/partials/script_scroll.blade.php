
<script type="text/javascript">

    $(function () {

        var win = $(window);

        var limit = 5;

        var offset = 5;

        var enabledScroll = true;

        var is_run = false;

        // Each time the user scrolls
        win.scroll(function () {
            if (enabledScroll) {
                // End of the document reached?
                if (($(document).height() - win.height()) < (win.scrollTop() + 370)) {
                    if(!is_run) {
                        is_run = true;
                        $.ajax({
                            url: '/posts/{{$entry}}/scroll/' + offset + '/' + limit,
                            dataType: 'html',
                            success: function (html) {
                                if (html) {
                                    offset = offset + limit;
                                    $('#posts').append(html);
                                    is_run = false;
                                } else {
                                    enabledScroll = false;
                                }
                            }
                        });
                    }
                }
            }// enabledScroll
        });

    })

</script>
