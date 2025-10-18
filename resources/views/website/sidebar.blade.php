<aside class="website-sidebar sticky-sidebar">
    <nav class="sidebar-nav">
        <ul class="sidebar-menu fixed-links">
            <li><a href="{{ url('category/dhamaka-offer') }}"><i class="fas fa-gift me-2"></i> Offers</a></li>
            <li><a href="{{ url('/flash-product') }}"><i class="fas fa-bolt me-2"></i> Flash Sale</a></li>
            <li><a href="{{ url('/shop') }}"><i class="fas fa-star me-2"></i> Premium Club</a></li>
            <li><a href="{{ url('/shop') }}"><i class="fas fa-tags me-2"></i> Shop by Brand</a></li>
            <li><a href="{{ url('/shop') }}"><i class="fas fa-newspaper me-2"></i> Blogs</a></li>
        </ul>
        <div class="sidebar-separator"></div>
        @php $categoryMenu = Menu::getAllCategories('Category Menu'); @endphp
        @if($categoryMenu)
        <ul class="sidebar-menu categories-list">
            @foreach($categoryMenu as $menu)
            <li><a href="{{ $menu['link'] }}"><i class="fa fa-dot-circle-o me-2"></i>{{ $menu['label'] }}</a></li>
            @endforeach
        </ul>
        @endif
    </nav>
</aside>

@push('css')
<style>
    .sticky-sidebar { position: sticky; position: -webkit-sticky; top: 120px; z-index: 1010; }
    @media (max-width: 991.98px) { .sticky-sidebar { top: 95px; } }
    .website-sidebar { height: calc(100vh - 120px); overflow-y: auto; overscroll-behavior: contain; }
    @media (max-width: 991.98px) { .website-sidebar { height: calc(100vh - 95px); } }
    /* Custom scrollbar just for the sidebar */
    .website-sidebar::-webkit-scrollbar { width: 8px; }
    .website-sidebar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
    .website-sidebar::-webkit-scrollbar-track { background: #f1f5f9; }
    .website-sidebar { scrollbar-width: thin; scrollbar-color: #cbd5e1 #f1f5f9; }

    .sidebar-nav { padding: 8px 0; }
    .sidebar-menu { list-style: none; margin: 0; padding: 0; }
    .sidebar-menu li a { display: flex; align-items: center; padding: 8px 10px; color: #222; text-decoration: none; border-radius: 4px; }
    .sidebar-menu li a:hover { background: #f5f7fb; color: #000; }
    .sidebar-separator { height: 1px; background: #e9ecef; margin: 10px 0; }
</style>
@endpush