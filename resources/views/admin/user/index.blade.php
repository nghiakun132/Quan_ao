@extends('admin.layouts.index')
@section('title', 'Khách hàng')
@section('content')
    <h3>
        Quản lý khách hàng
    </h3>

    <div class="row">
        <div class="col-12 mt-2">
            <table class="table table-bordered" id="example1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>
                            Số điện thoại
                        </th>
                        <th>
                            Ngày sinh
                        </th>
                        <th>Ngày tạo</th>
                        <th>Ngày cập nhật</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>

                            <td>
                                {{ $user->phone }}
                            </td>

                            <td>
                                {{ $user->birthday }}
                            </td>

                            <td>
                                {{ $user->created_at }}
                            </td>

                            <td>
                                {{ $user->updated_at }}
                            </td>

                            <td>
                                <a href="{{ route('admin.user.changeStatus', $user->id) }}">
                                    @if ($user->status == 0)
                                        <span class="badge badge-success">Hoạt động</span>
                                    @else
                                        <span class="badge badge-danger">Bị khóa</span>
                                    @endif
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Không có dữ liệu</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection
