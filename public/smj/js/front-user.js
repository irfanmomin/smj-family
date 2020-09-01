var SMJ = {
    Family: {
        init: function() {
            $(".panel-heading.panelHeader").click(function(){
                $(".glyphicon").toggleClass("glyphicon-minus", "glyphicon-plus");
            });

            $('input[type=radio][name=doc_type]').on('click', function(event){
                var clickedEle = $(this).val();
                if ( clickedEle == 'aadhar' ) {
                    $('.election-box').hide();
                    $('.aadhar-box').show();
                    $('.election-box input').val('');
                } else if (clickedEle == 'election' ) {
                    $('.election-box').show();
                    $('.aadhar-box').hide();
                    $('.aadhar-box input').val('');
                }
            });


            // Expired Member Page JS
            $(document).on('click', '.next-btn', function() {
                $('.loading').show();
                $('#newmainmember').val($('#choose_main_member_selectbox option:selected').val());
                $('#choose_main_member_selectbox').addClass('field_disabled').attr('readonly', 'readonly');
                $('#choose_main_member_selectbox option').attr('disabled', 'disabled');
                $('.select-after').removeClass('area_hidden');

                $.each($('.benef-detail-row'), function(k , value) {
                    var selectedID = $('#choose_main_member_selectbox option:selected').val();
                    if ($(this).hasClass('member_'+selectedID)) {
                        $(this).remove();
                    }
                });
                $('.loading').hide();
            });
        }
    },
    Utility: {
        Datepicker: {
            init: function() {
                $(".eremitdatepicker").dateDropdowns({
                    defaultDate: null,
                    defaultDateFormat: "dd-mm-yyyy",
                    submitFormat: "yyyy-mm-dd",
                    monthFormat: "short",
                    daySuffixes: false,
                    required: true,
                });
            }
        },
    }
}