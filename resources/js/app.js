import './bootstrap';

document.addEventListener('DOMContentLoaded', function() {
    // Добавление задачи
    const addTaskForm = document.querySelector('#add-task-form');
    addTaskForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const title = document.querySelector('#title').value;

        fetch('/tasks', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                title: title
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/';
                }
            });
    });

    // Удаление задачи
    const deleteTaskLinks = document.querySelectorAll('.delete-task');
    deleteTaskLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            const taskId = link.getAttribute('data-task-id');

            fetch(`/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                });
        });
    });

    // Отметка задачи как выполненной/невыполненной
    const taskCheckboxes = document.querySelectorAll('input[name="completed"]');
    taskCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function(event) {
            const taskId = checkbox.getAttribute('data-task-id');
            const completed = checkbox.checked;

            fetch(`/tasks/${taskId}/${completed ? 'complete' : 'incomplete'}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                });
        });
    });
});
