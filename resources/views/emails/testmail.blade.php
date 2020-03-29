<!DOCTYPE html>
<html>
<head>
    <title>Edify</title>
</head>

<body>

 <h>Hi {{$content['sender_name']??''}},</p>
 <p> {!! $content['data']??'' !!}</p>
 <h5><b>Regards </b></h5>
 <p>Edify</p>
</body>

</html>