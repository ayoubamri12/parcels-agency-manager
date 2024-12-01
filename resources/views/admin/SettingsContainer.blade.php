<link rel="stylesheet" href="{{ asset('assets/css/Settings.css') }}">

<x-layout>
    <div class="holder">
        <div id="loaderHolder" style="display: none" class="loading">
            <p class="loader"></p>
        </div>
        <div class="main-content">
            <h1>Settings <span class="rotate"><i class="icon ph-bold ph-gear"></i></span></h1>
            <div class="tabs">
                <a class="tab-btn activebtn" onclick="showContent('clients')">General Settings</a>
                <a class="tab-btn" onclick="showContent('products')">Locations</a>
                <a class="tab-btn" onclick="showContent('Deliverymen')">Deliverymen</a>
            </div>
            <div class="content show" id="clients-content">
                @include('admin.settings')
            </div>
            <div class="content" id="products-content">
                @include('admin.locations')
            </div>
            <div class="content" id="Deliverymen-content">
                @include('admin.Deliverymenlist')
            </div>
        </div>
    </div>
</x-layout>
<script>
    function showContent(type) {
    const allContents = document.querySelectorAll('.content');
    const allTabs = document.querySelectorAll('.tab-btn');

    // Hide all content sections
    allContents.forEach(content => content.classList.remove('show'));

    // Remove activebtn state from all tabs
    allTabs.forEach(tab => tab.classList.remove('activebtn'));

    // Show selected content
    const selectedContent = document.getElementById(`${type}-content`);
    selectedContent.classList.add('show');

    // Add activebtn state to the selected tab
    const selectedTab = document.querySelector(`.tab-btn[onclick="showContent('${type}')"]`);
    if (selectedTab) {
        selectedTab.classList.add('activebtn');
    }
}
</script>
<script src="{{asset('/assets/js/settings.js')}}"></script>
