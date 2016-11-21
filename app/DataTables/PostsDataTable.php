<?php

namespace App\DataTables;

use App\Post;
use Yajra\Datatables\Services\DataTable;

class PostsDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('name', function($post){
                return \Html::link('/admin/posts/' . $post->id, $post->name/*, ['target' => '_blank']*/);
            })
            ->editColumn('text', function($post){
                return str_limit($post->text, 100);
            })
            ->addColumn('action', function ($post) {
                return view('admin.columns.crud_action')
                    ->with('entry_id', $post->id)
                    ->with('part_url', 'admin/posts')
                    ;
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Post::withCount('comments')->withCount('tags');
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->ajax('')
                    ->addAction(['width' => '100px'])
                    ->parameters(
//                        $this->getBuilderParameters()
                        [
                        'dom'          => 'Bfrtip',
                        'buttons'      => ['create'],
//                        'initComplete' => "function () {
//                                    this.api().columns().every(function () {
//                                        var column = this;
//                                        var input = document.createElement(\"input\");
//                                        $(input).appendTo($(column.footer()).empty())
//                                        .on('change', function () {
//                                            column.search($(this).val(), false, false, true).draw();
//                                        });
//                                    });
//                                }",
                        ]
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'name',
            'text',
            'comments_count' => ['searchable' => false],
            'tags_count' => ['searchable' => false],
            'created_at' => ['width' => '100px'],
            'updated_at' => ['width' => '100px'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'postsdatatables_' . time();
    }
}
