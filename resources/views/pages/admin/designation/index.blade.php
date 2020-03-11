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
                    <div class="card-header">Ekmek Kırıntısı
                        <button id="add" type="button" class="btn btn-primary float-right" data-toggle="modal"
                                data-target="#saveModal"
                        >Add Designation
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="designation_datatable">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Designation</th>
                                <th>Total Memebers</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="saveModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="container">
                                <div class="card">
                                    <div class="card-header">New Designation</div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">
                                                Designation Name:
                                            </label>
                                            <input type="text" class="form-control" id="designation_save"
                                                   v-model="v_designation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="vueApp.storeDesignation()">Save
                            Designation
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
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="container">
                                <div class="card">
                                    <div class="card-header">Update Designation</div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">
                                                Designation Name:
                                            </label>
                                            <input type="text" class="form-control" id="designation_update"
                                                   v-model="v_designation">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="vueApp.updateDesignation()">Update
                            changes
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
            designation_datatable = $('#designation_datatable').DataTable({
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
                    "url": '{{url('/admin/designation/list')}}',
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
                        "data": null,
                        "class": "text-center",
                        "orderable": false,
                        render: function (data, type, row) {
                            return '' +
                                '<button type="button" class="btn btn-success m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill" ' +
                                '  onclick=\'vueApp.editDesignation(' + JSON.stringify(row) + ')\'>' +
                                'Update' +
                                '</button>' + ' ' +
                                '<button type="button" class="btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill" ' +
                                '  onclick=\'vueApp.deleteDesignation(' + JSON.stringify(row) + ')\'>' +
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
                v_designation: null,
            },
            "methods": {

                resetModalData: function () {
                    this.v_id = null;
                    this.v_designation = null;
                },

                editDesignation: function ($row) {
                    vueApp.v_id = $row.id
                    vueApp.v_designation = $row.name
                    $('#editModal').modal('show');
                },

                storeDesignation: function () {
                    swal.fire({
                        title: 'Are you sure',
                        text: 'You are going to save designation',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((confirmed) => {
                        if (confirmed.value) {
                            axios.post('{{url('/admin/designation/save')}}', {
                                name: vueApp.v_designation,
                            }).then(function (response) {
                                swal.fire('Save!', 'Designation saved.', 'success')
                                designation_datatable.ajax.reload();
                            }).catch(function (e) {
                                swal.fire('Error!', 'Something went wrong', 'error')
                            });
                            $("#saveModal").modal('hide');
                            this.resetModalData();
                        }
                    });
                },

                updateDesignation: function(){
                    swal.fire({
                        title: 'Are you sure',
                        text: 'You are going to update selected designation',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((confirmed) => {
                       if(confirmed.value){
                           axios.post('{{ url('/admin/designation/update') }}',{
                               id: vueApp.v_id,
                               name: vueApp.v_designation,
                           }).then(function(response){
                               swal.fire('Update!', 'Designation updated', 'success')
                               designation_datatable.ajax.reload();
                           }).catch(function (e){
                               swal.fire('Error!', 'Something went wrong', 'error')
                           })
                           $('#editModal').modal('hide');
                           this.resetModalData();
                       }
                    });
                },

                deleteDesignation: function($row){
                    swal.fire({
                        title: 'Are you sure',
                        text: 'You are going to delete selected designation',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((confirmed) =>{
                        if(confirmed.value){
                         axios.post('{{ url('/admin/designation/delete') }}',{
                             id: $row.id,
                         }).then(function(response){
                                swal.fire('Delete!', 'Designation deleted', 'success')
                                designation_datatable.ajax.reload();
                            }).catch(function (e){
                                swal.fire('Error!', 'Something went wrong', 'error')
                            })
                            this.resetModalData();
                        }
                    });
                },

            },
            "mounted": function () {
                this.resetModalData();
            }
        });
    </script>

@endsection

