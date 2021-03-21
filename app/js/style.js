function contributions(evt, contributionType) {

    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");

    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(contributionType).style.display = "block";
    evt.currentTarget.className += " active";

}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

(function ($) {
    jQuery(function () {

        $('.increase-deposits').hide();

        $('#customSwitch1').on('click', function () {

            if ($(this).prop('checked')) {

                $('.increase-deposits').show();

            } else {

                $('.increase-deposits').hide();
            }
        });

        $('.increase-withdrawals').hide();

        $('#customSwitch2').on('click', function () {

            if ($(this).prop('checked')) {

                $('.increase-withdrawals').show();

            } else {

                $('.increase-withdrawals').hide();
            }
        });

        $('.deposit-made-at').hide();

        $('.deposit-amount').on('keyup', function(){
            $('.deposit-made-at').show();
        });
        
        $('.withdrawal-made-at').hide();

        $('.withdrawal-amount').on('keyup', function(){
            $('.withdrawal-made-at').show();
        });
    });
})(jQuery)