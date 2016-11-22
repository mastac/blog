<?php

namespace App\DataTables;

use App\Comment;
use Yajra\Datatables\Services\DataTable;

class CommentsDataTable extends DataTable
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
            ->editColumn('comment', function($comment){
                return \Html::link('/admin/comments/' . $comment->id, str_limit($comment->comment, 100));
            })
            ->addColumn('action', function ($comment) {
                return view('admin.columns.crud_action')
                    ->with('entry_id', $comment->id)
                    ->with('part_url', 'admin/comments')
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
        $query = Comment::select();

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
                [
                    'order'   => [[0, 'desc']],
                    'dom'          => 'Bfrtip',
                    'buttons'      => ['create'],
                    'initComplete' => "function () {
                                    this.api().columns().every(function () {
                                        var column = this;
                                        var input = document.createElement(\"input\");
                                        $(input).appendTo($(column.footer()).empty())
                                        .on('change', function () {
                                            column.search($(this).val(), false, false, true).draw();
                                        });
                                    });
                                }",
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
            'email',
            'comment',
            'created_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'commentsdatatables_' . time();
    }
}
