<div class="max-w-6xl mx-auto">
    <div class="flex justify-end m-2 p-2">
        <x-jet-button wire:click="showPostModal">
            Create
        </x-jet-button>
    </div>
    <div class="m-2 p-2">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 dark:bg-gray-600 dark:text-gray-200">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Id</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Title</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                                    Image</th>
                                <th scope="col" class="relative px-6 py-3">Edit</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr></tr>
                            @forelse ($posts as $itemPost)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $itemPost->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $itemPost->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img class="w-8 h-8 rounded-full"
                                            src="{{ Storage::Url($itemPost->image) }}" />
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <div class="flex x-2">
                                            <x-jet-button wire:click="showEditPostModal({{ $itemPost->id }})">Update</x-jet-button>
                                            <x-jet-button wire:click="deletePost({{ $itemPost->id }})">Delete</x-jet-button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-4 ">
                                        Data Kosong
                                    </td>
                                </tr>
                            @endforelse
                            <!-- More items... -->
                        </tbody>
                    </table>
                    <div class="m-2 p-2">Pagination</div>
                </div>
            </div>
        </div>

    </div>
    <div>
        <x-jet-dialog-modal wire:model="showingPostModal">
            @if ($isEditMode)
                <x-slot name="title">
                    Update Post
                </x-slot>
            @else
                <x-slot name="title">
                    Create Post
                </x-slot>
            @endif

            <x-slot name="content">
                <div>
                    <form action="" enctype="multipart/form-data">
                        <div class="sm:col-span-6">
                            <label for="title" class="block text-sm font-medium text-gray-700">Post Title</label>
                            <div class="mt-2">
                                <input type="text" name="title" id="title" wire:model.lazy="title"
                                    class="rounded w-full">
                            </div>
                            @error('title')
                                <span class="text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="sm:col-span-6 pt-4">
                            <label for="image" class="block text-sm font-medium text-gray-700">Post Image</label>
                            @if ($oldImage)
                                Old Image :
                                <img src="{{ Storage::url($oldImage) }}" alt="">
                            @endif

                            @if ($newImage)
                                Preview :
                                <img src="{{ $newImage->temporaryUrl() }}" alt="">
                            @endif
                            <div class="mt-2">
                                <input type="file" name="image" id="image" wire:model="newImage"
                                    class="block w-full">
                            </div>
                            @error('newImage')
                                <span class="text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="sm:col-span-6 pt-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Post Title</label>
                            <div class="mt-2">
                                <textarea name="content" wire:model.lazy="content" id="content" class="rounded w-full" cols="3"></textarea>
                            </div>
                            @error('content')
                                <span class="text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                </div>
            </x-slot>
            <x-slot name="footer">
                @if ($isEditMode)
                    <x-jet-button wire:click="updatePost">Update</x-jet-button>
                @else
                    <x-jet-button wire:click="storePost">Save</x-jet-button>
                @endif
            </x-slot>
        </x-jet-dialog-modal>
    </div>
</div>
