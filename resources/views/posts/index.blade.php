<x-app-layout>
    <div class="py-12">
        <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
            @foreach($posts as $post)
            <div class="flex flex-col items-center gap-4 mb-12">
                <!-- Centered Image Section -->
                <div class="w-full flex justify-center">
                    <a href="/profile/{{ $post->user->id }}">
                    <img src="{{ $post->image }}" alt="Post Image" class="w-full h-auto rounded-lg shadow-md mb-0 pb-0">
                    </a>
                </div>

                <!-- Text Section Directly Below Image -->
                <div class="w-full -mt-1">
                    <p>
                        <span class="font-bold">
                            <a href="/profile/{{ $post->user->id }}" class="text-gray-800 hover:text-gray-900">{{ $post->user->username }}</a>:
                        </span> 
                        {{ $post->caption }}
                    </p>
                </div>
            </div>
            @endforeach
            <div class="flex justify-center mt-4">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
