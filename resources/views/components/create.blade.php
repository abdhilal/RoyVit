@props([
    'action' => '',
    'text' => 'create',
])
<a href="{{ $action }}" class="btn  btn-outline-success">{{ __($text) }}</a>
