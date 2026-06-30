<div id="outletDisplaySection" style="margin-top:20px;">

    @if($pepsi_rural_new_outlets->count() > 0)
        <h4 style="text-decoration:underline; margin-bottom:10px;">
            Outlets Captured
        </h4>

        <div id="outletList">
            <div id="mainFormContainer"></div>

            @foreach($pepsi_rural_new_outlets as $pv)
                @if($pv->outlet_name != '')
                    <div class="store-card" id="row_{{ $pv->refid }}"
                        style="background:#fff; border:1px solid #e0e0e0; padding:12px; border-radius:6px; margin-bottom:10px; display:flex; justify-content:space-between; align-items:center;">

                        <div class="store-info">
                            <div class="store-name" style="font-weight:bold; font-size:12px;">
                                {{ $loop->iteration }}. {{ ucfirst($pv->outlet_name) }}
                            </div>

                            <div class="store-details" style="margin-top:5px;">
                                <span style="color:rgb(206,86,29); font-weight:bold;">Pepsi Visible :</span>
                                <strong>
                                    {{ $pv->is_pepsico_stock == 'Yes' ? 'Yes' : 'No' }}
                                    |
                                    <span style="color:rgb(206,86,29); font-weight:bold;">Type :</span>
                                    {{ ucfirst($pv->outlet_type) }}
                                </strong>
                            </div>

                            <div style="margin-top:10px;">
                                @if(!empty($pv->image))
                                    <img src="{{ asset($pv->image) }}" alt="Outlet Image"
                                        style="width:60px; height:60px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                                @else
                                    <img src="{{ asset('shop_image/pepsi/rural/storeimage-placeholder.jpg') }}" 
                                        alt="Default Image"
                                        style="width:60px; height:60px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                                @endif
                            </div>
                        </div>

                        <!-- EDIT BUTTON -->
                        <button class="btn btn-primary editBtn"
                            data-id="{{ $pv->refid }}"
                            data-name="{{ $pv->outlet_name }}"
                            data-stock="{{ $pv->is_pepsico_stock }}"
                            data-stock_from="{{ $pv->is_pepsico_stock_channel }}"
                            data-geo_address="{{ $pv->geo_address }}"
                            data-type="{{ $pv->outlet_type }}"
                            data-index="{{ $loop->iteration }}"
                            style="font-size:16px; padding:10px 20px;">
                            Edit
                        </button>

                    </div>

                    <div id="formContainer-{{ $pv->refid }}" style="background-color: black !important;"></div>
                @endif
            @endforeach

    @else
        <div style="text-align:center; color:white;">
            No outlets captured yet
        </div>
    @endif

</div>