<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Square Root</title>
    {{-- tailwind css cdn --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.9.6/tailwind.min.css">
    <style>
        .active{
            background-color: #4CAF50;
            color: white;
            /* rounded */
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container mx-auto mt-5">
        <div class="flex justify-center">
            <div class="w-full max-w-md">
                <form id="login-form" class="bg-white shadow-lg rounded px-12 pt-6 pb-8 mb-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="nim">
                            NIM
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nim" type="text" placeholder="NIM">
                    </div>
                    <div class="flex items-center justify-between">
                        <button id="login-btn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- jQuery cdn --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#login-btn').click(function() {
                var nim = $('#nim').val();
                $.ajax({
                    url: '/api/register',
                    type: 'POST',
                    data: {
                        nim: nim,
                        password: nim
                    },
                    success: function(result) {
                        alert(result.message);
                        // redirect to home page
                        window.location.href = '/';
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>
</body>

</html>
