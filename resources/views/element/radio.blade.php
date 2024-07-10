<label class="particles-checkbox-container">
    <input type="radio" class="particles-checkbox {{ $class }}" name="{{ $class }}" data-id="{{ $id }}" {{ $status ? 'checked' : '' }}>
    <span>{{ $status ? 'Teraktifkan' : 'Aktfikan' }}</span>
</label>
