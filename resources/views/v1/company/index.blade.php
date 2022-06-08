@extends('layouts.theme.master')
@section('title')
    Companies Management
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                @if ($message = Session::get('galat'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <button class="btn btn-primary btn-sm" id="createNewItem"><i
                                        class="fas fa-plus mr-2"></i>Add Companies</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Balance</th>
                                            <th>Website</th>
                                            <th>Logo</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Balance</th>
                                            <th>Website</th>
                                            <th>Logo</th>
                                            <th>action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- Add New Companie -->
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelHeading"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ItemForm" name="ItemForm" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="Item_id" id="Item_id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="nama" class="form-label">Name Companies</label>
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="E.g Axxx"
                                        autocomplete="off" required>
                                </div>
                                <div class="mb-2">
                                    <label for="email" class="form-label">Email Companies</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                        placeholder="E.g example@domain.com" autocomplete="off" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="balance" class="form-label">Add Start Balance Companies</label>
                                    <input type="number" name="balance" class="form-control" id="balance"
                                        placeholder="E.g 1xx" autocomplete="off" required>
                                </div>
                                <div class="mb-2">
                                    <label for="website" class="form-label">Website Companies</label>
                                    <input type="text" name="website" class="form-control" id="website"
                                        placeholder="E.g Teknik Informatika" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="custom-file" class="form-label">Logo Companies</label>
                            <div class="custom-file">
                                <input type="file" name="logo" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <span class="text-danger" id="image-input-error"></span>
                        </div>
                        <button type="submit" class="btn btn-secondary tombol float-right" id="saveBtn"
                            value="create"></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css-tambahan')
    <link rel="stylesheet" href="{{ asset('cdn/datatables/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn/datatables/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cdn/datatables/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('js-tambahan')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('cdn/datatables/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('cdn/datatables/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Page specific script -->
    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('company.index') }}",
                pageLength: 5,
                lengthMenu: [5, 10, 20, 50, 100, 200, 500],
                responsive: true,
                lengthChange: true,
                autoWidth: true,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'balance',
                        name: 'balance'
                    },
                    {
                        data: 'website',
                        name: 'website'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
            // show modal to add new companies
            $('#createNewItem').click(function() {
                $('#saveBtn').val("create-Item");
                $('#Item_id').val('');
                $('#ItemForm').trigger("reset");
                $('#modelHeading').html("Add Companies");
                $('.tombol').html("submit");
                $('#ajaxModel').modal('show');
            });

            // add data with ajax realtime show data in tables
            $('#ItemForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $('#image-input-error').text('');

                $.ajax({
                    type: "POST",
                    url: "{{ route('company.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Selamat!",
                                text: response.success
                            });
                            $('#ItemForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Mohon Maaf!",
                                text: response.error
                            });
                        }
                    },
                    error: function(response) {
                        console.log(response);
                        $('#image-input-error').text(response.responseJSON.errors.logo);
                    }
                });
            });

            // change companies
            $('body').on('click', '.editItem', function() {
                var Item_id = $(this).data('id');
                var url = $(this).data('url');
                $('.tombol').html("Save Change");
                $.get(url, function(data) {
                    $('#modelHeading').html("Change Companies");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#Item_id').val(data.id);
                    $('input[name=nama]').val(data.nama);
                    $('input[name=email]').val(data.email);
                    $('input[name=balance]').val(data.balance);
                    $('input[name=website]').val(data.website);
                })
            });

            // delete companies
            $('body').on('click', '.deleteItem', function() {

                var Item_id = $(this).data("id");
                var url = $(this).data("url");
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: "Anda Akan Menghapus data Ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus Segera!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: url,
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Selamat!",
                                        text: response.success
                                    });
                                    $('#ItemForm').trigger("reset");
                                    $('#ajaxModel').modal('hide');
                                    table.draw();
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Mohon Maaf!",
                                        text: response.error
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Terjadi Kesalahan!"
                                });
                            }
                        });
                    }
                })
            });
        });
    </script>
@endsection
