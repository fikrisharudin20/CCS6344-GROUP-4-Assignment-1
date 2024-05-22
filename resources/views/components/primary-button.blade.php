<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex justify-center items-center px-4 py-2 bg-gradient-to-r from-purple-300 to-purple-500 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:from-purple-400 hover:to-purple-600 focus:from-purple-400 focus:to-purple-600 active:from-purple-500 active:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
