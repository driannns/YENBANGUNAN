@props(['id', 'name', 'value' => ''])

<input id="{{ $id }}" type="hidden" name="{{ $name }}" value="{{ $value }}">
<trix-editor input="{{ $id }}" {{ $attributes }}></trix-editor>
