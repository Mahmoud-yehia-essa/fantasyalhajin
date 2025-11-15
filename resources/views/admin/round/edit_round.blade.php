@extends('admin.master_admin')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="col-lg-16">
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">تعديل الشوط: {{ $round->name }}</h4>

            <form method="POST" action="{{ route('update.round') }}">
                @csrf
                <input type="hidden" name="round_id" value="{{ $round->id }}">

                {{-- اختيار المهرجان --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">المهرجان</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <select name="festival_id" class="form-control" required>
                            @foreach($festivals as $festival)
                                <option value="{{ $festival->id }}" {{ $festival->id == $round->festival_id ? 'selected' : '' }}>
                                    {{ $festival->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('festival_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- باقي الحقول --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6>اسم الشوط</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="name" class="form-control" value="{{ $round->name }}" required />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3"><h6>اسم الشوط (EN)</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="name_en" class="form-control" value="{{ $round->name_en }}" />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3"><h6>الوصف</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <textarea name="des" class="form-control">{{ $round->des }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3"><h6>الوصف (EN)</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <textarea name="des_en" class="form-control">{{ $round->des_en }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3"><h6>رقم الشوط</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="number" name="round_number" class="form-control" value="{{ $round->round_number }}" required />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3"><h6>تاريخ البداية</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="datetime-local" name="start" class="form-control"
                               value="{{ \Carbon\Carbon::parse($round->start)->format('Y-m-d\TH:i') }}" required />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3"><h6>تاريخ النهاية</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="datetime-local" name="end" class="form-control"
                               value="{{ \Carbon\Carbon::parse($round->end)->format('Y-m-d\TH:i') }}" required />
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3"><h6>نوع الشوط</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <select name="round_type" class="form-control" required>
                            <option value="بكار" {{ $round->round_type == 'بكار' ? 'selected' : '' }}>بكار</option>
                            <option value="قعدان" {{ $round->round_type == 'قعدان' ? 'selected' : '' }}>قعدان</option>
                        </select>
                    </div>
                </div>

                {{-- المطايا --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6>المطايا المشاركة</h6></div>
                    <div class="col-sm-9 text-secondary">

                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>رقم التسجيل</th>
                                    <th>اسم المطية</th>
                                    <th>الفئة العمرية</th>
                                    <th>اسم المالك</th>
                                    <th>الدولة</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            {{-- <tbody id="camalsTableBody">
                                @foreach($camals as $index => $camal)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td><input type="text" name="camals[{{ $index }}][name]" value="{{ $camal->camel_name }}" class="form-control" required></td>
                                        <td>
                                            <select name="camals[{{ $index }}][age_name]" class="form-control" required>
                                                @foreach(['الحقايق','اللقايا','الجذاع','الثنايا','زمول','الحيل'] as $age)
                                                    <option value="{{ $age }}" {{ $camal->camel_age_name == $age ? 'selected' : '' }}>{{ $age }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="text" name="camals[{{ $index }}][owner_name]" value="{{ $camal->camel_owner_name }}" class="form-control" required></td>
                                        <td><input type="text" name="camals[{{ $index }}][country]" value="{{ $camal->camel_owner_country }}" class="form-control" required></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm removeRow">حذف</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody> --}}

                            <tbody id="camalsTableBody">
    @foreach($camals as $index => $camal)
        <tr data-index="{{ $index }}">
            <input type="hidden" name="camals[{{ $index }}][id]" value="{{ $camal->id }}">
            <input type="hidden" name="camals[{{ $index }}][delete]" value="0">
            <td class="text-center">{{ $index + 1 }}</td>
            <td><input type="text" name="camals[{{ $index }}][name]" value="{{ $camal->camel_name }}" class="form-control" required></td>
            <td>
                <select name="camals[{{ $index }}][age_name]" class="form-control" required>
                    @foreach(['الحقايق','اللقايا','الجذاع','الثنايا','زمول','الحيل'] as $age)
                        <option value="{{ $age }}" {{ $camal->camel_age_name == $age ? 'selected' : '' }}>{{ $age }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="text" name="camals[{{ $index }}][owner_name]" value="{{ $camal->camel_owner_name }}" class="form-control" required></td>
            <td><input type="text" name="camals[{{ $index }}][country]" value="{{ $camal->camel_owner_country }}" class="form-control" required></td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm removeRow">حذف</button>
            </td>
        </tr>
    @endforeach
</tbody>
                        </table>

                        <button type="button" class="btn btn-success btn-sm" id="addRow">➕ إضافة صف</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-9 offset-sm-3">
                        <input type="submit" class="btn btn-primary px-4" value="تحديث الشوط">
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- سكربت الصفوف --}}
<script>
$(document).ready(function() {
    let rowIndex = {{ count($camals) }};

    $('#addRow').on('click', function() {
        rowIndex++;
        const newRow = `
            <tr>
                <td class="text-center">${rowIndex}</td>
                <td><input type="text" name="camals[${rowIndex - 1}][name]" class="form-control" required></td>
                <td>
                    <select name="camals[${rowIndex - 1}][age_name]" class="form-control" required>
                        <option value="">اختر الفئة</option>
                        <option value="الحقايق">الحقايق</option>
                        <option value="اللقايا">اللقايا</option>
                        <option value="الجذاع">الجذاع</option>
                        <option value="الثنايا">الثنايا</option>
                        <option value="زمول">زمول</option>
                        <option value="الحيل">الحيل</option>
                    </select>
                </td>
                <td><input type="text" name="camals[${rowIndex - 1}][owner_name]" class="form-control" required></td>
                <td><input type="text" name="camals[${rowIndex - 1}][country]" class="form-control" required></td>
                <td class="text-center"><button type="button" class="btn btn-danger btn-sm removeRow">حذف</button></td>
            </tr>`;
        $('#camalsTableBody').append(newRow);
    });

    // $(document).on('click', '.removeRow', function() {
    //     $(this).closest('tr').remove();
    //     updateRowNumbers();
    // });

    // function updateRowNumbers() {
    //     let i = 1;
    //     $('#camalsTableBody tr').each(function() {
    //         $(this).find('td:first').text(i);
    //         i++;
    //     });
    //     rowIndex = i - 1;
    // }

    $(document).on('click', '.removeRow', function() {
    const row = $(this).closest('tr');
    // ضع delete=1 قبل حذف الصف
    row.find('input[name*="[delete]"]').val(1);
    row.hide(); // أخفي الصف بدل حذفه فوراً
    updateRowNumbers();
});

function updateRowNumbers() {
    let i = 1;
    $('#camalsTableBody tr:visible').each(function() {
        $(this).find('td:first').text(i);
        i++;
    });
    rowIndex = i - 1;
}
});
</script>

@endsection
