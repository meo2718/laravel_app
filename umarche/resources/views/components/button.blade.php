<button {{ $attributes->merge(['type' => 'submit', 'class' => 'text-white bg-pink-500 border-0 py-2 px-2 focus:outline-none hover:bg-pink-600 text-lg']) }}>
    {{ $slot }}
</button>