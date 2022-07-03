
@foreach ($comments as $comment)
<div class="comment-item">
    <div class="comment-details">
        <div>
            @auth
                <button class="new-comment-btn" onclick="newComment('{{ route('home.newComment') }}', '{{ $product->id }}', '{{ $comment->id }}') ">ثبت نظر </button>
            @endauth
        </div>
        <div class="user-details">
            @if($comment->user->is_superuser == 1) <span class="superuser-type">مدیر سایت</span> @elseif($commnet->user->is_staff == 1) <span class="staff-type">کارمند سایت</span> @else <span class="user-type">کاربر سایت</span> @endif
            <span>{{ $comment->user->name }}</span>
            <img src="{{ $comment->user->image ? Storage::url($comment->user->image) : asset('assets/images/user/1.png') }}" alt="" class="comment-profile-image">
        </div>
    </div>
    <div class="comment-text">
        <p>{{ $comment->comment }}</p>
        @include('frontend.components.comments', ['comments' => $comment->child()->where('approved', 1)->get()])
    </div>
</div>
@endforeach