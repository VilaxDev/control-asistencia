@extends('layouts.app')
@section('content')
    <style>
        #map {
            height: 300px;
        }
    </style>
    <div class="container">
        <h1 class="text-center mb-4">Ubicación Empresarial</h1>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Determinar si ya existe una ubicación --}}
        @php
            $isEdit = isset($ubicaciones) && $ubicaciones->count() > 0;
            $ubicacion = $isEdit ? $ubicaciones->first() : null; // Primera ubicación o nulo
        @endphp

        <form
            action="{{ $isEdit ? route('ubicacionEmpresarial.update', $ubicacion->id) : route('ubicacionEmpresarial.create') }}"
            method="POST">
            @csrf
            @if ($isEdit)
                @method('PUT') {{-- Método PUT para actualizar --}}
            @endif

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion"
                        value="{{ $isEdit ? $ubicacion->direccion : '' }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="latitud" class="form-label">Latitud</label>
                    <input type="text" class="form-control" id="latitud" name="latitud"
                        value="{{ $isEdit ? $ubicacion->latitud : '' }}" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="longitud" class="form-label">Longitud</label>
                    <input type="text" class="form-control" id="longitud" name="longitud"
                        value="{{ $isEdit ? $ubicacion->longitud : '' }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="rango" class="form-label">Rango</label>
                    <div class="d-flex align-items-center">
                        <span id="rangoValue">{{ $isEdit ? $ubicacion->rango : '0' }}</span>
                        <input type="range" class="form-range mx-2" id="rango" min="0" max="200"
                            value="{{ $isEdit ? $ubicacion->rango : 0 }}" name="rango">
                        <span>200</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <div id="map"></div>
                </div>
            </div>

            {{-- Botón dinámico según si es creación o actualización --}}
            <button type="submit" class="btn btn-primary">
                {{ $isEdit ? 'Actualizar dirección' : 'Guardar dirección' }}
            </button>
        </form>
    </div>

    <script>
        // Coordenadas iniciales según si hay datos guardados o no
        var lat = {{ $isEdit ? $ubicacion->latitud : '-12.0464' }};
        var lng = {{ $isEdit ? $ubicacion->longitud : '-77.0428' }};
        var rangoInicial = {{ $isEdit ? $ubicacion->rango : 0 }};

        // Inicializar el mapa centrado en la ubicación guardada o en Lima
        var map = L.map('map').setView([lat, lng], 13);

        // Cargar la capa de tiles
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Crear el ícono personalizado para el marcador
        var iconoUbicacion = L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/128/7945/7945007.png',
            iconSize: [40, 40],
            iconAnchor: [19, 35],
            popupAnchor: [10, -50],
        });

        // Agregar un marcador con el ícono de ubicación
        var marcador = L.marker([lat, lng], {
            icon: iconoUbicacion
        }).addTo(map);

        // Agregar un círculo alrededor del marcador
        var circulo = L.circle([lat, lng], {
            color: '#4682B4',
            fillColor: '#4682B4',
            fillOpacity: 0.3,
            radius: rangoInicial
        }).addTo(map);

        // Actualizar el radio del círculo cuando el input de rango cambie
        document.getElementById('rango').addEventListener('input', function() {
            var nuevoRango = this.value;
            circulo.setRadius(nuevoRango);
        });

        // Función para obtener la dirección desde las coordenadas
        function obtenerDireccion(lat, lng) {
            const API_KEY = '6531d5983aa94e9083a856bbce369d29';
            const url = `https://api.opencagedata.com/geocode/v1/json?q=${lat}+${lng}&key=${API_KEY}&language=es&pretty=1`;
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.results && data.results[0]) {
                        document.getElementById('direccion').value = data.results[0].formatted;
                    } else {
                        console.error('No se pudo obtener la dirección.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Actualizar la posición del marcador y del círculo cuando el mapa se mueva
        map.on('moveend', function() {
            var centro = map.getCenter(); // Obtener el centro actual del mapa
            marcador.setLatLng(centro); // Mover el marcador al nuevo centro
            circulo.setLatLng(centro); // Mover el círculo al nuevo centro
            document.getElementById('latitud').value = centro.lat.toFixed(6);
            document.getElementById('longitud').value = centro.lng.toFixed(6);
            obtenerDireccion(centro.lat, centro.lng); // Actualizar la dirección basada en la nueva posición
        });
    </script>
@endsection
