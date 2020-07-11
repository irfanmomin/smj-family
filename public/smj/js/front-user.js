var SMJ = {
    Family: {
        init: function() {
            console.log('create page');
            $(".panel-heading.panelHeader").click(function(){
                $(".glyphicon").toggleClass("glyphicon-minus", "glyphicon-plus");
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