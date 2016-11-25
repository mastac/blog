<?php

namespace App\DataTables;

use App\Post;
use Datatables;
use Yajra\Datatables\Services\DataTable;
use Illuminate\Support\Facades\DB;

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
            ->filterColumn('author', function($query, $keyword) {
                $query->whereRaw("CONCAT(users.first_name,' ',users.last_name) like ?", ["%{$keyword}%"]);
            })
            ->editColumn('name', function($post){
                return \Html::link('/admin/posts/' . $post->id, str_limit($post->name, 50));
            })
            ->editColumn('text', function($post){
                return str_limit($post->text, 100);
            })
            ->editColumn('likes', function($post){
                return $post->like . ' / ' . $post->dislike;
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
        $query = Post::withCount('comments')->withCount('tags')
            ->leftjoin('users', 'users.id', '=', 'posts.user_id')
            ->select(
                'posts.id',
                'posts.name',
                'posts.text',
                'posts.created_at',
                DB::raw('CONCAT(users.first_name, " ", users.last_name) as author'))
        ;

        return $this->applyScopes( $query );
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
            ->addAction(['width' => '100px', 'exportable' => false, 'printable' => false])
            ->parameters(
                [
                    'order'   => [[0, 'desc']],
                    'dom'          => "<'row'<'col-sm-6'Br><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'li><'col-sm-7'p>>",
                    'buttons'      => [
                        'create',
                        'excel',
                        'csv',
                        'pdf',
                        'print'
                    ],
                    'stateSave' => true
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
            'id' => ['name' => 'posts.id'],
            'name'  => ['name' => 'posts.name'],
            'text' => ['name' => 'posts.text', 'exportable' => false, 'printable' => false ],
            'author',
            'likes' => ['searchable' => false, 'title' => 'Like / Dislike', 'orderable' => false, 'width' => '100'],
//            'comments_count' => ['searchable' => false],
//            'tags_count' => ['searchable' => false],
            'created_at' => ['width' => '100', 'name' => 'posts.created_at'],
//            'updated_at' => ['width' => '100px'],
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
