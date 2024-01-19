@include('layout.header')

{{-- contenedor de contenido --}}
<main>
    <div class="container-fluid px-4">
        
        
        @yield('content')


    </div>
</main>

@include('layout.footer')
