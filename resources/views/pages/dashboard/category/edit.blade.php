<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Category &raquo; Edit
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
                <form action="{{ route('dashboard.category.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="w-full">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 mb-8">
                            <label for="grid-last-name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-3">
                                Name
                            </label>
                            <input value="{{ old('name') ?? $category->name }}" name="name" id="grid-last-name" placeholder="Category Name" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        </div>
                        <div class="w-full px-3">
                            <label for="grid-last-name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-3">
                                Category Parent <span class="text-xs text-red-500">(Leave blank if this category is the parent category)</span>
                            </label>
                            <select value="{{ old('name') }}" name="parent_id" id="grid-last-name" placeholder="Category Name" type="text" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value=""></option>
                                @foreach ($categories as $cat)
                                    @if ($category->parent_id == $cat->id)
                                        <option value="{{ $cat->id }}" selected>{{ $cat->name }}</option>
                                    @else
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full px-3 text-right">
                            <button type="submit" class="shadow-lg bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Update Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>