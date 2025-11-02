@extends('admin.master_admin')
@section('admin')

<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">كل الاشعارات</div>

    <div class="ps-3">
<a href="{{route('delete.notification.all')}}" class="btn btn-danger" id="delete"gi>حذف الكل</a>

        <nav aria-label="breadcrumb"></nav>
    </div>
</div>
<!--end breadcrumb-->

<hr/>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>الرقم</th>
                        <th>العنوان</th>
                        {{-- <th> الوصف</th> --}}
                        <th>تم الارسال الى</th>
                        <th>وقت الإرسال</th>
                        <th>الحالة</th>
                        <th>الاجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notification as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->title }}</td>
                        {{-- <td>{{ $item->des }}</td> --}}
                        <td>{{ $item->user->fname }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
                        <td>
                            @if ($item->user_view == 'no')
                                <span class="badge bg-dark">لم تتم المشاهدة</span>
                            @elseif ($item->user_view == 'yes')
                                <span class="badge bg-success">تمت المشاهدة</span>
                            @else
                                <span class="badge bg-danger">تم الحذف</span>
                            @endif
                        </td>
                        <td>
                            <a href="javascript:void(0);"
                               class="btn btn-primary showNotificationBtn"
                               data-title="{{ $item->title }}"
                               data-description="{!! htmlspecialchars($item->des, ENT_QUOTES) !!}"
                               title="تفاصيل">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('delete.notification', $item->id) }}" class="btn btn-danger" id="delete">حذف</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>الرقم</th>
                        <th>العنوان</th>
                        {{-- <th> الوصف</th> --}}
                        <th>تم الارسال الى</th>
                        <th>وقت الإرسال</th>
                        <th>الحالة</th>
                        <th>الاجراء</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notificationModalLabel">عنوان الإشعار</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
      </div>
      <div class="modal-body" id="notificationDescription">
        <!-- سيتم عرض الوصف هنا -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
      </div>
    </div>
  </div>
</div>

<!-- Optional styling (if you prefer CSS over JS for image control) -->
<style>
    #notificationDescription img {
        max-width: 100%;
        height: auto;
        max-height: 400px;
        object-fit: contain;
        display: block;
        margin-bottom: 10px;
    }
</style>

<!-- JavaScript to handle modal, responsive video, and medium image size -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const buttons = document.querySelectorAll('.showNotificationBtn');
        const modal = new bootstrap.Modal(document.getElementById('notificationModal'));

        buttons.forEach(btn => {
            btn.addEventListener('click', function () {
                const title = this.getAttribute('data-title');
                const description = this.getAttribute('data-description');

                const container = document.getElementById('notificationDescription');
                document.getElementById('notificationModalLabel').innerText = title;
                container.innerHTML = description;

                // Wrap iframes with Bootstrap 5 responsive video container
                const iframes = container.querySelectorAll('iframe');
                iframes.forEach(iframe => {
                    if (!iframe.parentElement.classList.contains('ratio')) {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'ratio ratio-16x9';
                        iframe.parentNode.insertBefore(wrapper, iframe);
                        wrapper.appendChild(iframe);
                    }
                });

                // Resize images to medium height
                const images = container.querySelectorAll('img');
                images.forEach(img => {
                    img.style.maxWidth = '100%';
                    img.style.height = 'auto';
                    img.style.maxHeight = '400px';
                    img.style.objectFit = 'contain';
                    img.style.display = 'block';
                    img.style.marginBottom = '10px';
                });

                modal.show();
            });
        });
    });
</script>

<!-- Include Bootstrap JS if not already present in your layout -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

@endsection
