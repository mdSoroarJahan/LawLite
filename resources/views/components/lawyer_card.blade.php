<div class="d-flex align-items-start mb-3">
    <div class="flex-shrink-0 me-3">
        <div
            style="width:72px;height:72px;overflow:hidden;border-radius:12px;background:#e6eefc;display:flex;align-items:center;justify-content:center">
            <img src="{{ $lawyer->photo ?? 'https://via.placeholder.com/72' }}" alt="profile"
                style="width:72px;height:72px;object-fit:cover;border-radius:8px">
        </div>
    </div>
    <div class="flex-grow-1">
        <div class="d-flex align-items-start justify-content-between">
            <div>
                <h6 class="mb-1">{{ $lawyer->name }} @if ($lawyer->verified)
                        <span class="badge bg-success ms-2">Verified</span>
                    @endif
                </h6>
                <div class="small small-muted">{{ $lawyer->expertise }}</div>
            </div>
            <div class="text-end small small-muted">{{ $lawyer->city ?? '' }}</div>
        </div>
    </div>
</div>
