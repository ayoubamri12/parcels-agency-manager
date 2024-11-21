<style>
    .deliveryman-section {
        display: flex;
        justify-content: center;
        min-height: 100vh;
        background-color: #f4f4f9;
        padding: 20px;
    }

    #lock i {
        font-size: 1.5rem;
        margin-bottom: 10px;
        animation: bounce 1.5s infinite;

    }

    @keyframes bounce {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    /* Container for Cards */
    .card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        max-width: 1200px;
        width: 100%;
        justify-content: center;
    }

    /* Individual Card Styling */
    .card {
        background-color: #ffffff;
        border-radius: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        padding: 10px;
        overflow: hidden;
        width: 100%;
        max-width: 300px;
        height: 100px;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    /* Image Styling */
    /*.deliveryman-section   .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }*/

    /* Card Content */
    .card-content {
        padding: 20px;
    }

    /* Deliveryman Name */
    .card h3 {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 10px;
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        z-index: 1000;
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.modal-active {
        opacity: 1;
        visibility: visible;
    }

    /* Modal styling */
    .modal-container {
        background-color: #fff3cd;
        color: #856404;
        width: 90%;
        max-width: 400px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 15px 30px rgba(0, 0, 0, 0.2);
        text-align: center;
        transform: scale(0.9);
        opacity: 0;
        transition: all 0.3s ease;
        position: relative;
    }

    .modal-overlay.modal-active .modal-container {
        transform: scale(1);
        opacity: 1;
    }

    /* Warning Icon */
    .modal-icon {
        font-size: 70px;
        color: #856404;
        margin-bottom: 15px;
    }

    /* Modal header */
    .modal-header {
        font-size: 1.5em;
        margin-bottom: 15px;
    }

    /* Modal content */
    .modal-content {
        color: #f7483b;
        font-size: 1em;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    /* Buttons */
    .modal-buttons {
        display: flex;
        justify-content: space-between;
    }

    .modal-btn {
        padding: 10px 20px;
        font-size: 1em;
        cursor: pointer;
        border: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        min-width: 100px;
    }

    .modal-btn.cancel {
        background-color: #f8d7da;
        color: #721c24;
    }

    .modal-btn.cancel:hover {
        background-color: #f5c6cb;
    }

    .modal-btn.confirm {
        background-color: #ffeeba;
        color: #856404;
    }

    .modal-btn.confirm:hover {
        background-color: #ffdd99;
    }

    /* Deliveryman City */
    /* .card p {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 15px;
        }*/

    /* Contact Button */
    /*   .card .contact-btn {
            background-color: #4a90e2;
            color: #ffffff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9rem;
            transition: background-color 0.3s ease;
            display: inline-block;
        }*/

    /* .card .contact-btn:hover {
            background-color: #357ab8;
        }*/

    /* Responsive Design */
    @media (min-width: 768px) {
        .card-container {
            gap: 30px;
        }
        .modal-overlay {
            height: 100vh;
        }
    }
</style>
<x-layout>
    <div class="deliveryman-section">
        <div id="cntr" class="card-container">

            <!-- Sample Card 2 -->
            @foreach ($dvs as $dv)
                <div class="card pb-3">
                    @if (!auth()->check())
                        <a href="#" id="{{$dv->id}}" class="cardBtn d-block h-100 w-100" style="text-decoration: none;">
                        @else
                            @if (auth()->user()->type === 'admin' || auth()->user()->delivery_id === $dv->id)
                                <a href="{{route("deliverymen.parcels",$dv->id)}}" class="d-block h-100 w-100" style="text-decoration: none;">
                            @else
                                    <a href="#" class="cardBtn d-block h-100 w-100"
                                        style="text-decoration: none;">
                            @endif
                    @endif
                    <div class="card-content">
                        <h3>{{ $dv->name }}</h3>
                        {{-- <p>City: Los Angeles</p> --}}
                        {{-- <a href="#" class="contact-btn">Contact</a> --}}
                        <div id="lock" class="d-flex justify-content-end">
                            @if (auth()->check())
                                @if (auth()->user()->type === 'admin')
                                    <i class="fas fa-lock-open" style="color: greenyellow"></i>
                                @elseif (auth()->user()->delivery_id !== $dv->id)
                                    <i class="fas fa-lock" style="color: red"></i>
                                @else
                                    <i class="fas fa-lock-open" style="color: greenyellow"></i>
                                @endif
                            @else
                                <i class="fas fa-lock" style="color: red"></i>
                            @endif
                        </div>
                    </div>

                    </a>
                </div>
                <div class="modal-overlay">
                    <div class="modal-container">
                        <div class="modal-icon">⚠️</div>
                        <div class="modal-header">Security Alert</div>
                        <div class="modal-content">
                            {{ auth()->check()
                                ? 'The current user has no access to this session '
                                : " We detected an access attempt from an unknown user. Please confirm your athentication to
                                                                                                                                                                                                                    proceed." }}
                        </div>
                        <div class="modal-buttons">
                            <button class="modal-btn cancel" onclick="closeModal(this)">Cancel</button>
                            @if (!auth()->check())
                                <a href="{{ route('login') }}" class="modal-btn confirm">Confirm</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</x-layout>

    <script>
        const tags = $("#cntr a.cardBtn");
        console.log(tags);

        tags.each(function(e) {
            $(this).on('click', function(e) {
                console.log(this);
                e.preventDefault();
                // Add the 'modal-active' class to the next '.modal-overlay' element
                $(this).parents("div").next('.modal-overlay').addClass('modal-active');
            });
        });

        function closeModal(e) {
            const modalOverlay = e.closest("div.modal-overlay");
            if (modalOverlay) {
                modalOverlay.classList.remove('modal-active');
            }
        }
    </script>
