<!DOCTYPE html>
<html>
<head>
    <title>Edify</title>
</head>

<body>

 <h>Hi {{$content['receipent_name']??''}},</p>
 <p> {!! $content['data']??'' !!}</p>
 <h5><b>Regards </b></h5>
 <p>{{$content['sender_name']??'EdifyArtist'}}</p>
</body>

</html>