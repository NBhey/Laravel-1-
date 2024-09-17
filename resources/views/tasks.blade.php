<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<table>
    <thead>
    <tr>
        <th>Выполнено</th>
        <th>Название</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <!-- Здесь будут отображаться задачи -->
    </tbody>
</table>

<form id="add-task-form">
    @csrf
    <input type="text" name="title" placeholder="Введите название задачи">
    <button type="submit">Добавить задачу</button>
</form>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        // Обработчик отправки формы добавления задачи
        $('#add-task-form').submit(function(event) {
            event.preventDefault();
            var title = $('input[name="title"]').val();
            $.ajax({
                url: '{{ route("tasks.store") }}',
                method: 'POST',
                data: {
                    title: title,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Обновление таблицы задач
                    $('tbody').append(response);
                    $('input[name="title"]').val('');
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });

        // Обработчик изменения состояния задачи
        $(document).on('change', '.task-checkbox', function() {
            var task_id = $(this).data('id');
            var is_completed = $(this).prop('checked');
            $.ajax({
                url: '/tasks/' + task_id,
                method: 'PUT',
                data: {
                    is_completed: is_completed,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });

        // Обработчик удаления задачи
        $(document).on('click', '.task-delete', function() {
            var task_id = $(this).data('id');
            $.ajax({
                url: '/tasks/' + task_id,
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    // Удаление строки из таблицы задач
                    $('#task-' + task_id).remove();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
</body>
