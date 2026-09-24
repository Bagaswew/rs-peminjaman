<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-lg border border-transparent bg-sky-700 px-4 py-2.5 text-xs font-semibold uppercase tracking-wider text-white transition hover:bg-sky-800 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>