<!DOCTYPE html>
<html>
<head>
    <title>Notificação de Visita</title>
</head>
<body>
    <p>Olá, <strong>{{ $visit->client->name }}</strong> e <strong>{{ $visit->broker->name }}</strong></p>
    <p>Uma visita foi agendada para o imóvel: <strong>{{ $visit->propertie->title }}</strong> na seguinte data e hora: {{ $visit->date }}</p>
    <p>Tipo de visita: {{ $visit->type }}</p>
    <p>Obrigado!</p>
</body>
</html>
