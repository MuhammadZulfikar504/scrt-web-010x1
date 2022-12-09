@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        $(function ()
        {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('transactions/detail') }}" + "/" + {{ $transaction->id }},
                columns: 
                [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'collection', name: 'collection'},
                    {data: 'start_date', name: 'start_date'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'status', name: 'status'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });

    </script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="container mt-5">

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Employee</label>
                                <input class="form-control bg-white" name="employee_id" value="{{ $transaction->employee }}" readonly>
                            </div>
    
                            <div class="col-md-6 mb-4">
                                <label class="form-label">User</label>
                                <input class="form-control bg-white" name="user_id" value="{{ $transaction->user }}" readonly>
                            </div>
                        </div>

                        <table class="table table-bordered yajra-datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Collection</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
