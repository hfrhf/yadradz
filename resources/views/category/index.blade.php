@extends('dashboard.dashboard')
@section('title','الاقسام')



@include('dashboard.sidebar')
@section('content')
    
<a class="btn-create" href={{route('category.create')}}>اضافة قسم</a>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>معرف</th>
                <th>الاسم</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
            <tr>
                <td style="background-color: #303036;color:white;text-align:center" >{{$categories->firstItem() + $loop->index}}</td>
                <td>{{$category->name}}</td>
                <td>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <form>
                            <a href={{ route('category.edit', $category->id) }} class="btn btn-primary">تحديث</a>
                        </form>
                        <form>
                            <a href={{ route('category.show', $category->id) }} class="btn btn-dark">عرض</a>
                        </form>
                        <form action={{route('category.destroy',$category->id)}} method='post'>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td class="text-center" colspan="3">لا توجد فئات</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{$categories->links()}}

@endsection

