<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel Rus Chat Users</title>
    <style>
        body {
            font-family: Arial, Helvetica, Sans-serif;
            font-size: 12px;
        }
        .user {
            display: block;
            float: left;
            height: 100px;
            margin: 2px;
            position: relative;
            width: 100px;
        }
        .user-info {
            background-color: rgba(188, 47, 47, 0.76);
            color: #fff;
            display: none;
            font-weight: bold;
            height: 100px;
            left: 0;
            position: absolute;
            text-align: center;
            top: 0;
            width: 100px;
        }
        .user:hover .user-info {
            display: table;
        }
        .user-info span {
            display: table-cell;
            font-size: 11px;
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
@foreach ($users as $user)
<div class="user">
    <img src="{{ $user->avatarUrlMedium }}" alt="{{ $user->displayName }}" width="100" height="100"/>
    <span class="user-info"><span>{{ $user->displayName }}</span></span>
</div>
@endforeach
</body>
</html>
