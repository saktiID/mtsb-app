@if(Auth::user()->id == $id)
<h5>😘</h5>
@else
<div class="text-center">
    <div class="checkbox-wrapper-31">
        <input type="checkbox" class="check_item" data-id="{{ $id }}" data-nama="{{ $nama }}" />
        <svg viewBox="0 0 35.6 35.6">
            <circle class="background" cx="17.8" cy="17.8" r="17.8"></circle>
            <circle class="stroke" cx="17.8" cy="17.8" r="14.37"></circle>
            <polyline class="check" points="11.78 18.12 15.55 22.23 25.17 12.87"></polyline>
        </svg>
    </div>
</div>
@endif
