<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration Email</title>
</head>
<body>
    <p>Dear {{$data['name']}},</p>
    <p>You have successfully registered on OES by Admin. Please find your Creditional below.</p>
    <table>
        <tbody>
            <tr>
                <th>Name:</th>
                <th>{{$data['name']}}</th>
            </tr>
            <tr>
                <th>Email ID:</th>
                <th>{{$data['email']}}</th>
            </tr>
            <tr>
                <th>Password:</th>
                <th>{{$data['password']}}</th>
            </tr>
        </tbody>
    </table>

    <a href="{{$data['url']}}">Click here to login</a>
</body>
</html>