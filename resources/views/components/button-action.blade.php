<button 
    type="{{ $type ?? 'submit' }}"
    class="btn btn-{{ $color ?? 'primary' }} btn-sm"
    title="{{ $title }}"
    {{ $attributes }}
>
    <i class="bi {{ $icon }}"></i>
</button>