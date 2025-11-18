@extends('admin.master_admin')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="col-lg-16">
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">إضافة شوط جديد</h4>

            <form method="POST" action="{{ route('add.round.store') }}">
                @csrf

                {{-- اختيار المهرجان --}}
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <h6 class="mb-0">المهرجان</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <select name="festival_id" class="form-control" required>
                            <option value="">اختر المهرجان</option>
                            @foreach($festivals as $festival)
                                <option value="{{ $festival->id }}">{{ $festival->name }}</option>
                            @endforeach
                        </select>
                        @error('festival_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- اسم الشوط --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">اسم الشوط</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="name" class="form-control" required />
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- اسم الشوط (EN) --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">اسم الشوط (EN)</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="name_en" class="form-control" />
                        @error('name_en') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- الوصف --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">الوصف</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <textarea name="des" class="form-control"></textarea>
                        @error('des') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- الوصف (EN) --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">الوصف (EN)</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <textarea name="des_en" class="form-control"></textarea>
                        @error('des_en') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- رقم الشوط --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">رقم الشوط</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="number" name="round_number" class="form-control" required />
                        @error('round_number') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- تاريخ البداية --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">تاريخ ووقت البداية</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="datetime-local" name="start" class="form-control" required />
                        @error('start') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- تاريخ النهاية --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">تاريخ ووقت النهاية</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="datetime-local" name="end" class="form-control" required />
                        @error('end') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- نوع الشوط --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">نوع الشوط</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <select name="round_type" class="form-control" required>
                            <option value="">اختر النوع</option>
                            <option value="بكار">بكار</option>
                            <option value="قعدان">قعدان</option>
                        </select>
                        @error('round_type') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- المطايا المشاركة --}}
                <div class="row mb-3">
                    {{-- <div class="col-sm-3"><h6 class="mb-0">المطايا المشاركة</h6></div> --}}
                    <div class="col-12 text-secondary">

                        @if($errors->has('camals'))
                            <div class="alert alert-danger py-2">{{ $errors->first('camals') }}</div>
                        @endif

                        <table class="table table-bordered">
                            <thead class="table-light">
                                {{-- <tr>
                                    <th style="width:100px;">رقم التسجيل</th>
                                    <th>اسم المطية</th>
                                    <th style="width:180px;">الفئة العمرية</th>
                                    <th>اسم المالك</th>
                                    <th>الدولة</th>
                                    <th style="width:100px;">إجراء</th>
                                </tr> --}}
                                <tr>
    <th style="width:100px;">رقم التسجيل</th>
    <th style="min-width:250px;">اسم المطية</th>
    <th style="width:180px;">الفئة العمرية</th>
    <th style="min-width:300px;">اسم المالك</th>
    <th style="width:200px;">الدولة</th>
    <th style="width:100px;">إجراء</th>
</tr>
                            </thead>
                            <tbody id="camalsTableBody">
                                <tr>
                                    <td class="text-center">1</td>
                                    <td><input type="text" name="camals[0][name]" class="form-control" placeholder="اسم المطية" required></td>
                                    <td>
                                        <select name="camals[0][age_name]" class="form-control" required>
                                            <option value="">اختر الفئة</option>
                                        <option value="مفاريد">مفاريد</option>

                                            <option value="الحقايق">الحقايق</option>
                                            <option value="اللقايا">اللقايا</option>
                                            <option value="الجذاع">الجذاع</option>
                                            <option value="الثنايا">الثنايا</option>
                                            <option value="زمول">زمول</option>
                                            <option value="الحيل">الحيل</option>
                                        </select>
                                    </td>
                                    <td><input type="text" name="camals[0][owner_name]" class="form-control" placeholder="اسم المالك" required></td>
                                    <td><input type="text" name="camals[0][country]" class="form-control" placeholder="الدولة" required></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm removeRow">حذف</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success btn-sm" id="addRow">➕ إضافة صف</button>
                    </div>
                </div>

                {{-- زر الإرسال --}}
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="submit" class="btn btn-primary px-4" value="إضافة الجولة">
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- سكريبت إدارة الصفوف --}}
<script>
$(document).ready(function() {
    let rowIndex = 1;

    $('#addRow').on('click', function() {
        rowIndex++;
        const newRow = `
            <tr>
                <td class="text-center">${rowIndex}</td>
                <td><input type="text" name="camals[${rowIndex - 1}][name]" class="form-control" placeholder="اسم المطية" required></td>
                <td>
                    <select name="camals[${rowIndex - 1}][age_name]" class="form-control" required>
                        <option value="">اختر الفئة</option>
                         <option value="مفاريد">مفاريد</option>

                        <option value="الحقايق">الحقايق</option>
                        <option value="اللقايا">اللقايا</option>
                        <option value="الجذاع">الجذاع</option>
                        <option value="الثنايا">الثنايا</option>
                        <option value="زمول">زمول</option>
                        <option value="الحيل">الحيل</option>
                    </select>
                </td>
                <td><input type="text" name="camals[${rowIndex - 1}][owner_name]" class="form-control" placeholder="اسم المالك" required></td>
                <td><input type="text" name="camals[${rowIndex - 1}][country]" class="form-control" placeholder="الدولة" required></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm removeRow">حذف</button>
                </td>
            </tr>`;
        $('#camalsTableBody').append(newRow);
    });

    $(document).on('click', '.removeRow', function() {
        $(this).closest('tr').remove();
        updateRowNumbers();
    });

    function updateRowNumbers() {
        let i = 1;
        $('#camalsTableBody tr').each(function() {
            $(this).find('td:first').text(i);
            i++;
        });
        rowIndex = i;
    }
});
</script>

<style>
table th, table td {
    vertical-align: middle !important;
}
</style>

@endsection
