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
                    <div class="card-header">Users - {{ Auth::user()->name }} {{ Auth::user()->surname }}
                        <button id="add" type="button" class="btn btn-primary float-right" data-toggle="modal"
                                data-target="#createModal"
                        >Create User
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="user_datatable">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Surame</th>
                                <th>Email</th>
                                <th>Roles</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="createModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="container">
                                <div class="card">
                                    <div class="card-header">User Credentials</div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">
                                                Name:
                                            </label>
                                            <input type="text" class="form-control" id="create_name"
                                                   v-model="v_name">
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">
                                                Surname:
                                            </label>
                                            <input type="text" class="form-control" id="create_surname"
                                                   v-model="v_surname">
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="form-control-label">
                                                E-mail:
                                            </label>
                                            <input type="email" class="form-control" id="create_email"
                                                   v-model="v_email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="container">
                                <div class="card">
                                    <div class="card-header">Password Reset</div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="password" class="form-control-label">
                                                Password:
                                            </label>
                                            <input type="password" class="form-control" id="create_password"
                                                   v-model="v_password">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">
                                                Repeat Password:
                                            </label>
                                            <input type="password" class="form-control" id="create_password2"
                                                   v-model="v_password2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="vueApp.storeUser()">Create User
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="editModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="container">
                                <div class="card">
                                    <div class="card-header">User Credentials</div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">
                                                Name:
                                            </label>
                                            <input type="text" class="form-control" id="name"
                                                   v-model="v_name">
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">
                                                Surname:
                                            </label>
                                            <input type="text" class="form-control" id="surname"
                                                   v-model="v_surname">
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="form-control-label">
                                                E-mail:
                                            </label>
                                            <input type="email" class="form-control" id="email"
                                                   v-model="v_email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="container">
                                <div class="card">
                                    <div class="card-header">Password Reset</div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="password" class="form-control-label">
                                                Password:
                                            </label>
                                            <input type="password" class="form-control" id="password"
                                                   v-model="v_password">
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="form-control-label">
                                                Repeat Password:
                                            </label>
                                            <input type="password" class="form-control" id="password2"
                                                   v-model="v_password2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="vueApp.updateUser()">Update changes
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>

@endsection

@section('additional-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

    <script>


        $(document).ready(function () {
            user_datatable = $('#user_datatable').DataTable({
                "autoWidth": false,
                "sortable": false,
                "filter": false,
                "info": true,
                "serverSide": true,
                "processing": false,
                "searching": true,
                "lengthChange": true,
                "pageLength": 10,

                "ajax": {
                    "url": '{{url('/admin/user/list')}}',
                    "type": "POST",
                    "data": function (d) {
                        d._token = "{{ csrf_token() }}";
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
                        "data": "name",
                        "orderable": false
                    },
                    {
                        "data": "surname",
                        "orderable": false
                    },
                    {
                        "data": "email",
                        "orderable": false
                    },
                    {

                        "data": "role",
                        render: function (data, type, row) {
                            if (row.role == null) {
                                return 'No Role';
                            } else {
                                return row.role;
                            }
                        },
                        "orderable": false
                    },
                    {
                        "data": null,
                        "class": "text-center",
                        "orderable": false,
                        render: function (data, type, row) {
                            var temp_id = JSON.parse(row.id);
                            var urlRoute = '{{ url('/admin/user/role/?id=') }}' + temp_id;
                            return '' +
                                '<a type="button" class="btn btn-secondary m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill" ' +
                                'href="' + urlRoute + '">' +
                                'Roles' +
                                '</a>' + ' ' +
                                '<button type="button" class="btn btn-success m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill" ' +
                                '  onclick=\'vueApp.editUser(' + JSON.stringify(row) + ')\'>' +
                                'Update</i>' +
                                '</button>' + ' ' +
                                '<button type="button" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill" ' +
                                '  onclick=\'vueApp.deleteUser(' + JSON.stringify(row) + ')\'>' +
                                'Delete' +
                                '</button>';
                        }
                    }

                ],

            });

        });

        vueApp = new Vue({
            "el": '#app',
            "data": {
                v_id: null,
                v_name: null,
                v_surname: null,
                v_email: null,
                v_password: null,
                v_password2: null,
                v_user_id: null,

            },
            "methods": {

                resetModalData: function () {
                    this.v_id = null;
                    this.v_name = null;
                    this.v_surname = null;
                    this.v_email = null;
                    this.v_password = null;
                    this.v_password2 = null;
                },

                editUser: function ($row) {
                    this.resetModalData();
                    vueApp.v_id = $row.id;
                    vueApp.v_name = $row.name;
                    vueApp.v_surname = $row.surname;
                    vueApp.v_email = $row.email;
                    $('#editModal').modal('show');
                },

                storeUser: function () {
                    if(!(vueApp.v_name || vueApp.v_surname || vueApp.v_email)){
                        Swal.fire('Missing!', 'Missing information.', 'warning')
                        return;
                    }
                    if (!vueApp.v_password || !vueApp.v_password2) {
                        swal.fire('Error!', 'Password can not be empty', 'error')
                        return;
                    }
                    swal.fire({
                        title: 'Are you sure',
                        text: 'You are going to create user',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((confirmed) => {
                        if (confirmed.value) {
                            if (vueApp.v_password === vueApp.v_password2) {
                                axios.post('{{url('/admin/user/save')}}', {
                                    name: vueApp.v_name,
                                    surname: vueApp.v_surname,
                                    email: vueApp.v_email,
                                    password: vueApp.v_password,
                                }).then(function (response) {
                                    swal.fire('Created!', 'User created.', 'success')
                                    user_datatable.ajax.reload();
                                }).catch(function (e) {
                                    swal.fire('Error!', 'Something went wrong', 'error')
                                });
                                $("#createModal").modal('hide');
                                this.resetModalData();
                            } else {
                                swal.fire('Error!', 'Password not same', 'error')
                                return;
                            }
                        }
                    });
                },

                updateUser: function () {
                    if(!(vueApp.v_id || vueApp.v_name || vueApp.v_surname || vueApp.v_email)){
                        Swal.fire('Missing!', 'Missing information.', 'warning')
                        return;
                    }
                    swal.fire({
                        title: 'Are you sure',
                        text: 'You are going to create user',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((confirmed) => {
                        if (confirmed.value) {
                            if (vueApp.v_password === vueApp.v_password2) {
                                axios.post('{{url('/admin/user/update')}}', {
                                    id: vueApp.v_id,
                                    name: vueApp.v_name,
                                    surname: vueApp.v_surname,
                                    email: vueApp.v_email,
                                    password: vueApp.v_password,
                                })
                                    .then(function (response) {
                                        Swal.fire('Updated!', 'User credantials updated.', 'success')
                                        user_datatable.ajax.reload();
                                    }).catch(function (e) {
                                    Swal.fire('Error!', 'Something went wrong.', 'error')
                                });

                                $("#editModal").modal('hide');
                            } else {
                                swal.fire('Error!', 'Password not same', 'error')
                                return;
                            }
                        }
                    });
                },

                deleteUser: function ($row) {
                    swal.fire({
                        title: 'Are you sure',
                        text: 'You are going to delete this user',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((confirmed) => {
                        if (confirmed.value) {
                            axios.post('{{url('/admin/user/delete')}}', {
                                id: $row.id,
                            }).then(function (response) {
                                swal.fire('Deleted!', 'User deleted.', 'success')
                                user_datatable.ajax.reload();
                            }).catch(function (e) {
                                swal.fire('Error!', 'Something went wrong', 'error')
                            });
                        }
                    });
                    this.resetModalData();
                },

            },
            "mounted": function () {
                this.resetModalData();
            }
        });
    </script>

@endsection

