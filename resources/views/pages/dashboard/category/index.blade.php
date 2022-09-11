<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category') }}
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            var dataTable = $('#crurTable').DataTable({
                ajax: {
                    url: "{!! url()->current() !!}",
                },
                columns: [
                    {data: 'id', width: '5%'},
                    {data: 'name'},
                    {data: 'parent'},
                    {
                        data: 'action',
                        orderable: 'false',
                        searchable: 'false',
                        width: '25%',
                    }
                ]
            })
            console.log(dataTable);
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('dashboard.category.create') }}" class="px-4 py-2 font-bold text-white bg-green-500 rounded shadow-lg hover:bg-green-700">
                    + Create Category
                </a>
                <a href="{{ route('dashboard.category.export') }}" class="px-4 ml-4 py-2 font-bold text-white bg-green-500 rounded shadow-lg hover:bg-green-700">
                    Export Category
                </a>
                <label for="my-modal-3" class="px-4 ml-4 py-2 font-bold text-white bg-green-500 rounded shadow-lg hover:bg-green-700">Open Modal</label>
                <input type="checkbox" id="my-modal-3" class="modal-toggle" />
                <div class="modal">
                <div class="modal-box relative">
                    <label for="my-modal-3" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                    <form action="{{ route('dashboard.category.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="file_input">Upload file</label>
                        <input class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file" name="file" type="file">
                        <button class="btn btn-primary mt-6" type="submit">Import</button>
                    </form>
                </div>
                </div>
            </div>
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crurTable" class="w-full table-auto text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Parent Category</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
