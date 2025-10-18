@extends('website.layout')
@section('content')
        <div class="container pb-5 mb-sm-4">
            <div class="pt-5">
                <div class="card py-3 mt-sm-3">
                    <div class="card-body text-center">
                        <h2 class="h4 pb-3" style="color:red">আপনার অর্ডারটি সফলভাবে সম্পন্ন হয়েছে আমাদের কল সেন্টার থেকে ফোন করে আপনার অর্ডারটি কনফার্ম করা হবে</h2>
                        <a class="btn btn-primary mt-3" href="{{url('/')}}">প্রোডাক্ট বাছাই করুন</a>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {

            $('#selectCourier').on('change',function (e) {
                var selectCourier = +$('#selectCourier option:selected').val();
                $.ajax({
                    type: "get",
                    url: "{{url('/updateDeliveryCharge')}}",
                    data: {
                        'selectCourier':selectCourier,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function () {
                        updateQuantity(0,0);
                    }
                });
            });

            $(document).on("click", "#orderConfirm", function () {
                constantValue = 0;
                var customerName = $('#customerName');
                var customerAddress = $('#customerAddress');
                var customerPhone = $('#customerPhone');
                var selectCourier = $('#selectCourier option:selected');
                if (!customerName.val()) {
                    customerName.addClass("has-error");
                    constantValue = 1;
                }
                if (!customerAddress.val()) {
                    customerAddress.addClass("has-error");
                    constantValue = 1;
                }
                if (!customerPhone.val()) {
                    customerPhone.addClass("has-error");
                    constantValue = 1;
                }
                console.log(selectCourier.val())
                if (selectCourier.val() === '') {
                    selectCourier.addClass("has-error");
                    showFrontendAlert('error', 'Unsuccessful to Place order');
                    constantValue = 1;
                }
                if (constantValue === 1) {
                    $('html, body').animate(  {  scrollTop: $('body').position().top  },  500   );
                } else {
                    $.ajax({
                        type: "post",
                        url: "{{url('/placeOrder')}}",
                        data: {
                            'customerName': customerName.val(),
                            'customerAddress': customerAddress.val(),
                            'customerPhone': customerPhone.val(),
                            'selectCourier': selectCourier.val(),
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function (data) {
                            if(data['status'] === 'success'){
                                showFrontendAlert('success', 'Successfully Place order');
                                window.location.href = data['link'];

                            }else{
                                showFrontendAlert('error', 'Unsuccessful to Place order');

                            }
                        }
                    });
                }
            });
        });
    </script>

@endpush

