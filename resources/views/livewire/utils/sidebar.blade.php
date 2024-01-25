<div id="sidebarMenu" class="main-sidebar offcanvas offcanvas-start d-print-none" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header border-bottom">
      <a wire:navigate href="{{ url('dashboard') }}" class="d-flex align-items-center text-decoration-none px-3">
        {{-- <i class="bi bi-bootstrap-fill h2 px-2 py-1"></i> 
        <h3>Babylon</h3> --}}

        <i class="bi bi-twitter-x h2 px-2 py-1"></i>
        <h3>{{ config('app.name') }}</h3>
      </a>

      <button id="hideSidebar" class="offcanvas-toggler nav-link h2" type="button" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-caret-left-fill"></i>
      </button>
    </div>


    <div class="offcanvas-body offcanvas-body-full">

        <div class="accordion accordion-flush show" id="accordionExample">
            @foreach($models as $row)
                @if($row->parent==null && count($row->children->where('position','1'))==0)
                    <div class="list-group list-group-flush">
                        <a data-bs-toggle="collapse" @class(['active'=> request()->is($row->url), 'list-group-item list-group-item-action d-flex justify-content-between align-items-start'=>true]) aria-current="true" wire:navigate href="{{ url($row->url) }}">
                            <div class="fw-bold"><i class="{{ $row->icon }}"></i> {{ $row->translate ? __($row->translate) : $row->name }}</div>
                            <i class="bi bi-info-circle-fill text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $row->description }}"></i>
                        </a>
                    </div>
                @elseif($row->parent!=null && count($row->children->where('position','1'))==0)
                    <div class="list-group list-group-flush border-bottom">
                        <a data-bs-toggle="collapse" @class(['active'=> request()->is($row->url), 'list-group-item list-group-item-action d-flex justify-content-between align-items-start'=>true]) aria-current="true" wire:navigate href="{{ url($row->url) }}">
                            <div class="fw-bold"><i class="{{ $row->icon }}"></i> {{ $row->translate ? __($row->translate) : $row->name }}</div>
                            <i class="bi bi-info-circle-fill text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $row->description }}"></i>
                        </a>
                    </div>
                @else
                    <div class="accordion-item">
            
                        <h2 class="accordion-header border-bottom" id="heading{{ $row->id }}">
                            <button class="px-3 accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $row->id }}" aria-expanded="false" aria-controls="collapseOne">
                                <div class="fw-bold"> <i class="{{ $row->icon }}"></i> {{ $row->translate ? __($row->translate) : $row->name }} </div>
                            </button>
                        </h2>
            
                        <div id="collapse{{ $row->id }}" class="accordion-collapse collapse show" aria-labelledby="heading{{ $row->id }}" >
                            <div class="list-group list-group-flush">
                        
                                @foreach($row->children->where('position','1') as $r)
                                    <a data-bs-toggle="collapse" @class(['active'=> request()->is($r->url), 'list-group-item list-group-item-action d-flex justify-content-between align-items-start'=>true]) aria-current="true" wire:navigate href="{{ url($r->url) }}">
                                        <div class="fw-bold"><i class="{{ $r->icon }}"></i> {{ $r->translate ? __($r->translate) : $r->name }}</div>
                                        <i class="bi bi-info-circle-fill text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $r->description }}"></i>
                                    </a>
                                @endforeach

                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            
        </div>

      
    </div>


</div>

{{-- @script --}}
<script>
    // myCollapse = document.getElementById('accordionExample')
    // bsCollapse = new bootstrap.Collapse(myCollapse, {
    //     toggle: false
    // })

    // collapseElementList = [].slice.call(document.querySelectorAll('.accordion .collapse'));
    // collapseList = collapseElementList.map(function (collapseEl) {
    //     return new bootstrap.Collapse(collapseEl)
    // });

    // window.addEventListener("resize", function() {
    //     if ( window.innerWidth <= 700 ) { 
          
    //         collapseElementList = [].slice.call(document.querySelectorAll('.accordion .collapse'));
    //         console.log(collapseElementList)
    //         collapseList = collapseElementList.map(function (collapseEl) {
    //             return new bootstrap.Collapse(collapseEl)
    //         });
    //     } 
    // })
    // window.mobileCheck = function() {
    //     const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    //     if (isMobile) {
    //         collapseElementList = [].slice.call(document.querySelectorAll('.accordion .collapse, #accordionExample'));
    //             console.log(collapseElementList)
    //             collapseList = collapseElementList.map(function (collapseEl) {
    //                 return new bootstrap.Collapse(collapseEl)
    //             });
    //     }
    // }
</script>
{{-- @endscript --}}