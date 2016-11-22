<a href="{{ url($part_url . '/' . $entry_id, 'edit') }}" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
<a href="#" data-toggle="modal" data-target="#confirmDelete" {{--onclick="$(this).find('form').submit();"--}} class="btn btn-xs btn-danger">
    <i class="glyphicon glyphicon-edit"></i> Delete
    <form action="{{ url($part_url , $entry_id) }}" method="post" style="margin:0;">
        <input type="hidden" name="_method" value="DELETE">
        {{ Form::token() }}
    </form>
</a>