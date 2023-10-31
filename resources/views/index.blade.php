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
        .active {
            background-color: #4CAF50;
            color: white;
            /* rounded */
            border-radius: 5px;
        }
    </style>
</head>

<body>
    {{-- menu dashboard and total kirim --}}
    <div class="flex gap-5 bg-gray-200 p-4">
        <a class="{{ request()->is('/') ? 'active' : '' }} p-1" href="{{ route('home') }}">Dashboard</a>
        <a class="{{ request()->is('total-kirim') ? 'active' : '' }} p-1" href="{{ route('total-kirim') }}">Total
            Kirim</a>
        {{-- logout if auth --}}
        @if (auth()->check())
            <button class="p-1 ml-auto bg-red-500 rounded-lg text-white" id="logout">Logout</button>
        @endif
    </div>
    {{-- square root calculator --}}
    <div class="flex justify-center items-center h-screen">
        <div class="w-full mx-8">
            <form id="square-form" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="number">
                        Number
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="number" value="{{ auth()->user()->nim }}" disabled name="number" type="number"
                        placeholder="Enter a number">
                </div>
                <div class="flex items-center justify-between">
                    <button id="calculate-btn"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button">
                        Calculate API
                    </button>
                    <button id="calculate-btn-sql"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="button">
                        Calculate PL/SQL
                    </button>
                </div>
            </form>
            {{-- <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="result">
                        Result
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="result" name="result" type="text" value="" readonly>
                </div>
            </div> --}}

            {{-- table show log --}}
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <table class="table-auto w-full" id="table-sqrt">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Number</th>
                            <th class="px-4 py-2">Square Root</th>
                            <th class="px-4 py-2">Execution Time (ms)</th>
                            <th class="px-4 py-2">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td class="border px-4 py-2">{{ $log->number }}</td>
                                <td class="border px-4 py-2">{{ $log->result }}</td>
                                <td class="border px-4 py-2">{{ $log->execution_time }}</td>
                                <td class="border px-4 py-2">{{ $log->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- jQuery cdn --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        {{-- datatable --}}
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.tailwindcss.min.js"></script>
        {{-- datatable tailwind --}}
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.tailwindcss.min.css">

        <script>
            $(document).ready(function() {
                new DataTable('#table-sqrt', {
                    paging: true,
                    searching: true,
                    info: true,
                    order: [
                        [3, "desc"]
                    ]
                });

                $('#square-form').submit(function(e) {
                    e.preventDefault();
                });

                $('#calculate-btn').click(function() {
                    var number = $('#number').val();
                    $.ajax({
                        url: '/api/square/' + number,
                        type: 'GET',
                        success: function(result) {
                            $('#result').val(result.square_root);
                            // reload page
                            location.reload();
                        },
                        error: function(xhr) {
                            alert(xhr.responseJSON.error);
                        }
                    });
                });

                $('#calculate-btn-sql').click(function() {
                    var number = $('#number').val();
                    $.ajax({
                        url: '/api/sql/square/' + number,
                        type: 'GET',
                        success: function(result) {
                            $('#result').val(result.square_root);
                            location.reload();
                        },
                        error: function(xhr) {
                            alert(xhr.responseJSON.error);
                        }
                    });
                });

                $('#logout').click(function() {
                    $.ajax({
                        url: '/api/logout',
                        type: 'POST',
                        success: function(result) {
                            alert(result.message);
                            // redirect to login page
                            window.location.href = '/login';
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
