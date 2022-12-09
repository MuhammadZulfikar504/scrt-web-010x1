@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Failed !</strong> You should check in on some of those fields below:
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</button>
                    </div>
                @endif

                <div class="container my-5">
                    <form action="{{ route('transactions.store') }}" method="post">
                        @csrf

                        <div class="row mb-4">
                            <label for="employee_id" class="col-sm-2 col-form-label">Employee</label>                            
                            <div class="col-sm-10">
                                <select class="form-select-md rounded" name="employee_id">
                                    <option value="{{ Auth::user()->id }}">{{ Auth::user()->fullname }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="user_id" class="col-sm-2 col-form-label">User</label>                            
                            <div class="col-sm-10">
                                <select class="form-select-md rounded" name="user_id">
                                    <option selected>Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == old('user_id') ? 'selected' : '' }}>{{ $user->fullname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="collection_0" class="col-sm-2 col-form-label">Collection 1</label>                            
                            <div class="col-sm-10">
                                <select class="form-select-md rounded" name="collection_0">
                                    <option selected>Select User</option>
                                    @foreach ($collections as $collection)
                                        <option value="{{ $collection->id }}" {{ $collection->id == old('collection_0') ? 'selected' : '' }}>{{ $collection->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="collection_1" class="col-sm-2 col-form-label">Collection 2</label>                            
                            <div class="col-sm-10">
                                <select class="form-select-md rounded" name="collection_1">
                                    <option selected>Select User</option>
                                    @foreach ($collections as $collection)
                                        <option value="{{ $collection->id }}" {{ $collection->id == old('collection_1') ? 'selected' : '' }}>{{ $collection->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="collection_2" class="col-sm-2 col-form-label">Collection 3</label>                            
                            <div class="col-sm-10">
                                <select class="form-select-md rounded" name="collection_2">
                                    <option selected>Select User</option>
                                    @foreach ($collections as $collection)
                                        <option value="{{ $collection->id }}" {{ $collection->id == old('collection_2') ? 'selected' : '' }}>{{ $collection->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <button type="submit" class="text-white py-2 px-3 bg-blue-500 rounded hover:bg-blue-600">Submit</button>
                                <a href="{{ route('transactions.index') }}" class="text-white py-2 px-3 bg-gray-500 rounded hover:bg-gray-600">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
