<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex p-6 text-gray-900 dark:text-gray-100 sm:flex-row">
            <div class="flex-shrink-0 p-3 pt-0 sm:pl-20">
                <img src="{{ $user->profile->profileImage() }}" alt="avatar" class="rounded-full shadow-lg h-[8rem] w-[8rem] sm:h-[12rem] sm:w-[12rem] object-fill">
            </div>
            <div class="sm:ml-10 ml-3 text-sm sm:text-base w-[20rem] sm:w-full">
                <div class="flex justify-between items-baseline">
                    <div class="flex items-center pb-1">
                <h1 class="text-md sm:text-lg font-semibold">{{ $user->name }}</h1>
                @if(Auth::check() && Auth::id() !== $user->id || !Auth::check())
                <div id="app">
                    <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>
                </div>
                @endif
                </div>
                @if(Auth::check() && Auth::id() === $user->id)
                <a href="/p/create" class="hover:underline text-blue-400">Add Post</a>
                @endif
                </div>
                <div class="mt-2 flex space-x-4">
                    <div><strong>{{ $postCount }}</strong> posts</div>
                    <div><strong>{{ $followersCount }}</strong> followers</div>
                    <div><strong>{{ $followingCount }}</strong> following</div>
                </div>
                <div class="pt-5 font-black">{{ $user->profile->title ?? null}}</div>
                <div class="w-[35rem] pt-1">{{ $user->profile->description ?? null }}</div>
                <div class="pt-1 font-medium"><a href="#" class="hover:underline">{{ $user->profile->url ?? null }}</a></div>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 pl-8 pr-8 pt-5">
            @foreach($user->posts as $post)
            <div class="pb-4">
                <a href="/p/{{ $post->id }}">
                <img src="{{ $post->image }}" alt="post" class="w-full h-auto">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
