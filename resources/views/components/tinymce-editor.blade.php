<textarea id="myeditor">
    @if(isset($slot))
        {{ $slot }}
    @else
    Hello, World!
    @endif
</textarea>