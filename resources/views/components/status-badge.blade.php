@props(['status'])

{{-- Badge status laptop. Use with <x-status-badge :status="$laptop->status" /> --}}
<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ' . $status->badgeClasses()]) }}>
    {{ $status->value }}
</span>
