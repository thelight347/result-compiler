<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Result Compiler</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-indigo-50 to-purple-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
        <div class="px-8 py-6 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-center">
            <h4 class="text-2xl font-bold"><i class="fas fa-graduation-cap mr-2"></i>Trinity Care</h4>
            <p class="text-indigo-200 text-sm">Login to continue</p>
        </div>
        <div class="px-8 py-6">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-3 mb-4 rounded text-red-700">{{ $errors->first() }}</div>
                @endif
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('password') border-red-500 @enderror" name="password" required>
                    @error('password') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="flex items-center justify-between mb-4">
                    <label class="flex items-center text-sm text-gray-600">
                        <input type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="ml-2">Remember Me</span>
                    </label>
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md shadow">Login</button>
            </form>

            <div class="mt-6 p-4 bg-gray-50 rounded-md text-sm text-gray-600 border border-gray-200">
                <strong>Demo Accounts:</strong><br>
                <i class="fas fa-user-tie mr-1"></i> Headmaster: headmaster@school.com / password123<br>
                <i class="fas fa-chalkboard-teacher mr-1"></i> Teacher: teacher@school.com / password123
            </div>
        </div>
    </div>
</body>
</html>