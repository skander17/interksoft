<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
</head>
<style>
    table {
        border-collapse: collapse;
        max-width: 100%;
        min-width: 100%;
        margin-top: 10px;
    }

    th, td {
        text-align: center;
        padding: 3px;
        font-size:12px ;
    }

    tr:nth-child(even){background-color: #f2f2f2}

    th {
        background-color: darkred;
        color: white;
    }
    h1{
        font-family: apple-system;
        font-size: 2em;
    }
</style>
<body>
<div>
    <div style="text-align: center;">
        <h2>{{$title}}</h2>
    </div>

</div>
<div>
    <h5>Fecha de emision: {{$date}}</h5>
    <h5>Usuario: {{$username}}</h5>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Cliente</th>
                <th>Aeropuerto Origen</th>
                <th>Fecha-Hora Despegue</th>
                <th>Aeropuerto Destino</th>
                <th>Fecha-Hora Aterrizaje</th>
                <th>Estado</th>
                <th>Usuario Registrador</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $ticket)
            <tr data-id = "{{$ticket->id}}">
                <td> {{ $ticket->code }} </td>

                <td> {{ $ticket->client->full_name }} </td>

                <td> {{ $ticket->airport_origin->name }} </td>

                <td> {{ $ticket->date_start}} </td>

                <td> {{ $ticket->airport_arrival->name}} </td>

                <td> {{ $ticket->date_arrival}} </td>

                <td> {{ $ticket->operation->state->name }} </td>

                <td> {{ $ticket->user->name }} </td>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
