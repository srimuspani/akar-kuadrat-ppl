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
    <div class="flex justify-between px-5 gap-5 mt-10">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full md:w-1/3">
            <h3 class="text-lg font-bold mb-4">Total Data</h3>
            <p class="text-4xl font-bold">{{ $totalData }}</p>
        </div>
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full md:w-1/3">
            <h3 class="text-lg font-bold mb-4">Fastest (ms)</h3>
            <p class="text-4xl font-bold">{{ $fastest }}</p>
        </div>
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full md:w-1/3">
            <h3 class="text-lg font-bold mb-4">Slowest (ms)</h3>
            <p class="text-4xl font-bold">{{ $slowest }}</p>
        </div>
    </div>
    <div class="flex justify-center items-center h-screen">
        <div class="w-full mx-8">
            {{-- table show log --}}
            <div class="bg-white shadow-md rounded px-8 pb-8 mb-4">
                <table class="table-auto w-full" id="table-sqrt">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Number</th>
                            <th class="px-4 py-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td class="border px-4 py-2">{{ $log->number }}</td>
                                <td class="border px-4 py-2">{{ $log->total }}</td>
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
                // logout
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
                new DataTable('#table-sqrt', {
                    paging: true,
                    searching: true,
                    info: true,
                    order: [
                        [1, "desc"]
                    ]
                });
            });
        </script>
</body>

</html>
