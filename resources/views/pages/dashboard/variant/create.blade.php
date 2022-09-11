<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Category &raquo; Create
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                @if($errors->any())
                    <div class="mb-5" role="alert">
                        <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                            There's something wrong!
                        </div>
                        <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                            <p>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </p>
                        </div>
                    </div>
                @endif
                <form action="{{ route('dashboard.variant.store', $id) }}" method="POST" enctype="multipart/form-data" class="w-full">
                    @csrf
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-8">
                            <label for="grid-last-name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-3">
                                Name
                            </label>
                            <input value="{{ old('name') }}" name="name" id="grid-last-name" placeholder="Category Name" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        </div>
                        <div class="w-full px-3 mb-8">
                            <label for="grid-last-price" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-3">
                                Price
                            </label>
                            <input value="{{ old('price') }}" name="price" id="grid-last-price" placeholder="Category Name" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        </div>
                        {{-- <div class="w-full px-3">
                            <label for="grid-last-product" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-3">
                                Product <span class="text-xs text-red-500">(Product that will be added a variant)</span>
                            </label>
                            <select value="{{ old('name') }}" name="product_id" id="grid-last-product" placeholder="Category Name" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value=""></option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <input type="hidden" name="product_id" value="{{ $id }}">
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 text-right">
                            <button type="submit" class="shadow-lg bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Save Variant
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>