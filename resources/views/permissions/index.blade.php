@extends('dashboard.dashboard')
@section('title','الصلاحيات')



@include('dashboard.sidebar')
@section('content')
<a class="btn-create" href={{route('permissions.create')}}>اضافة صلاحية</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead >
            <tr>
                <th style="" >معرف</th>
                <th>الاسم</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($permissions as $index => $permission)
            <tr>
                <td style="background-color: #303036;color:white;text-align:center" >{{ $permissions->firstItem() + $loop->index}}</td>
                <td>{{$permission->name}}</td>

                <td>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <form>
                            <a href={{ route('permissions.edit', $permission->id) }} class="btn btn-primary">تحديث</a>
                        </form>
                        <form action={{route('permissions.destroy',$permission->id)}} method='post'>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td class="text-center" colspan="8">لا توجد صلاحيات</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


{{$permissions->links()}}


@endsection

