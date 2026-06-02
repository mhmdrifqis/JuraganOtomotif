@props([
    'name',
    'class' => 'w-5 h-5',
    'strokeWidth' => '2'
])

@php
    $componentName = 'lucide-' . $name;
@endphp

<x-dynamic-component :component="$componentName" :class="$class" stroke-width="{{ $strokeWidth }}" {{ $attributes }} />
