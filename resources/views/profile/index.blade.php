@extends('dashboard.dashboard')
@section('title','المستخدمين')



@include('dashboard.sidebar')
@section('content')

<a class="btn-create" href={{route('profile.create')}}>اضافة مستخدم</a>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>معرف</th>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الدور</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($profiles as $index => $profile)
            <tr>
                <td style="background-color: #303036;color:white;text-align:center" >{{$profiles->firstItem() + $loop->index}}</td>
                <td>{{$profile->name}}</td>
                <td>{{$profile->email}}</td>
                <td>{{ $profile->getRoleNames()->first() ?? 'بدون دور' }}</td>
                <td>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <form>
                            <a href={{ route('profile.edit', $profile->id) }} class="btn btn-primary">تحديث</a>
                        </form>
                        @if (Auth::user()->id !== $profile->id)
                        <button class="delete-user btn btn-danger" type="button">حذف</button>
                        <div class="confirm-delete window-delete">
                            <div class="window-content">
                                <p>هل أنت متأكد أنك تريد حذف هذا الحساب؟ سيتم حذف كل المعاملات التي قام بها ! يمكنك تغيير الايمايل الى email-Forbidden@email.com بدل حذفه</p>
                                <form action="{{route('profile.destroy', $profile->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                   <div class="confirm-cancel">
                                    <button type="submit" class="btn btn-danger">تأكيد الحذف</button>
                                    <button type="button" class="cancel-delete btn btn-secondary">إلغاء</button>
                                   </div>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td class="text-center" colspan="5">لا توجد ملفات شخصية</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<script>
// الحصول على جميع أزرار الحذف
const deleteButtons = document.querySelectorAll('.delete-user');
const cancelButtons = document.querySelectorAll('.cancel-delete');
const confirmDeletes = document.querySelectorAll('.confirm-delete');

// ربط الأحداث بالأزرار
deleteButtons.forEach((deleteButton, index) => {
    deleteButton.addEventListener('click', function() {
        confirmDeletes[index].style.display = 'flex'; // إظهار النافذة
    });
});

cancelButtons.forEach((cancelButton, index) => {
    cancelButton.addEventListener('click', function() {
        confirmDeletes[index].style.display = 'none'; // إخفاء النافذة
    });
});

</script>

{{$profiles->links()}}

@endsection

