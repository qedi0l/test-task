<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .user-list {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }
        .user-card {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .avatar {
            width: 60px;
            height: 60px;
            margin-right: 15px;
            border-radius: 50%;
            object-fit: cover;
        }
        .user-info {
            flex-grow: 1;
        }
        .nickname {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .created-at {
            color: #666;
            font-size: 14px;
        }
        .create-form {
            display: flex;
            margin-top: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            flex-direction: column;
            align-items: flex-start;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<h1>Registered Users</h1>

<div class="user-list">
    @if(isset($users) && count($users) > 0)
        @foreach($users as $user)
            <div class="user-card">
                <img src="data:image/jpeg;base64,{{ $user['avatar'] }}" alt="{{ $user['nickname'] }}" class="avatar">
                <div class="user-info">
                    <div class="nickname">{{ $user['nickname'] }}</div>
                    <div class="created-at">Registered: {{ $user['created_at'] }}</div>
                </div>
            </div>
        @endforeach
    @else
        <p>No users found.</p>
    @endif
</div>
<div class="create-form">
    <h2>Create New User</h2>
    <form action="{{ route('user.register') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nickname">Nickname:</label>
            <input type="text" id="nickname" name="nickname" required>
        </div>
        <div class="form-group">
            <label for="avatar">Avatar:</label>
            <input type="file" id="avatar" name="avatar" accept="image/*" required>
        </div>
        <button type="submit" class="btn">Create User</button>
    </form>
</div>

</body>
</html>
