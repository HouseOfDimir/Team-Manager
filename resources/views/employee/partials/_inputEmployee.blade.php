<div class="col-md-6 col-md-offset-1 a-input-group">
    <input class="a-input {{ $input->formHandlerVerify }}" placeholder="{{ $input->placeholder }}" name="{{ $data = $input->name }}"
           value="@if(isset($employee)){{ $employee->$data }}@else{{ old($input->name) }}@endif"
           data-min-length="{{ $input->minLength }}" data-max-length="{{ $input->maxLength }}" maxlength="{{ $input->maxLength }}"/>
    <label>{!! $input->icon . ' ' . $input->libelle !!}</label>
</div>
