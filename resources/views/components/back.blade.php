@props([
    'action' => '',
    'text' => 'back',
])
<a href="{{ $action }}" class="btn  btn-outline-secondary">{{ __($text) }}</a>
