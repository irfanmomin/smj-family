var SMJ = {
    Family: {
        init: function() {
            console.log('create page');
            $(".panel-heading.panelHeader").click(function(){
                $(".glyphicon").toggleClass("glyphicon-minus", "glyphicon-plus");
            });

            /* $('.aadhar_id_field').keyup(function() {
                var foo = $(this).val().split("-").join(""); // remove hyphens
                if (foo.length > 0) {
                  foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
                }
                $(this).val(foo);
            }); */

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

                /* if ($(this).prop('checked') == true) {
                    console.log('inside');

                    if ($('.custom_amt_aud').length > 4) {
                        $('#loadingDiv').show();
                    }
                    Eremit.MultiBenefPage.paymentMethodChangeEventMultiBenef();
                    if ($('.custom_amt_aud').length > 4) {
                        setTimeout(() => {
                            $('#loadingDiv').hide();
                        }, 2000);
                    }
                } */
            });

            /* $("#family-main-form-next").on('click', function() {
                event.preventDefault();
                if ($("#create-new-family").valid() == false ) {
                    return false;
                }

                $('#family-main-member-confirmation .modal-title').html('<span>Hello world</span>');
                $('#family-main-member-confirmation').modal('show');
                return;
            }); */
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