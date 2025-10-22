@extends('Admin.layouts.app')

@section('content')
    @php use App\Helpers\DateFormat; @endphp
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Xem nhiệm vụ</h2>

        <!-- Tìm kiếm -->
        <form action="" method="GET" class="d-flex align-items-center" style=" margin-bottom: 0;">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Tìm kiếm người dùng"
                value="{{ request()->get('search') }}" style="max-width: 200px; height: 40px;">
            <button type="submit" class="btn btn-secondary btn-sm ms-2" style="height: 40px; width: 100px;">Tìm
                kiếm</button>
        </form>

        <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">+ Thêm nhiệm vụ</a>
    </div>


    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th class="text-center" style="width: 50px;">STT</th>
                <th>Tiêu đề công việc</th>
                <th>Email</th>
                <th>Mô tả</th>
                <th>Hạn</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($taskDetails as $taskDetail)
                <tr>
                    <td class="text-center">
                        {{ ($taskDetails->currentPage() - 1) * $taskDetails->perPage() + $loop->iteration }}
                    </td>
                    <td>{{ $taskDetail->title ?? 'Không có' }}</td>
                    <td>{{ $taskDetail->task->user->email }}</td>
                    <td>
                        {{ $taskDetail->description }}
                    </td>
                    <td>
                        {{ DateFormat::formatDate($taskDetail->due_date) }} :
                        {{ DateFormat::formatTime($taskDetail->time) }}
                    </td>
                    <td class="text-center">
                        @switch($taskDetail->status)
                            @case(0)
                                <span class="badge bg-warning">In process</span>
                            @break

                            @case(1)
                                <span class="badge bg-info">Done</span>
                            @break

                            @case(2)
                                <span class="badge bg-danger">Deleting</span>
                            @break
                        @endswitch
                    </td>
                    <td class="d-flex justify-content-center align-items-center gap-2">
                        <a href="{{ route('admin.tasks.edit', $taskDetail->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i> Sửa
                        </a>
                        <!-- Delete -->
                        <a href="">
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                                data-userid="{{ $taskDetail->id }}">
                                Xóa
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-block card-footer">
        {{ $taskDetails->links('pagination::bootstrap-5') }}
    </div>
@endsection
