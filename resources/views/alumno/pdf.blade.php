<!DOCTYPE html>
<html>
<head>
    <title>Lista QR Alumnos</title>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .page {
        width: 21cm;
        height: 29.7cm;
        /* esta linea es solo si quieres ver el limite la jhoja A4*/
        /*border: 5px solid black;*/
        display: flex;
        flex-wrap: wrap;
        gap: 2mm; /* Ajusta el valor de gap para reducir la separación entre columnas */
        justify-content: space-evenly;
        align-content: space-around;
    }

    .carnet {
        
        width: 5.65cm;  /*Medida oficial:5,5 Ancho de cada carné */
        height: 8.79cm; /*Medida oficial:8.,5 Ancho de cada carné */
        border: 2px solid black;
        border-radius: 10px;
        background-size: cover;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .personal-data {
        text-align: center;
    }

    .h5 {
        text-align: center;
        color: black;
    }

    .qr-code-container {
        width: 3cm;
        height: 3cm;
        margin-block: 5px;
        text-align: center;
        width: 100%;
        height: 31%;
    }

    .qr-code {
        width: 100%;
        height: 100%;
    }
</style>
<body>
    <div class="page">
        <table style="width: 100%;">
            @foreach ($qr_codes as $key => $qr_code)
                @if ($key % 3 === 0)
                    <tr>
                @endif
                <td>
                    
                    <div class="carnet" style="background-image: url('{{ asset('assets/img/CARNET.jpg') }}');">
                        <div class="h5">
                            <h4>I.E César A. Vallejo Mendoza</h4>
                        </div>
                        <div class="qr-code-container">
                            <img src="data:image/png;base64,{{ base64_encode($qr_code['code']) }}">
                        </div>
                        <div class="personal-data">
                            <p> {{ $qr_code['Nombre'] }}</p>
                            <p> {{ $qr_code['Apellido'] }}</p>
                            <p> {{ $qr_code['GradoSeccion'] }}</p>
                        </div>
                    </div>
                </td>
                @if (($key + 1) % 3 === 0 || $loop->last)
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
</body>
</html>
