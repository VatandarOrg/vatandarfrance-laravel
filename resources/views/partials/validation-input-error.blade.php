@if ($errors->has($name))
    <small class="form-text text-danger"> {{ $errors->first($name) }} </small>
@endif
