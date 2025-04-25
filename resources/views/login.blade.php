<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Multi Role</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 min-h-screen flex items-center justify-center">

    <div class="bg-white/80 backdrop-blur-sm shadow-2xl rounded-2xl p-10 w-full max-w-md animate-fade-in">
        <h2 class="text-3xl font-bold text-center text-indigo-700 mb-8">Login</h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" required
                    class="w-full mt-1 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required
                    class="w-full mt-1 px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Login sebagai</label>
                <select name="role" required
                    class="w-full mt-1 px-4 py-2 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="pegawai">Pegawai</option>
                    <option value="atasan">Atasan</option>
                </select>
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                Login
            </button>
        </form>

        @if ($errors->any())
            <div class="mt-5 bg-red-100 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out both;
        }
    </style>
</body>
</html>
