<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    @vite('resources/css/app.css')
</head>

<body class="p-10">
    @auth
        <div class="flex justify-center items-center gap-4">
            <p>Hi <strong>{{ auth()->user()->name }}</strong>!</p>
            <form action="/logout" method="POST">
                @csrf
                <button type="submit" class="bg-red-800 text-white rounded py-1 px-2">Logout</button>
            </form>
        </div>

        <div class="mt-10 flex flex-col gap-4 items-center">
            <h2 class="text-2xl font-semibold">New expense</h2>

            <form action="/create-expense" method="POST" class="flex flex-col w-80 gap-2">
                @csrf

                <input type="title" name="title" required placeholder="Title"
                    class="border border-zinc-800 rounded py-1 px-2" />
                @if ($errors->has('title'))
                    <span class="text-red-500">*{{ $errors->get('title')[0] }}</span>
                @endif

                <input type="number" name="amount" required placeholder="Amount (IDR)"
                    class="border border-zinc-800 rounded py-1 px-2" />
                @if ($errors->has('amount'))
                    <span class="text-red-500">*{{ $errors->get('amount')[0] }}</span>
                @endif

                <input type="date" name="date" required class="border border-zinc-800 rounded py-1 px-2" />
                @if ($errors->has('date'))
                    <span class="text-red-500">*{{ $errors->get('date')[0] }}</span>
                @endif

                <select name="category" class="border border-zinc-800 rounded py-1 px-2">
                    <option value="credit">Credit</option>
                    <option value="debit">Debit</option>
                </select>
                @if ($errors->has('category'))
                    <span class="text-red-500">*{{ $errors->get('category')[0] }}</span>
                @endif

                <textarea name="description" placeholder="Description" class="border border-zinc-800 rounded py-1 px-2" rows="3"></textarea>
                @if ($errors->has('description'))
                    <span class="text-red-500">*{{ $errors->get('description')[0] }}</span>
                @endif

                @if ($errors->has('error'))
                    <span class="text-red-500">*{{ $errors->get('error')[0] }}</span>
                @endif

                <button type="submit" class="border-white bg-indigo-600 text-white rounded p-1.5">Create</button>
            </form>
        </div>

        <div class="flex flex-col items-center">
            <div class="w-3/4">
                <h2 class="mt-10 text-center text-2xl mb-2 font-semibold">All Expenses</h2>

                <div class="grid grid-cols-3 gap-6">
                    @foreach ($expenses as $expense)
                        <div
                            class="border border-zinc-800 rounded p-2 {{ $expense->category === 'debit' ? 'bg-green-100' : 'bg-red-100' }}">
                            <p>{{ $expense->title }}</p>
                            <p class="font-bold">IDR {{ number_format($expense->amount, 0, '', '.') }}</p>
                            <p>{{ date('D, d M Y', strtotime($expense->date)) }}</p>
                            <p>{{ $expense->description ?? '-' }}</p>
                            <p>by {{ $expense->user->name }}</p>

                            <div class="flex gap-2 mt-2 justify-end">
                                <a href="/edit-expense/{{ $expense->id }}"
                                    class="text-indigo-800 border border-indigo-800 rounded py-0.5 px-2">Edit</a>
                                <form action="/delete-expense/{{ $expense->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-800 border border-red-800 rounded py-0.5 px-2">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="flex flex-col items-center">
            <h2 class="text-2xl mb-2 font-semibold">Login</h2>

            <form action="/login" method="POST" class="flex flex-col w-80 gap-2">
                @csrf

                <input type="email" name="email" required placeholder="Email"
                    class="border border-zinc-800 rounded py-1 px-2" />
                @if ($errors->has('email'))
                    <span class="text-red-500">*{{ $errors->get('email')[0] }}</span>
                @endif

                <input type="password" name="password" required placeholder="Password"
                    class="border border-zinc-800 rounded py-1 px-2" />
                @if ($errors->has('password'))
                    <span class="text-red-500">*{{ $errors->get('password')[0] }}</span>
                @endif

                @if ($errors->has('error'))
                    <span class="text-red-500">*{{ $errors->get('error')[0] }}</span>
                @endif

                <button type="submit" class="border-white bg-indigo-600 text-white rounded p-1.5">Login</button>
            </form>
        </div>

        <div class="mt-10 flex flex-col items-center">
            <h2 class="text-2xl mb-2 font-semibold">Register</h2>

            <form action="/register" method="POST" class="flex flex-col w-80 gap-2">
                @csrf

                <input type="text" name="registerName" required placeholder="Name"
                    class="border border-zinc-800 rounded py-1 px-2" />
                @if ($errors->has('registerName'))
                    <span class="text-red-500">*{{ $errors->get('registerName')[0] }}</span>
                @endif

                <input type="email" name="registerEmail" required placeholder="Email"
                    class="border border-zinc-800 rounded py-1 px-2" />
                @if ($errors->has('registerEmail'))
                    <span class="text-red-500">*{{ $errors->get('registerEmail')[0] }}</span>
                @endif

                <input type="password" name="registerPassword" required placeholder="Password"
                    class="border border-zinc-800 rounded py-1 px-2" />
                @if ($errors->has('registerPassword'))
                    <span class="text-red-500">*{{ $errors->get('registerPassword')[0] }}</span>
                @endif

                <button type="submit" class="border-white bg-indigo-600 text-white rounded p-1.5">Register</button>
            </form>
        </div>
    @endauth
</body>

</html>
