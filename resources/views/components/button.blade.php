<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-senbold text-xs text-white uppercase tracking-widest focus:outline-none hover:bg-opacity-75 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
