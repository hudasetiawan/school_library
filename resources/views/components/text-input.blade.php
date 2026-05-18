@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-input border-border text-foreground focus:border-ring focus:ring-ring rounded-md shadow-sm']) }}>
