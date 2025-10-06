@extends('admin.master_admin')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="col-lg-16">
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">تعديل الجولة</h4>

            <form method="POST" action="{{ route('update.round') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $round->id }}">

                {{-- اختيار المهرجان المرتبط --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">المهرجان</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <select name="festival_id" class="form-control" required>
                            <option value="">اختر المهرجان</option>
                            @foreach($festivals as $festival)
                                <option value="{{ $festival->id }}" {{ $festival->id == $round->festival_id ? 'selected' : '' }}>
                                    {{ $festival->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('festival_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- اسم الجولة --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">اسم الجولة</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="name" class="form-control" value="{{ $round->name }}" />
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- اسم الجولة انجليزي --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">اسم الجولة (EN)</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="name_en" class="form-control" value="{{ $round->name_en }}" />
                        @error('name_en') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- الوصف --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">الوصف</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <textarea name="des" class="form-control">{{ $round->des }}</textarea>
                        @error('des') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- الوصف انجليزي --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">الوصف (EN)</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <textarea name="des_en" class="form-control">{{ $round->des_en }}</textarea>
                        @error('des_en') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- رقم الجولة --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">رقم الجولة</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="number" name="round_number" class="form-control" value="{{ $round->round_number }}" />
                        @error('round_number') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- بداية الجولة --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">تاريخ البداية</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="datetime-local" name="start" class="form-control" value="{{ $round->start }}" />
                        @error('start') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- نهاية الجولة --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">تاريخ النهاية</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="datetime-local" name="end" class="form-control" value="{{ $round->end }}" />
                        @error('end') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- نوع الجولة --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">نوع الجولة</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <select name="round_type" id="round_type" class="form-control" required>
                            <option value="">اختر النوع</option>
                            <option value="بكار" {{ $round->round_type == 'بكار' ? 'selected' : '' }}>بكار</option>
                            <option value="قعدان" {{ $round->round_type == 'قعدان' ? 'selected' : '' }}>قعدان</option>
                        </select>
                        @error('round_type') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- الفئة العمرية --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">الفئة العمرية</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <select name="age_name" id="age_name" class="form-control">
                            <option value="all" {{ $round->age_name == 'all' ? 'selected' : '' }}>الكل</option>
                            <option value="الحقايق" {{ $round->age_name == 'الحقايق' ? 'selected' : '' }}>الحقايق</option>
                            <option value="اللقايا" {{ $round->age_name == 'اللقايا' ? 'selected' : '' }}>اللقايا</option>
                            <option value="الجذاع" {{ $round->age_name == 'الجذاع' ? 'selected' : '' }}>الجذاع</option>
                            <option value="الثنايا" {{ $round->age_name == 'الثنايا' ? 'selected' : '' }}>الثنايا</option>
                            <option value="زمول" {{ $round->age_name == 'زمول' ? 'selected' : '' }}>زمول</option>
                            <option value="الحيل" {{ $round->age_name == 'الحيل' ? 'selected' : '' }}>الحيل</option>
                        </select>
                        @error('age_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- المطايا المشاركة --}}
                <div class="row mb-3">
                    <div class="col-sm-3"><h6 class="mb-0">المطايا المشاركة</h6></div>
                    <div class="col-sm-9 text-secondary">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAllCamals"> اختيار الكل</th>
                                    <th>اسم المطية</th>
                                    <th>المالك</th>
                                    <th>الفئة العمرية</th>
                                    <th>رقم التسجيل</th>
                                </tr>
                            </thead>
                            <tbody id="camalsTableBody">
                                {{-- سيتم تحميل المطايا عبر Ajax --}}
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- زر الإرسال --}}
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9 text-secondary">
                        <input type="submit" class="btn btn-primary px-4" value="تحديث الجولة">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- اسكربت تحميل المطايا --}}
<script>
$(document).ready(function() {
    function loadCamals() {
        var gender = $('#round_type').val();
        var age = $('#age_name').val();
        var selectedCamals = @json($round->camals->pluck('pivot')->mapWithKeys(function($pivot) {
            return [$pivot->camal_id => ['selected' => true, 'registration_number' => $pivot->registration_number]];
        }));

        if (!gender) {
            $('#camalsTableBody').html('<tr><td colspan="5" class="text-center">اختر نوع الجولة أولاً</td></tr>');
            return;
        }

        $.ajax({
            url: "{{ url('/get-camals') }}/" + gender,
            type: "GET",
            data: { age: age },
            dataType: "json",
            success: function(data) {
                $('#camalsTableBody').empty();
                if (data.length > 0) {
                    $.each(data, function(key, camal) {
                        var isChecked = selectedCamals[camal.id] ? 'checked' : '';
                        var regNumber = selectedCamals[camal.id] ? selectedCamals[camal.id].registration_number : '';
                        $('#camalsTableBody').append(
                            '<tr>'+
                                '<td><input type="checkbox" class="camalCheckbox" name="camals['+ camal.id +'][selected]" value="1" '+isChecked+'></td>'+
                                '<td>'+ camal.name +'</td>'+
                                '<td>'+ (camal.user ? camal.user.fname : '') +'</td>'+
                                '<td>'+ camal.age_name +'</td>'+
                                '<td><input type="text" name="camals['+ camal.id +'][number]" class="form-control" value="'+regNumber+'"></td>'+
                            '</tr>'
                        );
                    });
                } else {
                    $('#camalsTableBody').append('<tr><td colspan="5" class="text-center">لا توجد مطايا لهذا النوع</td></tr>');
                }
            },
            error: function(err) {
                console.log(err);
                $('#camalsTableBody').html('<tr><td colspan="5" class="text-center">حدث خطأ أثناء جلب البيانات</td></tr>');
            }
        });
    }

    $('#round_type, #age_name').on('change', loadCamals);

    $(document).on('change', '#selectAllCamals', function () {
        var isChecked = $(this).is(':checked');
        $('#camalsTableBody input[type="checkbox"]').prop('checked', isChecked);
    });

    $(document).on('change', '.camalCheckbox', function () {
        var allChecked = $('.camalCheckbox').length === $('.camalCheckbox:checked').length;
        $('#selectAllCamals').prop('checked', allChecked);
    });

    loadCamals();
});
</script>

<style>
table th:first-child, table td:first-child { width: 120px; }
table th:last-child, table td:last-child { width: 200px; text-align: center; }
</style>

@endsection
