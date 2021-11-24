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
                <th>Id</th>
                <th>Codigo </th>
                <th>Nombre</th>
                <th>País</th>
                <th>Total de Vuelos</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $destination)
            <tr>
                <td>{{$destination['airport_arrival_id']}}</td>
                <td>{{$destination['airport_arrival']['iata_code']}}</td>
                <td>{{$destination['airport_arrival']['name']}}</td>
                <td>{{$destination['airport_arrival']['country']['name']}}</td>
                <td>{{$destination['count']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
