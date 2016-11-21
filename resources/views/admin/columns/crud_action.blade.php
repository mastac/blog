<a href="{{ url($part_url . '/' . $entry_id, 'edit') }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
<a href="javascript:void(0);" onclick="$(this).find('form').submit();" class="btn btn-xs btn-danger">
    <i class="glyphicon glyphicon-edit"></i> Delete
    <form action="{{ url($part_url , $entry_id) }}" method="post">
        <input type="hidden" name="_method" value="DELETE">
        {{ Form::token() }}
    </form>
</a>