@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Detail Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-8 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form class="row g-3" action="{{ route('transactions.update') }}" method="POST">
                        @csrf

                        <div class="col-md-6">
                            <label for="transaction_id" class="form-label">Transaction Id</label>
                            <input type="text" class="form-control border-gray-300 rounded bg-white" name="transaction_id" id="transaction_id" value="{{ $data->transaction_id }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="detail_transaction_id" class="form-label">Detail Transaction Id</label>
                            <input type="text" class="form-control border-gray-300 rounded bg-white" name="detail_transaction_id" id="detail_transaction_id" value="{{ $data->detail_transaction_id }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="collection" class="form-label">Collection</label>
                            <input class="form-control bg-white" id="collection" value="{{ $data->collection }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>                            
                            <div class="col-sm-12">
                                <select class="form-control rounded" name="status">
                                    <option value="1" {{ old($data->status) == 1 ? 'selected' : '' }}>Pinjam</option>
                                    <option value="2" {{ old($data->status) == 2 ? 'selected' : '' }}>Kembali</option>
                                    <option value="3" {{ old($data->status) == 3 ? 'selected' : '' }}>Hilang</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mt-5">
                            <button type="submit" class="text-white py-2 px-3 bg-blue-500 rounded hover:bg-blue-600">Save</button>
                        </div>

                        <div class="col-6 mt-5">
                            <a href="{{ URL::previous() }}" class="text-white py-2 px-3 bg-gray-500 rounded hover:bg-gray-600">Back</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
