@if (!empty($search_url))
<div class="search widget">
    <form action="{{url($search_url, 'search')}}" method="POST" class="searchform" role="search">
        {{csrf_field()}}
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit"> <i class="ion-search"></i> </button>
            </span>
        </div><!-- /input-group -->
    </form>
</div>
@endif