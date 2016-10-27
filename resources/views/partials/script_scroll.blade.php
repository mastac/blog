
<script type="text/javascript">

    $(function () {

        var win = $(window);

        var page = 1;

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
                            url: '{{$scroll_part_url}}/scroll/' + page,
                            dataType: 'html',
                            success: function (html) {
                                if (html) {
                                    page += 1;
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
