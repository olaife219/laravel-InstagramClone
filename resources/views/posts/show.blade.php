<x-app-layout>

<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="col-span-1">
                <img src="{{ $post->image }}" alt="" class="w-full h-auto">
            </div>
            <div class="col-4">
                <div>
                    <div class="flex items-center pb-2">
                        <div class="pr-3">
                            <img src="{{ $post->user->profile->profileImage() }}" alt="" class="rounded-full h-[4rem] w-[4rem]">
                        </div>
                        <div>
                            <div class="font-bold"><a href="/profile/{{ $post->user->id }}" class="pr-3">{{ $post->user->username }}</a>
                            <a href="#" class="text-blue-400">Follow</a>
                        </div>
                        </div>
                    </div>

                    <hr class="pb-2">
                    <p><span class="font-bold"><a href="/profile/{{ $post->user->id }}">{{ $post->user->username }}</a>:</span> {{ $post->caption }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>