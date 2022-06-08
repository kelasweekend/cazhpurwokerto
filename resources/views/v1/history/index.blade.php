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
                                        class="fas fa-file-pdf mr-2"></i>PDF Report</button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-hover datatable">
                                    <thead>
                                        <tr>
                                            <th>Name Company</th>
                                            <th>Name Employee</th>
                                            <th>Balance</th>
                                            <th>Company Start Balance</th>
                                            <th>Company Last Balance</th>
                                            <th>Employee Start Balance</th>
                                            <th>Employee Last Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name Company</th>
                                            <th>Name Employee</th>
                                            <th>Balance</th>
                                            <th>Company Start Balance</th>
                                            <th>Company Last Balance</th>
                                            <th>Employee Start Balance</th>
                                            <th>Employee Last Balance</th>
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
                ajax: "{{ route('history') }}",
                pageLength: 5,
                lengthMenu: [5, 10, 20, 50, 100, 200, 500],
                responsive: true,
                lengthChange: true,
                autoWidth: true,
                columns: [{
                        data: 'nama_company',
                        name: 'nama_company'
                    },
                    {
                        data: 'nama_employee',
                        name: 'nama_employee'
                    },
                    {
                        data: 'balance',
                        name: 'balance'
                    },
                    {
                        data: 'company_last_balance',
                        name: 'company_last_balance'
                    },
                    {
                        data: 'company_start_balance',
                        name: 'company_start_balance'
                    },
                    {
                        data: 'employee_last_balance',
                        name: 'employee_last_balance'
                    },
                    {
                        data: 'employee_start_balance',
                        name: 'employee_start_balance',
                        orderable: true,
                        searchable: true
                    },
                ]
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
