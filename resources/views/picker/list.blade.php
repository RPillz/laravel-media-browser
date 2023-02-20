<div class="divider-1 divider-gray-100 space-y-2">
    @forelse($mediaAttachments as $attachment)

    @if(!is_array($attachment))
        <div class="flex items-center justify-between gap-x-4">

            <span class="mx-auto w-8 h-8 fiv-sqo fiv-icon-{{ \Symfony\Component\Mime\MimeTypes::getDefault()->getExtensions($attachment->media->mime_type)[0] ?: 'blank' }}"></span>

            <div class="grow">

                @if($attachment->media)
                    <span class="font-medium">{{ $attachment->media->name }}</span>
                @else
                    <span class="font-medium text-red-500 italic">{{ ucfirst($type) ?: 'Media' }} Missing</span>
                @endif

            </div>
            <x-button red flat label="Remove" wire:click="removeAttachment('{{ $attachment->id }}')" />
        </div>
    @endif

    @empty

        <div class="flex items-center w-full gap-4">
            <x-icon name="paper-clip" class="w-8 h-8 text-gray-400" />
            <x-text.faded class="">No {{ ucfirst($type) ?: 'Media' }} Attached</x-text.faded>
        </div>

    @endforelse
</div>
