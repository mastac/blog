<?php

namespace App\DataTables;

use App\User;
use Yajra\Datatables\Facades\Datatables;
use Yajra\Datatables\Services\DataTable;

class UsersDataTable extends DataTable
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
            ->editColumn('full_name', function($user){
                return \Html::link('/admin/users/' . $user->id, $user->first_name . ' ' . $user->last_name);
            })
            ->addColumn('action', function ($user) {
                return view('admin.columns.crud_action')
                    ->with('entry_id', $user->id)
                    ->with('part_url', 'admin/users')
                    ;
            })
            ->removeColumn('updated_at')
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = User::select([
            'users.id',
            'users.name',
            'users.email',
            'users.first_name',
            'users.last_name',
            'users.activated',
            'users.is_admin',
            \DB::raw('count(posts.user_id) as count_posts'),
            'user_activations.created_at as activated_at',
            'users.created_at',
            'users.updated_at'
        ])
            ->leftJoin('posts', 'posts.user_id', '=', 'users.id')
            ->leftJoin('user_activations', 'user_activations.user_id', '=', 'users.id')
            ->groupBy('users.id')
        ;

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
                    ->addAction(['width' => 150, 'exportable' => false, 'printable' => false])
                    ->parameters([
                        'dom'          => "<'row'<'col-sm-6'Br><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'li><'col-sm-7'p>>",
                        'buttons'      => [
                            'create',
                            'excel',
                            'csv',
                            'pdf',
                            'print'
                        ],
                        'stateSave' => true
                    ]);
    }



    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['data' => 'id', 'name' => 'users.id', 'searchable' => false],
            'email',
            'full_name' => ['searchable' => false, 'orderable' => false],
//            'name' => ['data' => 'name', 'name' => 'users.name'],
            'count_posts' => ['searchable' => false],
            'activated_at' => ['searchable' => false],
            'created_at' => ['data' => 'created_at', 'name' => 'users.created_at', 'width' => '100', 'title'=>'Register At'],
//            'updated_at' => ['data' => 'updated_at', 'name' => 'users.updated_at', 'width' => '100px'],
//            'activated',
//            'is_admin'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'usersdatatables_' . time();
    }

}
