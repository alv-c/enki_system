@props(['name', 'label'])

<div class="mt-4">
    <label for="{{ $name }}" class="inline-flex items-center">
        <input type="checkbox" id="{{ $name }}" name="{{ $name }}" value="admin"
            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
        <span class="ml-2 text-sm text-gray-600">{{ $label }}</span>
    </label>
</div>
