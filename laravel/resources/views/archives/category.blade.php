<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="vewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $category }}の一覧</title>
</head>

<body>
    <p> {{ $category }} の一覧</p>

    @if ($category == 'news')
    <p>本日のnewsをお伝えします</p>
    <p>妻、プログラマ脳だったの巻</p>
    <p>愛犬、普段より寂しがるの巻</p>
    @endif

    
    
</body>

</html>