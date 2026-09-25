<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Manager</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #1b1e25;
            --surface: #20242c;
            --card: #2a2e38;
            --card-hover: #313644;
            --border: rgba(255,255,255,.07);
            --text: #e8eaef;
            --text-soft: #9aa1ae;
            --text-faint: #6b7280;
            --blue: #2f81f7;
            --blue-hover: #4a90f8;
            --pending-bg: rgba(202,161,86,.16);
            --pending-fg: #d8b06a;
            --completed-bg: rgba(76,154,106,.16);
            --completed-fg: #6fbf8b;
            --danger: #e0645c;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            margin: 0;
            min-height: 100vh;
        }

        /* ---------- Top bar ---------- */

        .topbar {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: 1.1rem 2rem;
            border-bottom: 1px solid var(--border);
            font-size: .95rem;
            color: var(--text-soft);
        }

        .topbar .icon-badge {
            width: 1.5rem; height: 1.5rem;
            border-radius: 6px;
            background: var(--completed-bg);
            color: var(--completed-fg);
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem;
        }

        .topbar .crumb-current { color: var(--text); font-weight: 500; }

        /* ---------- Header ---------- */

        .header {
            padding: 2.25rem 2rem 0;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: .9rem;
        }

        .header-title .badge {
            width: 2.75rem; height: 2.75rem;
            border-radius: 10px;
            background: var(--completed-bg);
            color: var(--completed-fg);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

        .header-title h1 {
            font-size: 2.1rem;
            font-weight: 700;
            margin: 0;
        }

        .toolbar {
            display: flex;
            align-items: center;
            gap: 1.6rem;
            margin: 1.5rem 0 0;
            padding-bottom: 1.1rem;
            border-bottom: 1px solid var(--border);
            font-size: .92rem;
            color: var(--text-soft);
        }

        .toolbar .spacer { flex: 1; }

        .toolbar-item {
            display: flex;
            align-items: center;
            gap: .4rem;
            cursor: default;
        }

        .btn-new {
            display: flex;
            align-items: center;
            gap: .4rem;
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: .5rem 1rem;
            font: inherit;
            font-weight: 500;
            font-size: .88rem;
            cursor: pointer;
            transition: background-color .15s ease;
        }

        .btn-new:hover { background: var(--blue-hover); }

        .flash {
            margin: 1rem 2rem 0;
            font-size: .85rem;
            color: var(--completed-fg);
            background: var(--completed-bg);
            border-left: 3px solid var(--completed-fg);
            padding: .55rem .8rem;
            border-radius: 4px;
        }

        /* ---------- Board ---------- */

        .board {
            display: flex;
            gap: 1.5rem;
            padding: 1.5rem 2rem 3rem;
            overflow-x: auto;
            align-items: flex-start;
        }

        .column {
            flex: 0 0 300px;
            width: 300px;
        }

        .column-head {
            display: flex;
            align-items: center;
            gap: .6rem;
            margin-bottom: .9rem;
        }

        .status-pill {
            font-size: .78rem;
            font-weight: 600;
            padding: .22rem .65rem;
            border-radius: 5px;
        }

        .status-pill.Pending { background: var(--pending-bg); color: var(--pending-fg); }
        .status-pill.Completed { background: var(--completed-bg); color: var(--completed-fg); }

        .column-count { color: var(--text-faint); font-size: .85rem; }

        .column-head .spacer { flex: 1; }

        .col-add-btn {
            background: none;
            border: none;
            color: var(--text-faint);
            font-size: 1.1rem;
            cursor: pointer;
            padding: .1rem .3rem;
            border-radius: 4px;
            transition: color .15s ease, background-color .15s ease;
        }

        .col-add-btn:hover { color: var(--text); background: var(--card); }

        .cards { display: flex; flex-direction: column; gap: .75rem; }

        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1rem 1.1rem;
            transition: background-color .15s ease, border-color .15s ease;
        }

        .card:hover { background: var(--card-hover); }

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: .6rem;
        }

        .tag-pill {
            font-size: .74rem;
            font-weight: 500;
            color: #9db8d8;
            background: rgba(77,125,178,.18);
            padding: .18rem .55rem;
            border-radius: 4px;
        }

        .check-form { margin: 0; }

        .check-btn {
            width: 1.35rem;
            height: 1.35rem;
            border-radius: 50%;
            border: 1.5px solid var(--text-faint);
            background: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: border-color .15s ease, background-color .15s ease;
        }

        .check-btn:hover { border-color: var(--completed-fg); }

        .check-btn.done {
            background: var(--completed-fg);
            border-color: var(--completed-fg);
            color: var(--surface);
        }

        .check-btn svg { width: .7rem; height: .7rem; opacity: 0; }
        .check-btn.done svg { opacity: 1; }

        .card-name {
            font-size: .96rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: .3rem;
            line-height: 1.35;
        }

        .card-name.done { text-decoration: line-through; color: var(--text-faint); }

        .card-desc {
            font-size: .82rem;
            color: var(--text-soft);
            line-height: 1.45;
            margin-bottom: .7rem;
        }

        .card-due {
            display: flex;
            align-items: center;
            gap: .35rem;
            font-size: .78rem;
            color: var(--text-faint);
            margin-bottom: .6rem;
        }

        .card-actions {
            display: flex;
            gap: .9rem;
            padding-top: .6rem;
            border-top: 1px solid var(--border);
        }

        .card-actions button {
            font: inherit;
            font-size: .78rem;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            color: var(--text-faint);
            transition: color .15s ease;
        }

        .card-actions button:hover { color: var(--text); }
        .card-actions .delete:hover { color: var(--danger); }
        .card-actions form { margin: 0; }

        .new-row {
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            color: var(--text-faint);
            font: inherit;
            font-size: .85rem;
            padding: .5rem .2rem;
            margin-top: .5rem;
            cursor: pointer;
            transition: color .15s ease;
        }

        .new-row:hover { color: var(--text); }

        .empty-col {
            font-size: .82rem;
            color: var(--text-faint);
            font-style: italic;
            padding: .5rem .2rem;
        }

        /* ---------- Modal ---------- */

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.55);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            z-index: 50;
        }

        .modal-overlay.open { display: flex; }

        .modal-box {
            width: 100%;
            max-width: 420px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1.75rem 1.75rem 1.5rem;
            box-shadow: 0 20px 50px rgba(0,0,0,.4);
            animation: modal-in .15s ease;
        }

        @keyframes modal-in {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-box h2 {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0 0 1.3rem;
            color: var(--text);
        }

        .field { margin-bottom: 1.1rem; }

        .field label {
            display: block;
            font-size: .78rem;
            color: var(--text-soft);
            margin-bottom: .4rem;
        }

        .field input, .field textarea {
            width: 100%;
            padding: .55rem .65rem;
            border: 1px solid var(--border);
            border-radius: 6px;
            background: var(--card);
            font: inherit;
            font-size: .9rem;
            color: var(--text);
            transition: border-color .15s ease;
        }

        .field input::placeholder, .field textarea::placeholder { color: var(--text-faint); }
        .field input:focus, .field textarea:focus { outline: none; border-color: var(--blue); }
        .field textarea { min-height: 76px; resize: vertical; }

        .invalid { border-color: var(--danger) !important; }
        .error-text { color: var(--danger); font-size: .76rem; margin-top: .35rem; }

        .modal-buttons { display: flex; gap: 1.1rem; align-items: center; margin-top: 1.5rem; }

        .btn-primary {
            background: var(--blue);
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: .55rem 1.2rem;
            font: inherit;
            font-size: .87rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color .15s ease;
        }

        .btn-primary:hover { background: var(--blue-hover); }

        .modal-cancel {
            font-size: .85rem;
            color: var(--text-faint);
            background: none;
            border: none;
            font: inherit;
            cursor: pointer;
            padding: 0;
        }

        .modal-cancel:hover { color: var(--text); }

        @media (max-width: 640px) {
            .topbar, .header, .flash { padding-left: 1.1rem; padding-right: 1.1rem; }
            .board { padding-left: 1.1rem; padding-right: 1.1rem; }
        }
    </style>
</head>
<body>

<div class="topbar">
    <span class="icon-badge">&#9776;</span>
    <span>Task Manager</span>
    <span>/</span>
    <span class="icon-badge">&#10003;</span>
    <span class="crumb-current">Board</span>
</div>

<div class="header">
    <div class="header-title">
        <span class="badge">&#10003;</span>
        <h1>Task Board</h1>
    </div>

    <div class="toolbar">
        <span class="toolbar-item">Group by Status</span>
        <div class="spacer"></div>
        <button type="button" class="btn-new" onclick="openAddModal()">+ New</button>
    </div>
</div>

@if (session('success'))
    <div class="flash">{{ session('success') }}</div>
@endif

@if ($errors->any() && session('modal') === 'add')
    <script>window.addEventListener('DOMContentLoaded', () => openAddModal());</script>
@endif

<div class="board">
    @php
        $columns = [
            'Pending' => $tasks->where('status', 'Pending'),
            'Completed' => $tasks->where('status', 'Completed'),
        ];
    @endphp

    @foreach ($columns as $statusName => $columnTasks)
        <div class="column">
            <div class="column-head">
                <span class="status-pill {{ $statusName }}">{{ $statusName }}</span>
                <span class="column-count">{{ $columnTasks->count() }}</span>
                <div class="spacer"></div>
                <button type="button" class="col-add-btn" onclick="openAddModal()" aria-label="Add task">+</button>
            </div>

            <div class="cards">
                @forelse ($columnTasks as $task)
                    <div class="card">
                        <div class="card-top">
                            <span class="tag-pill">Task</span>
                            <form method="POST" action="{{ route('tasks.status', $task) }}" class="check-form">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="check-btn {{ $task->status === 'Completed' ? 'done' : '' }}"
                                        aria-label="{{ $task->status === 'Completed' ? 'Mark pending' : 'Mark done' }}">
                                    <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 8.5L6.2 11.5L13 4.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="card-name {{ $task->status === 'Completed' ? 'done' : '' }}">{{ $task->task_name }}</div>

                        @if ($task->description)
                            <div class="card-desc">{{ $task->description }}</div>
                        @endif

                        @if ($task->due_date)
                            <div class="card-due">
                                &#128197; {{ \Carbon\Carbon::parse($task->due_date)->format('M j, Y') }}
                            </div>
                        @endif

                        <div class="card-actions">
                            <button type="button"
                                    onclick="openEditModal(
                                        '{{ route('tasks.update', $task) }}',
                                        {{ Illuminate\Support\Js::from($task->task_name) }},
                                        {{ Illuminate\Support\Js::from($task->description) }},
                                        {{ Illuminate\Support\Js::from($task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}
                                    )">Edit</button>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                  onsubmit="return confirm('Delete this entry?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty-col">Nothing here yet.</div>
                @endforelse
            </div>

            <button type="button" class="new-row" onclick="openAddModal()">+ New</button>
        </div>
    @endforeach
</div>

<!-- Add Entry Modal -->
<div class="modal-overlay" id="add-modal-overlay">
    <div class="modal-box">
        <h2>New task</h2>
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <input type="hidden" name="modal_source" value="add">

            <div class="field">
                <label for="add_task_name">Task</label>
                <input type="text" id="add_task_name" name="task_name"
                       value="{{ session('modal') === 'add' ? old('task_name') : '' }}"
                       placeholder="What needs doing?"
                       class="@error('task_name') invalid @enderror">
                @error('task_name')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="add_description">Notes (optional)</label>
                <textarea id="add_description" name="description" placeholder="Any details worth noting"
                          class="@error('description') invalid @enderror">{{ session('modal') === 'add' ? old('description') : '' }}</textarea>
                @error('description')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="add_due_date">Due (optional)</label>
                <input type="date" id="add_due_date" name="due_date"
                       value="{{ session('modal') === 'add' ? old('due_date') : '' }}"
                       class="@error('due_date') invalid @enderror">
                @error('due_date')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="modal-buttons">
                <button type="submit" class="btn-primary">Save task</button>
                <button type="button" class="modal-cancel" onclick="closeModal('add-modal-overlay')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Entry Modal (one shared form, filled in by JS) -->
<div class="modal-overlay" id="edit-modal-overlay">
    <div class="modal-box">
        <h2>Edit task</h2>
        <form method="POST" id="edit-form" action="">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="edit_task_name">Task</label>
                <input type="text" id="edit_task_name" name="task_name">
            </div>

            <div class="field">
                <label for="edit_description">Notes (optional)</label>
                <textarea id="edit_description" name="description"></textarea>
            </div>

            <div class="field">
                <label for="edit_due_date">Due (optional)</label>
                <input type="date" id="edit_due_date" name="due_date">
            </div>

            <div class="modal-buttons">
                <button type="submit" class="btn-primary">Save changes</button>
                <button type="button" class="modal-cancel" onclick="closeModal('edit-modal-overlay')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('add-modal-overlay').classList.add('open');
    }

    function openEditModal(action, name, description, dueDate) {
        const form = document.getElementById('edit-form');
        form.action = action;
        document.getElementById('edit_task_name').value = name || '';
        document.getElementById('edit_description').value = description || '';
        document.getElementById('edit_due_date').value = dueDate || '';
        document.getElementById('edit-modal-overlay').classList.add('open');
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('open');
    }

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) overlay.classList.remove('open');
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.open').forEach(o => o.classList.remove('open'));
        }
    });
</script>
</body>
</html>