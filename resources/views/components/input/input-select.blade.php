@props(['data'])
@props(['name'])
<select class="form-select" {{ $attributes }}>
    <option selected>- {{ __('label.select') }} - </option>
    @foreach($data as $r)
        <option value="{{ $r['value'] }}">{{ __($r['text']) }}</option>
    @endforeach
</select>
@error($name)
    <span class="text-danger">
        <em>{{ __($message) }}</em> 
    </span>
@enderror