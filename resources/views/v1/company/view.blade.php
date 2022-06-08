@extends('layouts.theme.master')
@section('title')
    Employee For Companies : {{ $company->nama }}
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 data-url="{{ route('company.show', $company->id) }}" id="link">Companies
                            {{ $company->nama }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin') }}">Companies</a></li>
                            <li class="breadcrumb-item active">{{ $company->nama }}</li>
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
                                        class="fas fa-plus mr-2"></i>Add Emplayee</button>
                                <button class="btn btn-info btn-sm" id="balance"><i class="fas fa-file-pdf mr-2"></i>Export
                                    PDF</button>
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
    {{-- modal balance --}}
    <div class="modal fade" id="balanceModel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelHeading"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ItemForm" name="ItemForm" class="form-horizontal">
                        <input type="hidden" name="Item_id" id="Item_id">
                        <input type="hidden" name="company_id">
                        <div class="mb-2">
                            <label for="balance_saat_ini" class="form-label">Balance Before </label>
                            <input type="number" readonly disabled name="balance_saat_ini" class="form-control" id="balance_saat_ini"
                                placeholder="E.g 1xx" autocomplete="off" required>
                        </div>
                        <div class="mb-2">
                            <label for="balance" class="form-label">Add Balance </label>
                            <input type="number" name="balance" class="form-control" id="balance"
                                placeholder="E.g 1xx" autocomplete="off" required>
                        </div>
                        <button class="btn btn-secondary tombol float-right" id="saveBalance" value="create"></button>
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
                ajax: $('#link').data('url'),
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
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

            $('body').on('click', '.addbalance', function() {
                var Item_id = $(this).data('id');
                var url = $(this).data('url');
                $('.tombol').html("Save Change");
                $.get(url, function(data) {
                    $('#modelHeading').html("Add Balance");
                    $('#saveBalance').val("submit");
                    $('#saveBalance').attr('data-id', data.id);
                    $('#balanceModel').modal('show');
                    $('#Item_id').val(data.id);
                    $('input[name=balance_saat_ini]').val(data.balance);
                    $('input[name=company_id]').val(data.company_id);
                })
            });
            $('#saveBalance').click(function(e) {
                e.preventDefault();
                var url = $(this).data('id');
                $.ajax({
                    data: $('#ItemForm').serialize(),
                    url: '/v1/company/balance/' + url,
                    type: "POST",
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Selamat!",
                                text: response.success
                            });
                            $('#ItemForm').trigger("reset");
                            $('#balanceModel').modal('hide');
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
            });
        });
    </script>
@endsection
