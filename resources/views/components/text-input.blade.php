@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-lg border-slate-300 text-sm shadow-sm focus:border-sky-500 focus:ring-sky-500']) }}>