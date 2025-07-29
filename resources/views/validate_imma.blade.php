@extends("layouts.main_cni")

@section("content_main")

    <h1 class="text-center">Immatriculations Validées</h1>
        <ul style="list-style-type: none;">
            @foreach ($immatriculations as $immat)
                <li class="bg-success text-white p-3 mb-2 rounded">
                    <a href="{{ route('dash_show', $immat->id) }}" class="d-block text-decoration-none text-reset">
                        <p>#{{ $immat->id }}</p>
                        <p>{{ $immat->nom }}</p>
                        <p>
                            Status: Valide
                        </p>
                        <p>Date de création: {{ $immat->created_at->diffForHumans() }}</p>
                    </a>
                </li>
            @endforeach
            </ul>
    {{ $immatriculations->links() }}



@endsection
