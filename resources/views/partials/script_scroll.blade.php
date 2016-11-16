
<script type="text/javascript">

    $(function () {

        var win = $(window);

        var page = 1; // first page to loading

        var enabledScroll = true; // if scroll return empty result then disabled

        var is_run = false; // if run don't run again

        // Each time the user scrolls
        win.scroll(function () {
            if (enabledScroll) {
                // End of the document reached?
                if (($(document).height() - win.height()) < (win.scrollTop() + 370)) {
                    if(!is_run) {
                        is_run = true;
                        $.ajax({
                            url: '/{{$scroll_url}}/scroll/' + page,
                            dataType: 'html',
                            beforeSend: function(){
                                $('#loading').show();
                            },
                            success: function (html) {
                                $('#loading').hide();
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

        // Like & Dislike

        $('body').on('click', 'a.like', function(e){

            $.ajax({
                url: '/ajax/posts/like/' + $(e.target).data().postid,
                success: function(data) {
                    $(e.target).parent().find('a.like').html('&nbsp;' + data.like);
                    $(e.target).parent().find('a.dislike').html('&nbsp;' + data.dislike);
                }
            });

        }).on('click', 'a.dislike', function(e){

            $.ajax({
                url: '/ajax/posts/dislike/' + $(e.target).data().postid,
                success: function(data) {
                    $(e.target).parent().find('a.like').html('&nbsp;' + data.like);
                    $(e.target).parent().find('a.dislike').html('&nbsp;' + data.dislike);
                }
            });

        });

    })

</script>
