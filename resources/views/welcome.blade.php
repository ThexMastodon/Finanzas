<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>[SFA] - Fianzas Y Cheques</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
  @vite(['resources/js/app.js'])
</head>

<body class="antialiased">
  @php
    $tableData = [
      ['Edgar Alberto', 'Morales', 'dev.edgarmorales@gmail.com'],
      ['Gonzalo', 'Huerta', 'huerta.gonzalo@gmail.com'],
      ['Humberto', 'Lopez', 'h.lopez@gmail.com'],
      ['Gloria', 'Ruiz', 'g.ruiz@gmail.com']
    ];
    $tableHeaders = ['Nombre', 'Paterno', 'Email'];
  @endphp
  <div id="app" class="row">
<!--    <hello-world></hello-world>
    <modal-component></modal-component>-->
    <generic-data-table :headers="{{ json_encode($tableHeaders) }}" :data="{{ json_encode($tableData) }}"></generic-data-table>
  </div>
</body>

</html>
