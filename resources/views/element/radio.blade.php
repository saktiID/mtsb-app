<label class="particles-checkbox-container">
    <input type="radio" class="particles-checkbox {{ $class }}" name="{{ $class }}" data-id="{{ $id }}" {{ $status ? 'checked' : '' }}>
    @if($status)
    <span><i class="bi bi-rocket-takeoff"></i></span>
    @else
    <span><i class="bi bi-arrow-right-circle"></i></span>
    @endif
</label>
