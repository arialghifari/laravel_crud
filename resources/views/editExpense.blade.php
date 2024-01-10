<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Expense</title>
    @vite('resources/css/app.css')
</head>

<body class="p-10">
    <div class="flex justify-center items-center gap-4">
        <p>Hi <strong>{{ auth()->user()->name }}</strong>!</p>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="bg-red-800 text-white rounded py-1 px-2">Logout</button>
        </form>
    </div>

    <div class="mt-10 flex flex-col gap-4 items-center">
        <h2 class="text-center text-2xl mb-2 font-semibold">Edit expense</h2>

        <form action="/update-expense/{{ $expense->id }}" method="POST" class="flex flex-col w-80 gap-2">
            @csrf
            @method('PUT')

            <input type="title" name="title" value="{{ $expense->title }}" required placeholder="Title"
                class="border border-zinc-800 rounded py-1 px-2" />
            @if ($errors->has('title'))
                <span class="text-red-500">*{{ $errors->get('title')[0] }}</span>
            @endif

            <input type="number" name="amount" value="{{ $expense->amount }}" required placeholder="Amount (IDR)"
                class="border border-zinc-800 rounded py-1 px-2" />
            @if ($errors->has('amount'))
                <span class="text-red-500">*{{ $errors->get('amount')[0] }}</span>
            @endif

            <input type="date" name="date" value="{{ $expense->date }}" required
                class="border border-zinc-800 rounded py-1 px-2" />
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

            <textarea name="description" placeholder="Description" class="border border-zinc-800 rounded py-1 px-2" rows="3">{{ $expense->description }}</textarea>
            @if ($errors->has('description'))
                <span class="text-red-500">*{{ $errors->get('description')[0] }}</span>
            @endif

            @if ($errors->has('error'))
                <span class="text-red-500">*{{ $errors->get('error')[0] }}</span>
            @endif

            <button type="submit" class="bg-indigo-600 text-white rounded p-1.5">Update</button>
            <a href="/" class="border border-zinc-800 rounded p-1.5 text-center">Cancel</a>
        </form>
    </div>
</body>

</html>
