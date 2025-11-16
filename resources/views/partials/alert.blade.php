    @if(session('success'))
        <div id="alert-message" class="fixed top-24 right-5 z-[100] bg-green-500 text-white py-3 px-5 rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
    @endif