<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Vegetable &raquo; {{$item->name}} &raquo; Edit
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div>
                @if ($errors->any())
                <div class="mb-5" role="alert">
                    <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                        There is Something Wrong
                    </div>
                    <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
                        <p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </p>
                    </div>
                </div>
                @endif
                <form action="{{route('vegetables.update', $item->id)}}" method="POST" enctype="multipart/form-data" class="w-full">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full px-3">
                            <label for="grid-last-name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Name
                            </label>
                            <input type="text" name="name" value="{{old('name') ?? $item->name}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" placeholder="Name">
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full px-3">
                            <label for="grid-last-name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Vegetable Picture
                            </label>
                            <input type="file" name="picturePath" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" placeholder="Vegetable Picture">
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full px-3">
                            <label for="grid-last-name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Description
                            </label>
                            <input type="text" name="description" value="{{old('description') ?? $item->description}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" placeholder="Description">
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full px-3">
                            <label for="grid-last-name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Minimum Purchase
                            </label>
                            <input type="text" name="minimum_purchase" value="{{old('minimum_purchase') ?? $item->minimum_purchase}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" placeholder="Minimum Purchase">
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full px-3">
                            <label for="grid-last-name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Purchase In
                            </label>
                            <select name="purchase_in" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name">
                                <option value="{{$item->purchase_in}}">{{$item->purchase_in}}</option>
                                <option value="kg">kg</option>
                                <option value="bunch(es)">bunch(es)</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full px-3">
                            <label for="grid-last-name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Price
                            </label>
                            <input type="number" name="price" value="{{old('price') ?? $item->price}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" placeholder="Price">
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full px-3">
                            <label for="grid-last-name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Rate
                            </label>
                            <input type="number" name="rate" value="{{old('rate') ?? $item->rate}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" step="0.01" max="5" placeholder="Rate">
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full px-3">
                            <label for="grid-last-name" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                                Types
                            </label>
                            <input type="text" name="types" value="{{old('types') ?? $item->types}}" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" placeholder="Types">
                            <p class="text-gray-600 text-xs italic">Divided by Comma, Example : recommended,popular,new_vegetable</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full px-3 text-right">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
