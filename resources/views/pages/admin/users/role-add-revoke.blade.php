@extends('layouts.master')

@section('additional-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection



@section('page-content')
    <div class="container col-md-12" style="padding-top: 2%;" id="app">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $user->name }} {{ $user->surname }}
                        <button id="add" type="button" class="btn btn-primary float-right" data-toggle="modal"
                                onclick="vueApp.assignRole()"
                        >Add Role
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="role_datatable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="modal fade" id="assignModal">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Roles</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <select class="form-control m-input m-input--square"
                                        id="selected_role_id" v_model="v_selected_role_id">
                                    <option v-bind:value="-1" disabled selected>Select Role</option>
                                    <option v-for="role in v_roles"
                                            v-bind:value="role.id">
                                        @{{role.name}}
                                    </option>
                                </select>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="vueApp.storeRoleToUser()">
                                    Assign
                                </button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

            </div>
        </div>
    </div>
@endsection

@section('additional-js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>


    <script>


        $(document).ready(function () {
            role_datatable = $('#role_datatable').DataTable({
                "autoWidth": false,
                "sortable": false,
                "filter": false,
                "info": true,
                "processing": false,
                "serverSide": true,
                "searching": false,
                "lengthChange": true,
                "pageLength": 10,

                "ajax": {
                    "url": '{{url('/admin/user/role/list')}}',
                    "type": "POST",
                    "data": function (d) {
                        d._token = "{{ csrf_token() }}";
                        d.user_id = JSON.parse({{$user->id}});
                    }
                },
                "order": [[0, "asc"]],
                "columns": [
                    {
                        "data": "id",
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        "orderable": false
                    },
                    {
                        "width": "80%",
                        "data": "name",
                        "orderable": false
                    },
                    {
                        "data": null,
                        "class": "text-center",
                        "orderable": false,
                        render: function (data, type, row) {
                            return '' +
                                '<button type="button" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill" ' +
                                '  onclick=\'vueApp.revokeRole(' + JSON.stringify(row) + ')\'>' +
                                'Delete</i>' +
                                '</button>';
                        }
                    }

                ],

            });

        });

        vueApp = new Vue({
            "el": '#app',
            "data": {
                v_role_id: null,
                v_selected_role_id: null,
                v_roles: null,
            },
            "methods": {

                resetModalData: function () {
                    this.role_id = null;
                    this.v_selected_role_id = null;
                    this.v_roles = null;
                },

                assignRole: function () {
                    this.resetModalData();
                    this.getHavingNoRoles();
                    $('#assignModal').modal('show');
                },

                revokeRole: function ($row) {
                    swal.fire({
                        title: 'Are you sure',
                        text: 'You are going to revoke this role',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((confirmed) => {
                        if (confirmed.value) {
                            axios.post('{{url('/admin/user/revoke/role')}}', {
                                id: $row.id,
                            }).then(function (response) {
                                swal.fire('Deleted!', 'Role revoked to user.', 'success')
                                role_datatable.ajax.reload();
                            }).catch(function (e) {
                                swal.fire('Error!', 'Something went wrong', 'error')
                            });
                        }
                    });
                },

                storeRoleToUser: function () {
                    vueApp.v_selected_role_id = $("#selected_role_id").val()
                    if(!vueApp.v_selected_role_id ){
                        Swal.fire('Missing!', 'Please select role.', 'warning')
                        return;
                    }
                    swal.fire({
                        title: 'Are you sure',
                        text: 'You are going to assign this role',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((confirmed) => {
                        if (confirmed.value) {
                            axios.post('{{url('/admin/user/assign/role')}}', {
                                role_id: vueApp.v_selected_role_id,
                                user_id: JSON.stringify({{$user->id}})
                            })
                                .then(function (response) {
                                    Swal.fire('Success!', 'Role assigned to user.', 'success')
                                    role_datatable.ajax.reload();
                                }).catch(function (e) {
                                Swal.fire('Error!', e.response.data.message, 'error')
                            });
                            $("#assignModal").modal('hide');
                        }
                    });
                },

                getHavingNoRoles: function () {
                    axios.post('{{url('/admin/user/has-no-role/option')}}', {
                        user_id: JSON.stringify({{$user->id}})
                    })
                        .then(function (response) {
                            vueApp.v_roles = response.data;
                        }).catch(function (e) {
                    });
                },
            },
            "mounted": function () {
                this.resetModalData();
            }
        });
    </script>
@endsection


