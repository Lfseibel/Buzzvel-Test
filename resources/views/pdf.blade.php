<!DOCTYPE html>
<html>
<head>
    <title>pdf</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>Date: {{ $date }}</p>
    <p>Description: {{ $description }}</p>
    <p>Location: {{ $location }}</p>
    @if ($participants)
    <p>Participants: {{$participants}}</p>
    @endif
    
      
  
</body>
</html>