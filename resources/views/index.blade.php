<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ URL::asset('assets/style.css') }}" />
    <title>Book List</title>
</head>

<body>
    <div class="header">
        <h1>Book Lists</h1>
    </div>
    <section id="overlay"></section>
    <section>
        <ul id="myBookList">
            <!-- Book List Will Appear Here -->
        </ul>
    </section>

    <!-- AXIOS SCRIPT -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <!-- JS FUNCTIONALITIES -->
    <script src="{{ URL::asset('assets/script.js') }}"></script>

</body>

</html>