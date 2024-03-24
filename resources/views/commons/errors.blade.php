@if ($errors->any())
    <ul class="alert">
        @foreach ($errors->all() as $error)
            <li class="text-red-500">{{ $error }}</li>
        @endforeach
    </ul>
@endif