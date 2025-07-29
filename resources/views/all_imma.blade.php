@extends("layouts.main_cni")

@section("content_main")

    <h1 class="text-center">Immatriculations totales</h1>
        <ul style="list-style-type: none;">
            @foreach ($immatriculations as $immat)
                <li class="
                    @if($immat->status == 0) bg-success text-white
                    @elseif($immat->status == 2) bg-danger text-white
                    @elseif($immat->status == 1) bg-warning text-dark
                    @endif
                    p-3 mb-2 rounded"
                >
                    <a href="{{ route('dash_show', $immat->id) }}" class="d-block text-decoration-none text-reset">
                        <p>#{{ $immat->id }}</p>
                        <p>{{ $immat->nom }}</p>
                        <p>
                            Status: {{ $immat->status == 0 ? 'Valide' : ($immat->status == 1 ? 'En attente' : 'Bloqué') }}
                        </p>
                        <p>Date de création: {{ $immat->created_at->diffForHumans() }}</p>
                    </a>
                </li>
            @endforeach
            </ul>
    {{ $immatriculations->links() }}



@endsection
