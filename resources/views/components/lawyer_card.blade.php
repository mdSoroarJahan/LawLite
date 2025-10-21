<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex">
            <div class="flex-shrink-0 me-3">
                <img src="{{ $lawyer->photo ?? 'https://via.placeholder.com/80' }}" alt="profile" class="rounded"
                    style="width:80px;height:80px;object-fit:cover">
            </div>
            <div>
                <h5 class="card-title mb-1">{{ $lawyer->name }} @if ($lawyer->verified)
                        <span class="badge bg-primary">Verified</span>
                    @endif
                </h5>
                <p class="mb-1"><strong>@lang('lawyer.expertise'):</strong> {{ $lawyer->expertise }}</p>
                <p class="mb-0 text-muted">{{ $lawyer->city ?? '' }}</p>
            </div>
        </div>
    </div>
</div>
