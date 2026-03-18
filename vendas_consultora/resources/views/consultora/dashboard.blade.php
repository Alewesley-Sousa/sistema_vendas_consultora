<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Seja bem-vindo {{ Auth::user()->id }}!</h1>
    <h2>Comissao: <span id="comissao"> Carregando...</span></h2>
    <h2>Meta: <span id="meta">Carregando...</span></h2>
    <p id="erro" style="color: red;"></p>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $.ajax({
            url: '{{ url("api/meta/") }}' + "{{ Auth::user()->id }}",
            method: 'GET',
            success: function(response) {
                $('#erro').text("resposta meta: " + JSON.stringify(response.data));
                $('#meta').text(data.meta);
            },
            error: function(xhr) {
                $('#erro').text('erro ao carregar: ' + xhr.status + ' - ' + xhr.responseText);
            }
        });
    </script>
</body>
</html>
