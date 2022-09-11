<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Variant') }}
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
                    {data: 'price'},
                    {data: 'product_id'},
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
                <a href="{{ route('dashboard.variant.create', $id) }}" class="px-4 py-2 font-bold text-white bg-green-500 rounded shadow-lg hover:bg-green-700">
                    + Create Variant
                </a>
            </div>
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crurTable" class="w-full table-auto text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Harga Variant</th>
                                <th>Nama Produk</th>
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
